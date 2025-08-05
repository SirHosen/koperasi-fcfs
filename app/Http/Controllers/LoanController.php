<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Notification;
use App\Http\Requests\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with('member.user');

        if (Auth::user()->isMember()) {
            $query->where('member_id', Auth::user()->member->id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('member.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('loan_number', 'like', "%{$search}%");
        }

        // FCFS implementation - order by request date
        $loans = $query->orderBy('request_date', 'asc')->paginate(10);

        $view = Auth::user()->isAdmin() ? 'admin.loans.index' : 'member.loans.index';
        return view($view, compact('loans'));
    }

    public function create()
    {
        if (Auth::user()->isAdmin()) {
            $members = Member::with('user')->where('status', 'active')->get();
            return view('admin.loans.create', compact('members'));
        }

        return view('member.loans.create');
    }

    public function store(LoanRequest $request)
    {
        DB::beginTransaction();
        try {
            $memberId = Auth::user()->isAdmin() ? $request->member_id : Auth::user()->member->id;
            $member = Member::findOrFail($memberId);

            // Check if member has active loan
            $hasActiveLoan = $member->loans()
                ->whereIn('status', ['pending', 'approved'])
                ->where('remaining_payment', '>', 0)
                ->exists();

            if ($hasActiveLoan) {
                return back()->withErrors(['error' => 'Anggota masih memiliki pinjaman aktif.'])->withInput();
            }

            $loanNumber = 'LOAN' . date('Ymd') . str_pad(Loan::count() + 1, 3, '0', STR_PAD_LEFT);

            $interestRate = 1.5; // 1.5% per month
            $totalInterest = ($request->amount * $interestRate * $request->duration_months) / 100;
            $totalPayment = $request->amount + $totalInterest;
            $monthlyPayment = $totalPayment / $request->duration_months;

            $loan = Loan::create([
                'member_id' => $memberId,
                'loan_number' => $loanNumber,
                'amount' => $request->amount,
                'duration_months' => $request->duration_months,
                'interest_rate' => $interestRate,
                'monthly_payment' => $monthlyPayment,
                'total_payment' => $totalPayment,
                'remaining_payment' => $totalPayment,
                'purpose' => $request->purpose,
                'status' => 'pending',
                'request_date' => now(),
            ]);

            // Create notification
            Notification::create([
                'user_id' => $member->user_id,
                'title' => 'Pengajuan Pinjaman',
                'message' => 'Pengajuan pinjaman Anda sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' sedang dalam proses review.',
                'type' => 'info',
            ]);

            DB::commit();

            $redirectRoute = Auth::user()->isAdmin() ? 'admin.loans.index' : 'member.loans.index';
            return redirect()->route($redirectRoute)->with('success', 'Pengajuan pinjaman berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Loan $loan)
    {
        if (Auth::user()->isMember() && $loan->member_id !== Auth::user()->member->id) {
            abort(403);
        }

        $loan->load('member.user', 'payments');

        $view = Auth::user()->isAdmin() ? 'admin.loans.show' : 'member.loans.show';
        return view($view, compact('loan'));
    }

    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->withErrors(['error' => 'Pinjaman ini sudah diproses.']);
        }

        DB::beginTransaction();
        try {
            $loan->update([
                'status' => 'approved',
                'approval_date' => now(),
                'approved_by' => Auth::user()->name,
            ]);

            // Create payment schedule
            for ($i = 1; $i <= $loan->duration_months; $i++) {
                Payment::create([
                    'loan_id' => $loan->id,
                    'payment_code' => 'PAY' . date('Ymd') . $loan->id . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'installment_number' => $i,
                    'amount' => $loan->monthly_payment,
                    'payment_date' => now()->addMonths($i),
                    'status' => 'pending',
                ]);
            }

            // Create notification
            Notification::create([
                'user_id' => $loan->member->user_id,
                'title' => 'Pinjaman Disetujui',
                'message' => 'Selamat! Pinjaman Anda sebesar Rp ' . number_format($loan->amount, 0, ',', '.') . ' telah disetujui.',
                'type' => 'success',
            ]);

            DB::commit();
            return redirect()->route('admin.loans.show', $loan)->with('success', 'Pinjaman berhasil disetujui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function reject(Request $request, Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->withErrors(['error' => 'Pinjaman ini sudah diproses.']);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $loan->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);

            // Create notification
            Notification::create([
                'user_id' => $loan->member->user_id,
                'title' => 'Pinjaman Ditolak',
                'message' => 'Mohon maaf, pinjaman Anda ditolak. Alasan: ' . $request->rejection_reason,
                'type' => 'danger',
            ]);

            DB::commit();
            return redirect()->route('admin.loans.index')->with('success', 'Pinjaman berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function payment(Request $request, Loan $loan)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
        ]);

        $payment = Payment::findOrFail($request->payment_id);

        if ($payment->loan_id !== $loan->id) {
            return back()->withErrors(['error' => 'Payment tidak valid.']);
        }

        if ($payment->status === 'paid') {
            return back()->withErrors(['error' => 'Angsuran ini sudah dibayar.']);
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'status' => 'paid',
                'payment_date' => now(),
                'received_by' => Auth::user()->name,
            ]);

            $loan->decrement('remaining_payment', $payment->amount);

            if ($loan->remaining_payment <= 0) {
                $loan->update(['status' => 'paid']);
            }

            // Create notification
            Notification::create([
                'user_id' => $loan->member->user_id,
                'title' => 'Pembayaran Berhasil',
                'message' => 'Pembayaran angsuran ke-' . $payment->installment_number . ' sebesar Rp ' . number_format($payment->amount, 0, ',', '.') . ' telah berhasil.',
                'type' => 'success',
            ]);

            DB::commit();
            return back()->with('success', 'Pembayaran berhasil diproses.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
