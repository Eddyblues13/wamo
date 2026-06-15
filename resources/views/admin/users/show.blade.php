<x-admin-layout title="Manage user">

    <a href="{{ route('admin.users.index') }}" class="text-sm text-white/50 transition hover:text-white">← Back to users</a>

    <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <span class="grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-brand to-violet text-xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            <div>
                <h2 class="text-2xl font-black">{{ $user->name }}</h2>
                <p class="text-white/55">{{ $user->email }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="rounded-2xl glass px-4 py-2.5 text-sm font-semibold text-white/90 transition hover:bg-white/10">Edit</a>
            <form action="{{ route('admin.users.destroy', $user) }}" method="post" onsubmit="return confirm('Delete this user and all their data?')">
                @csrf @method('DELETE')
                <button type="submit" class="rounded-2xl bg-rose-500/15 px-4 py-2.5 text-sm font-semibold text-rose-300 transition hover:bg-rose-500/25">Delete</button>
            </form>
        </div>
    </div>

    {{-- Stats --}}
    <div class="mt-8 grid gap-5 sm:grid-cols-3">
        <div class="rounded-3xl glass p-6">
            <p class="text-sm text-white/55">Wallet balance</p>
            <p class="mt-1 text-2xl font-black tabular-nums">${{ number_format((float) $user->balance, 2) }}</p>
        </div>
        <div class="rounded-3xl glass p-6">
            <p class="text-sm text-white/55">Status</p>
            <p class="mt-1 text-2xl font-black">{{ $user->email_verified_at ? 'Verified' : 'Pending' }}</p>
        </div>
        <div class="rounded-3xl glass p-6">
            <p class="text-sm text-white/55">Joined</p>
            <p class="mt-1 text-2xl font-black">{{ $user->created_at->format('M j, Y') }}</p>
        </div>
    </div>

    {{-- Adjust funds --}}
    <div class="mt-6 rounded-3xl glass p-6">
        <h3 class="font-bold">Adjust wallet</h3>
        <form action="{{ route('admin.users.funds', $user) }}" method="post" class="mt-4 grid gap-3 sm:grid-cols-[140px_160px_1fr_auto]">
            @csrf
            <select name="direction" class="rounded-2xl bg-white/5 px-4 py-2.5 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                <option value="credit">Credit (+)</option>
                <option value="debit">Debit (−)</option>
            </select>
            <div class="flex items-center rounded-2xl bg-white/5 px-3 ring-1 ring-white/10 focus-within:ring-brand-bright">
                <span class="text-white/40">$</span>
                <input type="number" name="amount" min="0.01" step="0.01" required placeholder="0.00" class="w-full bg-transparent py-2.5 pl-1 text-sm font-semibold text-white outline-none">
            </div>
            <input type="text" name="note" placeholder="Note (optional)" class="rounded-2xl bg-white/5 px-4 py-2.5 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
            <button type="submit" class="btn-glow rounded-2xl px-5 py-2.5 text-sm font-bold text-white">Apply</button>
        </form>
    </div>

    {{-- Investments --}}
    <div class="mt-6 rounded-3xl glass p-6">
        <h3 class="font-bold">Investments</h3>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr><th class="py-3 pr-4 font-medium">Plan</th><th class="py-3 pr-4 text-right font-medium">Amount</th><th class="py-3 pr-4 text-right font-medium">Return</th><th class="py-3 pr-4 text-right font-medium">Matures</th><th class="py-3 text-right font-medium">Status</th></tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($user->investments as $inv)
                        <tr>
                            <td class="py-3 pr-4 font-medium">{{ $inv->plan->name }}</td>
                            <td class="py-3 pr-4 text-right tabular-nums">${{ number_format((float) $inv->amount, 2) }}</td>
                            <td class="py-3 pr-4 text-right tabular-nums text-emerald">+${{ number_format((float) $inv->expected_return, 2) }}</td>
                            <td class="py-3 pr-4 text-right tabular-nums text-white/55">{{ $inv->matures_at?->format('M j, Y') }}</td>
                            <td class="py-3 text-right"><span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $inv->status === 'active' ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/60' }}">{{ $inv->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-6 text-center text-white/45">No investments.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Transactions --}}
    <div class="mt-6 rounded-3xl glass p-6">
        <h3 class="font-bold">Recent transactions</h3>
        <div class="mt-4 divide-y divide-white/5">
            @forelse ($user->transactions->take(10) as $txn)
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="text-sm font-medium capitalize">{{ $txn->type }}</p>
                        <p class="text-xs text-white/45">{{ $txn->description }} · {{ $txn->created_at->format('M j, Y') }}</p>
                    </div>
                    <span class="text-sm font-semibold tabular-nums {{ $txn->isCredit() ? 'text-emerald' : 'text-rose-400' }}">{{ $txn->isCredit() ? '+' : '−' }}${{ number_format((float) $txn->amount, 2) }}</span>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-white/45">No transactions.</p>
            @endforelse
        </div>
    </div>

</x-admin-layout>
