<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvestmentPlanController extends Controller
{
    public function index(): View
    {
        $plans = InvestmentPlan::withCount('investments')->orderBy('sort_order')->paginate(15);

        return view('admin.plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('admin.plans.create', ['plan' => new InvestmentPlan]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(4));
        InvestmentPlan::create($data);

        return redirect()->route('admin.plans.index')->with('status', 'Plan created.');
    }

    public function edit(InvestmentPlan $plan): View
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, InvestmentPlan $plan): RedirectResponse
    {
        $plan->update($this->validateData($request));

        return redirect()->route('admin.plans.index')->with('status', 'Plan updated.');
    }

    public function destroy(InvestmentPlan $plan): RedirectResponse
    {
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('status', 'Plan deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:16'],
            'gradient' => ['nullable', 'string', 'max:255'],
            'min_amount' => ['required', 'numeric', 'min:0'],
            'max_amount' => ['required', 'numeric', 'gte:min_amount'],
            'roi_percent' => ['required', 'numeric', 'min:0', 'max:999'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'payout_interval' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}
