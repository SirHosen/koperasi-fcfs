<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Saving;
use App\Models\Member;
use App\Models\Notification;
use App\Http\Requests\SavingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SavingController extends Controller
{
    public function index(Request $request)
    {
        $query = Saving::with('member.user');

        if (Auth::user()->isMember()) {
            $query->where('member_id', Auth::user()->member->id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('member.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('transaction_code', 'like', "%{$search}%");
        }

        $savings = $query->latest('transaction_date')->paginate(10);

        $view = Auth::user()->isAdmin() ? 'admin.savings.index' : 'member.savings.index';
        return view($view, compact('savings'));
    }

    public function create()
    {
        $members = Member::with('user')->where('status', 'active')->get();
        return view('admin.savings.create', compact('members'));
    }

    public function store(SavingRequest $request)
    {
        DB::beginTransaction();
        try {
            $member = Member::findOrFail($request->member_id);
            $currentBalance = $member->getCurrentBalance();

            if ($request->type === 'withdrawal' && $currentBalance < $request->amount) {
                return back()->withErrors(['amount' => 'Saldo tidak mencukupi.'])->withInput();
            }

            $newBalance = $request->type === 'deposit'
                ? $currentBalance + $request->amount
                : $currentBalance - $request->amount;

            $transactionCode = 'SAV' . date('Ymd') . str_pad(Saving::count() + 1, 3, '0', STR_PAD_LEFT);

            $saving = Saving::create([
                'member_id' => $request->member_id,
                'transaction_code' => $transactionCode,
                'type' => $request->type,
                'amount' => $request->amount,
                'balance' => $newBalance,
                'transaction_date' => $request->transaction_date ?? now(),
                'description' => $request->description,
                'created_by' => Auth::user()->name,
            ]);

            // Create notification
            $notifType = $request->type === 'deposit' ? 'Setoran' : 'Penarikan';
            Notification::create([
                'user_id' => $member->user_id,
                'title' => $notifType . ' Berhasil',
                'message' => $notifType . ' sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil diproses. Saldo Anda sekarang: Rp ' . number_format($newBalance, 0, ',', '.'),
                'type' => 'success',
            ]);

            DB::commit();
            return redirect()->route('admin.savings.index')->with('success', 'Transaksi simpanan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Saving $saving)
    {
        if (Auth::user()->isMember() && $saving->member_id !== Auth::user()->member->id) {
            abort(403);
        }

        $view = Auth::user()->isAdmin() ? 'admin.savings.show' : 'member.savings.show';
        return view($view, compact('saving'));
    }

    public function edit(Saving $saving)
    {
        $members = Member::with('user')->where('status', 'active')->get();
        return view('admin.savings.edit', compact('saving', 'members'));
    }

    public function update(SavingRequest $request, Saving $saving)
    {
        DB::beginTransaction();
        try {
            $saving->update([
                'transaction_date' => $request->transaction_date,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('admin.savings.index')->with('success', 'Data simpanan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Saving $saving)
    {
        $isLatest = !Saving::where('member_id', $saving->member_id)
            ->where('transaction_date', '>', $saving->transaction_date)
            ->exists();

        if (!$isLatest) {
            return back()->withErrors(['error' => 'Hanya transaksi terakhir yang dapat dihapus.']);
        }

        try {
            $saving->delete();
            return redirect()->route('admin.savings.index')->with('success', 'Transaksi simpanan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus.']);
        }
    }
}
