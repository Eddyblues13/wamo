<x-admin-layout title="Investments">

    <div class="overflow-hidden rounded-3xl glass">
        <div class="overflow-x-auto">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Plan</th>
                        <th class="px-6 py-4 text-right font-medium">Amount</th>
                        <th class="px-6 py-4 text-right font-medium">Return</th>
                        <th class="px-6 py-4 text-right font-medium">Matures</th>
                        <th class="px-6 py-4 text-center font-medium">Status</th>
                        <th class="px-6 py-4 text-right font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($investments as $inv)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.users.show', $inv->user) }}" class="font-semibold hover:text-brand-bright">{{ $inv->user?->name }}</a>
                                <p class="text-xs text-white/45">{{ $inv->user?->email }}</p>
                            </td>
                            <td data-label="Plan" class="px-6 py-4">{{ $inv->plan?->name }}</td>
                            <td data-label="Amount" class="px-6 py-4 text-right font-semibold tabular-nums">${{ number_format((float) $inv->amount, 2) }}</td>
                            <td data-label="Return" class="px-6 py-4 text-right tabular-nums text-emerald">+${{ number_format((float) $inv->expected_return, 2) }}</td>
                            <td data-label="Matures" class="px-6 py-4 text-right tabular-nums text-white/55">{{ $inv->matures_at?->format('M j, Y') }}</td>
                            <td data-label="Status" class="px-6 py-4 text-center">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $inv->status === 'active' ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/55' }}">{{ $inv->status }}</span>
                            </td>
                            <td data-label="Action" class="px-6 py-4">
                                @if ($inv->status === 'active')
                                    <div class="flex flex-col items-stretch gap-2 sm:flex-row sm:items-center sm:justify-end">
                                        <form action="{{ route('admin.investments.profit', $inv) }}" method="post" class="flex items-center gap-2">
                                            @csrf
                                            <div class="flex items-center rounded-xl bg-white/5 px-2 ring-1 ring-white/10 focus-within:ring-brand-bright">
                                                <span class="text-white/40">$</span>
                                                <input type="number" name="profit" step="0.01" placeholder="0.00" required
                                                       class="w-24 bg-transparent py-1.5 pl-1 text-sm font-semibold text-white outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                                            </div>
                                            <button type="submit" class="rounded-xl bg-brand/20 px-3 py-1.5 text-xs font-bold text-brand-bright transition hover:bg-brand/30">Add profit</button>
                                        </form>
                                        <form action="{{ route('admin.investments.payout', $inv) }}" method="post" onsubmit="return confirm('Pay out principal + return now and complete this investment?')">
                                            @csrf
                                            <button type="submit" class="w-full rounded-xl bg-emerald/15 px-3 py-1.5 text-xs font-bold text-emerald transition hover:bg-emerald/25 sm:w-auto">Pay out</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="block text-right text-xs text-white/30">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-10 text-center text-white/45">No investments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $investments->links() }}</div>

</x-admin-layout>
