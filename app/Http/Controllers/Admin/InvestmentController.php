<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserInvestment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvestmentController extends Controller
{
    public function index(): View
    {
        $investments = UserInvestment::with(['user', 'plan'])->latest()->paginate(20);

        return view('admin.investments.index', compact('investments'));
    }

    /**
     * Pay out an investment immediately (principal + return) and complete it.
     */
    public function payout(UserInvestment $investment): RedirectResponse
    {
        if ($investment->status !== 'active') {
            return back()->withErrors(['investment' => 'This investment is not active.']);
        }

        DB::transaction(function () use ($investment): void {
            $payout = (float) $investment->amount + (float) $investment->expected_return;

            $investment->user->credit($payout, 'return', "Admin payout: {$investment->plan->name} plan");
            $investment->update(['status' => 'completed']);
        });

        return back()->with('status', 'Investment paid out and completed.');
    }

    /**
     * Adjust the expected return (profit) on an active investment.
     * A positive amount increases the return, a negative amount reduces it.
     */
    public function adjustProfit(Request $request, UserInvestment $investment): RedirectResponse
    {
        if ($investment->status !== 'active') {
            return back()->with('error', 'This investment is not active.');
        }

        $validated = $request->validate([
            'profit' => ['required', 'numeric', 'min:-1000000', 'max:1000000'],
        ]);

        $newReturn = max(0.0, (float) $investment->expected_return + round((float) $validated['profit'], 2));
        $investment->update(['expected_return' => $newReturn]);

        return back()->with('status', 'Investment return updated.');
    }
}
