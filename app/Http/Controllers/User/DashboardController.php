<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $investments = $user->investments()->with('plan')->get();

        return view('user.dashboard', [
            'user' => $user,
            'plans' => InvestmentPlan::active()->get(),
            'investments' => $investments,
            'totalInvested' => $investments->where('status', 'active')->sum('amount'),
            'expectedReturns' => $investments->where('status', 'active')->sum('expected_return'),
            'activeCount' => $investments->where('status', 'active')->count(),
            'recentTransactions' => $user->transactions()->take(5)->get(),
        ]);
    }
}
