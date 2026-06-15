<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DepositMethod;
use App\Models\DepositRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function index(Request $request): View
    {
        return view('user.wallet', [
            'user' => $request->user(),
            'transactions' => $request->user()->transactions()->paginate(15),
        ]);
    }

    public function depositForm(Request $request): View
    {
        return view('user.deposit', [
            'user' => $request->user(),
            'methods' => DepositMethod::active()->get(),
            'requests' => $request->user()->depositRequests()->with('method')->take(8)->get(),
        ]);
    }

    public function withdrawForm(Request $request): View
    {
        return view('user.withdraw', [
            'user' => $request->user(),
            'recent' => $request->user()->transactions()->where('type', 'withdrawal')->take(5)->get(),
        ]);
    }

    public function deposit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'deposit_method_id' => ['required', 'exists:deposit_methods,id'],
            'amount' => ['required', 'numeric', 'min:1', 'max:1000000'],
            'reference' => ['nullable', 'string', 'max:255'],
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);

        $method = DepositMethod::active()->findOrFail($validated['deposit_method_id']);
        $amount = round((float) $validated['amount'], 2);

        if ($amount < (float) $method->min_amount) {
            throw ValidationException::withMessages([
                'amount' => "The minimum deposit for {$method->name} is \${$method->min_amount}.",
            ]);
        }

        $proofPath = $request->file('proof')->store('proofs', 'public');

        DepositRequest::create([
            'user_id' => $request->user()->id,
            'deposit_method_id' => $method->id,
            'method_label' => $method->name,
            'amount' => $amount,
            'reference' => $validated['reference'] ?? null,
            'proof_path' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->route('user.deposit')->with('processing', true);
    }

    public function withdraw(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:10'],
            'method' => ['nullable', 'string', 'max:60'],
        ]);

        $amount = (float) $validated['amount'];

        if ($amount > (float) $request->user()->balance) {
            throw ValidationException::withMessages([
                'amount' => 'You cannot withdraw more than your available balance.',
            ]);
        }

        $method = $validated['method'] ?? 'Bank transfer';
        $request->user()->debit($amount, 'withdrawal', "Withdrawal · {$method}");

        return redirect()->route('user.withdraw')->with('status', 'Your withdrawal has been processed.');
    }
}
