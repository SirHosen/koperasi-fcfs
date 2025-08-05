<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

// Redirect root based on auth status
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('member.dashboard');
        }
    }
    return redirect()->route('login');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // Members management
    Route::resource('members', MemberController::class);

    // Savings management
    Route::resource('savings', SavingController::class);

    // Loans management
    Route::resource('loans', LoanController::class);
    Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    Route::post('/loans/{loan}/payment', [LoanController::class, 'payment'])->name('loans.payment');

    // Reports
    Route::get('/reports/savings', [ReportController::class, 'savings'])->name('reports.savings');
    Route::get('/reports/loans', [ReportController::class, 'loans'])->name('reports.loans');
});

// Member routes
Route::middleware(['auth', 'member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'memberDashboard'])->name('dashboard');

    // Savings
    Route::get('/savings', [SavingController::class, 'index'])->name('savings.index');
    Route::get('/savings/{saving}', [SavingController::class, 'show'])->name('savings.show');

    // Loans
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');

    // Reports
    Route::get('/reports/savings', [ReportController::class, 'savings'])->name('reports.savings');
    Route::get('/reports/loans', [ReportController::class, 'loans'])->name('reports.loans');
});
