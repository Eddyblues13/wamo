<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $user->load(['investments.plan', 'transactions']);

        return view('admin.users.show', compact('user'));
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

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted.');
    }
}
