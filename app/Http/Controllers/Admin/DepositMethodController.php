<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepositMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepositMethodController extends Controller
{
    public function index(): View
    {
        $methods = DepositMethod::orderBy('sort_order')->paginate(15);

        return view('admin.deposit-methods.index', compact('methods'));
    }

    public function create(): View
    {
        return view('admin.deposit-methods.create', ['method' => new DepositMethod(['type' => 'crypto', 'is_active' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        DepositMethod::create($this->validateData($request));

        return redirect()->route('admin.deposit-methods.index')->with('status', 'Deposit method created.');
    }

    public function edit(DepositMethod $depositMethod): View
    {
        return view('admin.deposit-methods.edit', ['method' => $depositMethod]);
    }

    public function update(Request $request, DepositMethod $depositMethod): RedirectResponse
    {
        $depositMethod->update($this->validateData($request));

        return redirect()->route('admin.deposit-methods.index')->with('status', 'Deposit method updated.');
    }

    public function destroy(DepositMethod $depositMethod): RedirectResponse
    {
        $depositMethod->delete();

        return redirect()->route('admin.deposit-methods.index')->with('status', 'Deposit method deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:crypto,bank'],
            'code' => ['nullable', 'string', 'max:20'],
            'network' => ['nullable', 'string', 'max:60'],
            'address' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'instructions' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:16'],
            'min_amount' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}
