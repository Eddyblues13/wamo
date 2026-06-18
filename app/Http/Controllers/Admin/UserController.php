<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $users = User::query()
            ->when($search, fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->withCount('investments')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function show(User $user): View
    {
        return view('admin.users.show', [
            'user' => $user,
            'investments' => $user->investments()->with('plan')->get(),
            'transactions' => $user->transactions()->paginate(12, ['*'], 'tpage')->fragment('tab-transactions'),
            'deposits' => $user->depositRequests()->with('method')->paginate(10, ['*'], 'dpage')->fragment('tab-deposits'),
            'totalInvested' => (float) $user->investments()->where('status', 'active')->sum('amount'),
            'depositsTotal' => (float) $user->transactions()->where('type', 'deposit')->sum('amount'),
            'withdrawalsTotal' => (float) $user->transactions()->where('type', 'withdrawal')->sum('amount'),
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'verified' => ['nullable', 'boolean'],
        ]);

        $user->fill(['name' => $validated['name'], 'email' => $validated['email']]);
        $user->email_verified_at = $request->boolean('verified') ? ($user->email_verified_at ?? Carbon::now()) : null;
        $user->save();

        return redirect()->route('admin.users.show', $user)->with('status', 'User updated.');
    }

    public function adjustFunds(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'direction' => ['required', 'in:credit,debit'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $amount = (float) $validated['amount'];
        $note = $validated['note'] ?: 'Admin adjustment';

        if ($validated['direction'] === 'credit') {
            $user->credit($amount, 'deposit', $note);
        } else {
            if ($amount > (float) $user->balance) {
                return back()->withErrors(['amount' => 'Amount exceeds the user balance.']);
            }
            $user->debit($amount, 'withdrawal', $note);
        }

        return redirect()->route('admin.users.show', $user)->with('status', 'Balance adjusted.');
    }

    /**
     * Send a custom email to the user.
     */
    public function emailUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        NotificationMail::deliver(
            $user,
            $validated['subject'],
            $validated['subject'],
            preg_split('/\r\n|\r|\n/', $validated['message']) ?: [$validated['message']],
        );

        return redirect()->route('admin.users.show', $user)->with('status', 'Email sent to '.$user->email.'.');
    }

    /**
     * Block or unblock the user account.
     */
    public function block(User $user): RedirectResponse
    {
        $user->forceFill(['blocked_at' => $user->isBlocked() ? null : Carbon::now()])->save();

        return redirect()->route('admin.users.show', $user)
            ->with('status', $user->isBlocked() ? 'User has been blocked.' : 'User has been unblocked.');
    }

    /**
     * Reset the account: wipe balance, investments, deposits and transactions.
     */
    public function clear(User $user): RedirectResponse
    {
        DB::transaction(function () use ($user): void {
            $user->transactions()->delete();
            $user->investments()->delete();
            $user->depositRequests()->delete();
            $user->forceFill(['balance' => 0])->save();
        });

        return redirect()->route('admin.users.show', $user)->with('status', 'Account cleared — balance, investments, deposits and transactions removed.');
    }

    /**
     * Log in as this user (impersonation) while remaining authenticated as admin.
     */
    public function impersonate(Request $request, User $user): RedirectResponse
    {
        $request->session()->put('impersonator_admin_id', Auth::guard('admin')->id());
        $request->session()->put('impersonated_user_id', $user->id);

        Auth::guard('web')->login($user);

        return redirect()->route('user.dashboard');
    }

    /**
     * Stop impersonating and return to the admin panel.
     */
    public function stopImpersonating(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $userId = $request->session()->pull('impersonated_user_id');
        $request->session()->forget('impersonator_admin_id');

        return $userId
            ? redirect()->route('admin.users.show', $userId)
            : redirect()->route('admin.users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted.');
    }
}
