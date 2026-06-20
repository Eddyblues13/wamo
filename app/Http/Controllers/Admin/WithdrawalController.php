<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use App\Models\WithdrawalRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WithdrawalController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString() ?: 'pending';

        $requests = WithdrawalRequest::with('user')
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.withdrawals.index', [
            'requests' => $requests,
            'status' => $status,
            'pendingCount' => WithdrawalRequest::where('status', 'pending')->count(),
        ]);
    }

    public function approve(WithdrawalRequest $withdrawal): RedirectResponse
    {
        if (! $withdrawal->isPending()) {
            return back()->withErrors(['withdrawal' => 'This request has already been processed.']);
        }

        try {
            DB::transaction(function () use ($withdrawal): void {
                $withdrawal->user->debit((float) $withdrawal->amount, 'withdrawal', "Withdrawal · {$withdrawal->methodLabel()}");
                $withdrawal->update(['status' => 'approved', 'processed_at' => Carbon::now()]);
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['withdrawal' => 'The user no longer has sufficient balance for this withdrawal.']);
        }

        NotificationMail::deliver(
            $withdrawal->user,
            'Withdrawal approved',
            'Your withdrawal has been approved',
            ['Good news — your withdrawal request has been approved and is being processed to your destination.'],
            [
                'Amount' => '$'.number_format((float) $withdrawal->amount, 2),
                'Destination' => $withdrawal->methodLabel(),
                'Remaining balance' => '$'.number_format((float) $withdrawal->user->balance, 2),
            ],
            'Bank transfers may take 1–3 business days to settle. Crypto payouts are usually faster.',
        );

        return back()->with('status', 'Withdrawal approved and wallet debited.');
    }

    public function reject(Request $request, WithdrawalRequest $withdrawal): RedirectResponse
    {
        if (! $withdrawal->isPending()) {
            return back()->withErrors(['withdrawal' => 'This request has already been processed.']);
        }

        $withdrawal->update([
            'status' => 'rejected',
            'admin_note' => $request->string('admin_note')->toString() ?: null,
            'processed_at' => Carbon::now(),
        ]);

        NotificationMail::deliver(
            $withdrawal->user,
            'Withdrawal request declined',
            'Your withdrawal could not be processed',
            ['Your withdrawal request has been declined. No funds have been deducted from your wallet.'],
            [
                'Amount' => '$'.number_format((float) $withdrawal->amount, 2),
                'Destination' => $withdrawal->methodLabel(),
                'Status' => 'Rejected',
            ],
            'If you believe this is a mistake, please contact support.',
        );

        return back()->with('status', 'Withdrawal request rejected.');
    }
}
