<x-admin-layout title="Dashboard">

    {{-- Metrics --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $metrics = [
                ['Total users', number_format($usersCount), $verifiedCount.' verified', 'from-brand to-violet'],
                ['Wallet balances', '$'.number_format($walletTotal, 2), 'Across all users', 'from-sky-500 to-indigo-600'],
                ['Active investments', number_format($activeInvestments), '$'.number_format($totalInvested, 2).' invested', 'from-emerald-500 to-teal-600'],
                ['Expected payouts', '$'.number_format($expectedReturns, 2), 'On active plans', 'from-amber-400 to-orange-500'],
            ];
        @endphp
        @foreach ($metrics as [$label, $value, $sub, $grad])
            <div class="rounded-3xl glass p-6">
                <div class="h-1.5 w-10 rounded-full bg-gradient-to-r {{ $grad }}"></div>
                <p class="mt-4 text-sm text-white/55">{{ $label }}</p>
                <p class="mt-1 text-2xl font-black tabular-nums">{{ $value }}</p>
                <p class="mt-1 text-xs text-white/40">{{ $sub }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-5 grid gap-5 sm:grid-cols-3">
        @foreach ([['Investment plans', number_format($plansCount)], ['Total deposits', '$'.number_format($depositsTotal, 2)], ['Total withdrawals', '$'.number_format($withdrawalsTotal, 2)]] as [$label, $value])
            <div class="rounded-3xl glass p-6">
                <p class="text-sm text-white/55">{{ $label }}</p>
                <p class="mt-1 text-xl font-bold tabular-nums">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-10 grid gap-6 lg:grid-cols-2">
        {{-- Recent users --}}
        <div class="rounded-3xl glass p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-bold">Recent users</h2>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-brand-bright hover:underline">View all</a>
            </div>
            <div class="mt-4 divide-y divide-white/5">
                @forelse ($recentUsers as $u)
                    <a href="{{ route('admin.users.show', $u) }}" class="flex items-center justify-between py-3 transition hover:opacity-80">
                        <div class="flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-brand to-violet text-sm font-bold">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                            <div>
                                <p class="text-sm font-semibold">{{ $u->name }}</p>
                                <p class="text-xs text-white/45">{{ $u->email }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold tabular-nums">${{ number_format((float) $u->balance, 2) }}</span>
                    </a>
                @empty
                    <p class="py-6 text-center text-sm text-white/45">No users yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent transactions --}}
        <div class="rounded-3xl glass p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-bold">Recent transactions</h2>
                <a href="{{ route('admin.transactions.index') }}" class="text-sm text-brand-bright hover:underline">View all</a>
            </div>
            <div class="mt-4 divide-y divide-white/5">
                @forelse ($recentTransactions as $txn)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="text-sm font-medium capitalize">{{ $txn->type }}</p>
                            <p class="text-xs text-white/45">{{ $txn->user?->name }}</p>
                        </div>
                        <span class="text-sm font-semibold tabular-nums {{ $txn->isCredit() ? 'text-emerald' : 'text-rose-400' }}">{{ $txn->isCredit() ? '+' : '−' }}${{ number_format((float) $txn->amount, 2) }}</span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-white/45">No transactions yet.</p>
                @endforelse
            </div>
        </div>
    </div>

</x-admin-layout>
