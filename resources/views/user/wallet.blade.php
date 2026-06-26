<x-app-layout title="Wallet — Fintriva">

    <div class="reveal flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight sm:text-3xl">Wallet</h1>
            <p class="mt-1 text-white/55">Review your full transaction history.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('user.deposit') }}" class="btn-glow rounded-2xl px-5 py-2.5 text-sm font-bold text-white">Deposit</a>
            <a href="{{ route('user.withdraw') }}" class="rounded-2xl glass px-5 py-2.5 text-sm font-semibold text-white/90 transition hover:bg-white/10">Withdraw</a>
        </div>
    </div>

    {{-- Balance --}}
    <div class="reveal mt-6 gradient-border rounded-3xl glass p-7">
        <p class="text-sm text-white/55">Available balance</p>
        <p class="mt-1 text-4xl font-black tabular-nums">${{ number_format((float) $user->balance, 2) }}</p>
    </div>

    {{-- Transaction ledger --}}
    <div class="mt-12">
        <h2 class="reveal text-2xl font-bold">Transaction history</h2>

        @if ($transactions->isEmpty())
            <div class="reveal mt-6 rounded-3xl glass p-10 text-center">
                <p class="text-white/55">No transactions yet.</p>
            </div>
        @else
            <div class="reveal mt-6 overflow-hidden rounded-3xl glass">
                <table class="table-cards w-full text-left text-sm">
                    <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                        <tr>
                            <th class="px-6 py-4 font-medium">Type</th>
                            <th class="hidden px-6 py-4 font-medium md:table-cell">Description</th>
                            <th class="px-6 py-4 text-right font-medium">Amount</th>
                            <th class="hidden px-6 py-4 text-right font-medium md:table-cell">Balance</th>
                            <th class="px-6 py-4 text-right font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach ($transactions as $txn)
                            <tr class="transition hover:bg-white/5">
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $txn->isCredit() ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/70' }}">{{ $txn->type }}</span>
                                </td>
                                <td data-label="Description" class="px-6 py-4 text-white/60 md:table-cell">{{ $txn->description }}</td>
                                <td data-label="Amount" class="px-6 py-4 text-right font-semibold tabular-nums {{ $txn->isCredit() ? 'text-emerald' : 'text-rose-400' }}">
                                    {{ $txn->isCredit() ? '+' : '−' }}${{ number_format((float) $txn->amount, 2) }}
                                </td>
                                <td data-label="Balance" class="px-6 py-4 text-right tabular-nums text-white/60 md:table-cell">${{ number_format((float) $txn->balance_after, 2) }}</td>
                                <td data-label="Date" class="px-6 py-4 text-right tabular-nums text-white/50">{{ $txn->created_at->format('M j, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="reveal mt-6">{{ $transactions->links() }}</div>
        @endif
    </div>

</x-app-layout>
