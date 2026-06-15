<x-admin-layout title="Transactions">

    <div class="mb-6 flex flex-wrap gap-2">
        @foreach (['' => 'All', 'deposit' => 'Deposits', 'withdrawal' => 'Withdrawals', 'investment' => 'Investments', 'return' => 'Returns'] as $value => $label)
            <a href="{{ route('admin.transactions.index', array_filter(['type' => $value])) }}"
               class="rounded-full px-4 py-2 text-sm font-medium transition {{ $type === $value ? 'bg-white text-ink-950' : 'glass text-white/70 hover:bg-white/10' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="overflow-hidden rounded-3xl glass">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Type</th>
                        <th class="hidden px-6 py-4 font-medium sm:table-cell">Description</th>
                        <th class="px-6 py-4 text-right font-medium">Amount</th>
                        <th class="hidden px-6 py-4 text-right font-medium sm:table-cell">Balance</th>
                        <th class="px-6 py-4 text-right font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($transactions as $txn)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.users.show', $txn->user) }}" class="font-medium hover:text-brand-bright">{{ $txn->user?->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $txn->isCredit() ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/70' }}">{{ $txn->type }}</span>
                            </td>
                            <td class="hidden px-6 py-4 text-white/55 sm:table-cell">{{ $txn->description }}</td>
                            <td class="px-6 py-4 text-right font-semibold tabular-nums {{ $txn->isCredit() ? 'text-emerald' : 'text-rose-400' }}">{{ $txn->isCredit() ? '+' : '−' }}${{ number_format((float) $txn->amount, 2) }}</td>
                            <td class="hidden px-6 py-4 text-right tabular-nums text-white/55 sm:table-cell">${{ number_format((float) $txn->balance_after, 2) }}</td>
                            <td class="px-6 py-4 text-right tabular-nums text-white/50">{{ $txn->created_at->format('M j, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-white/45">No transactions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $transactions->links() }}</div>

</x-admin-layout>
