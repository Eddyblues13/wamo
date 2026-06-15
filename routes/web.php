<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\InvestmentController;
use App\Http\Controllers\User\TradeController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\InvestmentPlanController as AdminPlanController;
use App\Http\Controllers\Admin\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\DepositMethodController as AdminDepositMethodController;
use App\Http\Controllers\Admin\DepositController as AdminDepositController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->name('home');

// Product
Route::view('/markets', 'pages.markets')->name('markets');
Route::view('/invest', 'pages.invest')->name('invest');
Route::view('/stocks', 'pages.stocks')->name('stocks');
Route::view('/trading', 'pages.trading')->name('trading');
Route::view('/crypto', 'pages.crypto')->name('crypto');
Route::view('/forex', 'pages.forex')->name('forex');
Route::view('/real-estate', 'pages.real-estate')->name('real-estate');

// Company
Route::view('/about', 'pages.about')->name('about');
Route::view('/careers', 'pages.careers')->name('careers');
Route::view('/press', 'pages.press')->name('press');
Route::view('/blog', 'pages.blog')->name('blog');
Route::view('/security', 'pages.security')->name('security');

// Legal
Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/disclosures', 'legal.disclosures')->name('disclosures');

// Guest authentication
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Email verification (authenticated, not yet verified)
Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::post('/verify-email', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/verify-email/resend', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')->name('verification.resend');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// User dashboard (authenticated + verified)
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Investment plans
    Route::get('/invest', [InvestmentController::class, 'index'])->name('invest');
    Route::post('/invest', [InvestmentController::class, 'store'])->name('invest.store');

    // Trading desks
    Route::get('/stocks', [TradeController::class, 'stocks'])->name('stocks');
    Route::get('/forex', [TradeController::class, 'forex'])->name('forex');
    Route::get('/crypto', [TradeController::class, 'crypto'])->name('crypto');
    Route::post('/trade', [TradeController::class, 'store'])->name('trade');

    // Deposit
    Route::get('/deposit', [WalletController::class, 'depositForm'])->name('deposit');
    Route::post('/deposit', [WalletController::class, 'deposit'])->name('deposit.store');

    // Withdraw
    Route::get('/withdraw', [WalletController::class, 'withdrawForm'])->name('withdraw');
    Route::post('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw.store');

    // Transactions / wallet history
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
});

/*
|--------------------------------------------------------------------------
| Admin area (separate "admin" guard / multi-auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/funds', [AdminUserController::class, 'adjustFunds'])->name('users.funds');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Investment plans (full CRUD)
        Route::resource('plans', AdminPlanController::class)->except(['show']);

        // Investments
        Route::get('/investments', [AdminInvestmentController::class, 'index'])->name('investments.index');
        Route::post('/investments/{investment}/payout', [AdminInvestmentController::class, 'payout'])->name('investments.payout');

        // Transactions
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');

        // Deposit requests (approval queue)
        Route::get('/deposits', [AdminDepositController::class, 'index'])->name('deposits.index');
        Route::post('/deposits/{deposit}/approve', [AdminDepositController::class, 'approve'])->name('deposits.approve');
        Route::post('/deposits/{deposit}/reject', [AdminDepositController::class, 'reject'])->name('deposits.reject');

        // Deposit methods (crypto wallets / bank accounts)
        Route::resource('deposit-methods', AdminDepositMethodController::class)->except(['show']);
    });
});
