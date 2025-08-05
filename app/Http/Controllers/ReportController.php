<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Saving;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function savings(Request $request)
    {
        $query = Saving::with('member.user');

        if (Auth::user()->isMember()) {
            $query->where('member_id', Auth::user()->member->id);
        }

        if ($request->filled('start_date')) {
            $query->where('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('transaction_date', '<=', $request->end_date);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $savings = $query->orderBy('transaction_date', 'desc')->get();

        $totalDeposit = $savings->where('type', 'deposit')->sum('amount');
        $totalWithdrawal = $savings->where('type', 'withdrawal')->sum('amount');

        $view = Auth::user()->isAdmin() ? 'admin.reports.savings' : 'member.reports.savings';

        return view($view, compact('savings', 'totalDeposit', 'totalWithdrawal'));
    }

    public function loans(Request $request)
    {
        $query = Loan::with('member.user');

        if (Auth::user()->isMember()) {
            $query->where('member_id', Auth::user()->member->id);
        }

        if ($request->filled('start_date')) {
            $query->where('request_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('request_date', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->orderBy('request_date', 'desc')->get();

        $summary = [
            'total_loans' => $loans->count(),
            'total_amount' => $loans->sum('amount'),
            'approved' => $loans->where('status', 'approved')->count(),
            'pending' => $loans->where('status', 'pending')->count(),
            'rejected' => $loans->where('status', 'rejected')->count(),
            'paid' => $loans->where('status', 'paid')->count(),
        ];

        $view = Auth::user()->isAdmin() ? 'admin.reports.loans' : 'member.reports.loans';

        return view($view, compact('loans', 'summary'));
    }
}
