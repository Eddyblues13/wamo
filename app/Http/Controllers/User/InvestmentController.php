<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use App\Models\UserInvestment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvestmentController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $user = $request->user();
        $investments = $user->investments()->with('plan')->get();

        return view('user.invest', [
            'user' => $user,
            'plans' => InvestmentPlan::active()->get(),
            'investments' => $investments,
            'totalInvested' => $investments->where('status', 'active')->sum('amount'),
            'expectedReturns' => $investments->where('status', 'active')->sum('expected_return'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'investment_plan_id' => ['required', 'exists:investment_plans,id'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $plan = InvestmentPlan::active()->findOrFail($validated['investment_plan_id']);
        $amount = round((float) $validated['amount'], 2);
        $user = $request->user();

        if ($amount < (float) $plan->min_amount || $amount > (float) $plan->max_amount) {
            throw ValidationException::withMessages([
                'amount' => "Amount must be between \${$plan->min_amount} and \${$plan->max_amount} for the {$plan->name} plan.",
            ]);
        }

        if ($amount > (float) $user->balance) {
            throw ValidationException::withMessages([
                'amount' => 'Insufficient wallet balance. Please add funds first.',
            ]);
        }

        DB::transaction(function () use ($user, $plan, $amount): void {
            $user->debit($amount, 'investment', "Investment in {$plan->name} plan");

            UserInvestment::create([
                'user_id' => $user->id,
                'investment_plan_id' => $plan->id,
                'amount' => $amount,
                'expected_return' => $plan->returnFor($amount),
                'status' => 'active',
                'started_at' => Carbon::now(),
                'matures_at' => Carbon::now()->addDays($plan->duration_days),
            ]);
        });

        return redirect()->route('user.dashboard')
            ->with('status', "Your {$plan->name} investment is now active.");
    }
}
