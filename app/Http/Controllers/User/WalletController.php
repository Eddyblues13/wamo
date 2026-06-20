<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use App\Models\DepositMethod;
use App\Models\DepositRequest;
use App\Models\WithdrawalRequest;
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
            'recent' => $request->user()->withdrawalRequests()->take(6)->get(),
            'available' => $request->user()->availableForWithdrawal(),
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

        NotificationMail::deliver(
            $request->user(),
            'Deposit request received',
            'Your deposit is pending',
            ['We have received your deposit request and it is now pending confirmation.'],
            [
                'Amount' => '$'.number_format($amount, 2),
                'Method' => $method->name,
                'Status' => 'Pending',
            ],
            'Your wallet will be credited as soon as your payment is confirmed by our team.',
        );

        return redirect()->route('user.deposit')->with('processing', true);
    }

    public function withdraw(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:10'],
            'method' => ['required', 'in:bank,crypto'],
            'account_name' => ['required_if:method,bank', 'nullable', 'string', 'max:120'],
            'bank_name' => ['required_if:method,bank', 'nullable', 'string', 'max:120'],
            'account_number' => ['required_if:method,bank', 'nullable', 'string', 'max:60'],
            'swift_code' => ['required_if:method,bank', 'nullable', 'string', 'max:60'],
            'crypto_network' => ['required_if:method,crypto', 'nullable', 'string', 'max:60'],
            'wallet_address' => ['required_if:method,crypto', 'nullable', 'string', 'max:191'],
        ]);

        $user = $request->user();
        $amount = round((float) $validated['amount'], 2);

        if ($amount > $user->availableForWithdrawal()) {
            throw ValidationException::withMessages([
                'amount' => 'This amount exceeds the funds available for withdrawal. You may have a pending request already.',
            ]);
        }

        $withdrawal = WithdrawalRequest::create([
            'user_id' => $user->id,
            'method' => $validated['method'],
            'amount' => $amount,
            'account_name' => $validated['account_name'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'swift_code' => $validated['swift_code'] ?? null,
            'crypto_network' => $validated['crypto_network'] ?? null,
            'wallet_address' => $validated['wallet_address'] ?? null,
            'status' => 'pending',
        ]);

        NotificationMail::deliver(
            $user,
            'Withdrawal request received',
            'Your withdrawal is pending review',
            ['We have received your withdrawal request. It is now pending approval by our team.'],
            [
                'Amount' => '$'.number_format($amount, 2),
                'Destination' => $withdrawal->methodLabel(),
                'Status' => 'Pending',
            ],
            'Your funds remain in your wallet until the request is approved. You will be notified once it is processed.',
        );

        return redirect()->route('user.withdraw')
            ->with('status', 'Your withdrawal request has been submitted and is pending approval.');
    }
}
