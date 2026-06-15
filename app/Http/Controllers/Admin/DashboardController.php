<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserInvestment;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'verifiedCount' => User::whereNotNull('email_verified_at')->count(),
            'plansCount' => InvestmentPlan::count(),
            'walletTotal' => (float) User::sum('balance'),
            'activeInvestments' => UserInvestment::where('status', 'active')->count(),
            'totalInvested' => (float) UserInvestment::where('status', 'active')->sum('amount'),
            'expectedReturns' => (float) UserInvestment::where('status', 'active')->sum('expected_return'),
            'depositsTotal' => (float) Transaction::where('type', 'deposit')->sum('amount'),
            'withdrawalsTotal' => (float) Transaction::where('type', 'withdrawal')->sum('amount'),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentTransactions' => Transaction::with('user')->latest()->take(8)->get(),
        ]);
    }
}
