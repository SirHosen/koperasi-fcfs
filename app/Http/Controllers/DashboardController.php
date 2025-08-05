<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Saving;
use App\Models\Loan;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalMembers = Member::where('status', 'active')->count();
        $totalSavings = Saving::whereHas('member', function($q) {
            $q->where('status', 'active');
        })->sum('amount');

        $totalLoans = Loan::where('status', 'approved')->sum('amount');
        $pendingLoans = Loan::where('status', 'pending')->count();

        $recentTransactions = Saving::with('member.user')
            ->latest('transaction_date')
            ->take(5)
            ->get();

        $recentLoans = Loan::with('member.user')
            ->latest('request_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMembers',
            'totalSavings',
            'totalLoans',
            'pendingLoans',
            'recentTransactions',
            'recentLoans'
        ));
    }

    public function memberDashboard()
    {
        $user = Auth::user();
        $member = $user->member;

        if (!$member) {
            return redirect('/')->with('error', 'Data member tidak ditemukan.');
        }

        $currentBalance = $member->getCurrentBalance();

        $activeLoans = $member->loans()
            ->where('status', 'approved')
            ->where('remaining_payment', '>', 0)
            ->get();

        $totalLoanAmount = $activeLoans->sum('remaining_payment');

        $recentSavings = $member->savings()
            ->latest('transaction_date')
            ->take(5)
            ->get();

        $notifications = $user->notifications()
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();

        return view('member.dashboard', compact(
            'member',
            'currentBalance',
            'activeLoans',
            'totalLoanAmount',
            'recentSavings',
            'notifications'
        ));
    }
}
