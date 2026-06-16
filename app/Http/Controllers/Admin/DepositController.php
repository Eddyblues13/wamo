<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use App\Models\DepositRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DepositController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString() ?: 'pending';

        $requests = DepositRequest::with(['user', 'method'])
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.deposits.index', [
            'requests' => $requests,
            'status' => $status,
            'pendingCount' => DepositRequest::where('status', 'pending')->count(),
        ]);
    }

    public function approve(DepositRequest $deposit): RedirectResponse
    {
        if (! $deposit->isPending()) {
            return back()->withErrors(['deposit' => 'This request has already been processed.']);
        }

        DB::transaction(function () use ($deposit): void {
            $deposit->user->credit((float) $deposit->amount, 'deposit', "Deposit · {$deposit->method_label}");
            $deposit->update(['status' => 'approved', 'processed_at' => Carbon::now()]);
        });

        NotificationMail::deliver(
            $deposit->user,
            'Deposit approved — funds credited',
            'Your deposit was approved',
            ['Great news — your deposit has been confirmed and credited to your wallet.'],
            [
                'Amount' => '$'.number_format((float) $deposit->amount, 2),
                'Method' => $deposit->method_label,
                'New balance' => '$'.number_format((float) $deposit->user->balance, 2),
            ],
            null,
            'Go to dashboard',
            route('user.dashboard'),
        );

        return back()->with('status', 'Deposit approved and wallet credited.');
    }

    public function reject(Request $request, DepositRequest $deposit): RedirectResponse
    {
        if (! $deposit->isPending()) {
            return back()->withErrors(['deposit' => 'This request has already been processed.']);
        }

        $deposit->update([
            'status' => 'rejected',
            'admin_note' => $request->string('admin_note')->toString() ?: null,
            'processed_at' => Carbon::now(),
        ]);

        return back()->with('status', 'Deposit request rejected.');
    }
}
