<x-admin-layout :title="$marketLabel">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="hidden text-2xl font-black tracking-tight lg:block">{{ $marketLabel }} positions</h1>
            <p class="text-sm text-white/50">Manage every user's {{ strtolower($marketLabel) }} position — add profit, record a loss, or settle to their wallet.</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl glass">
        <div class="overflow-x-auto">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Asset</th>
                        <th class="px-6 py-4 text-right font-medium">Invested</th>
                        <th class="px-6 py-4 text-right font-medium">Profit / loss</th>
                        <th class="px-6 py-4 text-right font-medium">Current value</th>
                        <th class="px-6 py-4 text-center font-medium">Status</th>
                        <th class="px-6 py-4 text-right font-medium">Manage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($trades as $trade)
                        @php $pl = (float) $trade->profit; @endphp
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.users.show', $trade->user) }}" class="font-semibold hover:text-brand-bright">{{ $trade->user?->name }}</a>
                                <p class="text-xs text-white/45">{{ $trade->user?->email }}</p>
                            </td>
                            <td data-label="Asset" class="px-6 py-4">
                                <span class="font-semibold">{{ $trade->symbol }}</span>
                                <p class="text-xs text-white/45">{{ $trade->name ?? '—' }}</p>
                            </td>
                            <td data-label="Invested" class="px-6 py-4 text-right font-semibold tabular-nums">${{ number_format((float) $trade->amount, 2) }}</td>
                            <td data-label="Profit / loss" class="px-6 py-4 text-right tabular-nums {{ $pl >= 0 ? 'text-emerald' : 'text-rose-400' }}">{{ $pl >= 0 ? '+' : '-' }}${{ number_format(abs($pl), 2) }}</td>
                            <td data-label="Current value" class="px-6 py-4 text-right font-semibold tabular-nums">${{ number_format($trade->currentValue(), 2) }}</td>
                            <td data-label="Status" class="px-6 py-4 text-center">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $trade->status === 'open' ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/55' }}">{{ $trade->status }}</span>
                            </td>
                            <td data-label="Manage" class="px-6 py-4">
                                @if ($trade->isOpen())
                                    <div class="flex flex-col items-stretch gap-2 sm:flex-row sm:items-center sm:justify-end">
                                        <form action="{{ route('admin.trades.profit', $trade) }}" method="post" class="flex items-center gap-2">
                                            @csrf
                                            <div class="flex items-center rounded-xl bg-white/5 px-2 ring-1 ring-white/10 focus-within:ring-brand-bright">
                                                <span class="text-white/40">$</span>
                                                <input type="number" name="profit" step="0.01" placeholder="0.00" required
                                                       class="w-24 bg-transparent py-1.5 pl-1 text-sm font-semibold text-white outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                                            </div>
                                            <button type="submit" class="rounded-xl bg-brand/20 px-3 py-1.5 text-xs font-bold text-brand-bright transition hover:bg-brand/30">Add P/L</button>
                                        </form>
                                        <form action="{{ route('admin.trades.close', $trade) }}" method="post" onsubmit="return confirm('Settle this position? Capital + profit (${{ number_format($trade->currentValue(), 2) }}) will be credited to the user\'s wallet.')">
                                            @csrf
                                            <button type="submit" class="w-full rounded-xl bg-emerald/15 px-3 py-1.5 text-xs font-bold text-emerald transition hover:bg-emerald/25 sm:w-auto">Settle</button>
                                        </form>
                                        <form action="{{ route('admin.trades.destroy', $trade) }}" method="post" onsubmit="return confirm('Delete this position permanently? No funds are returned.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full rounded-xl bg-rose-500/15 px-3 py-1.5 text-xs font-bold text-rose-300 transition hover:bg-rose-500/25 sm:w-auto">Delete</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="flex items-center justify-end gap-3">
                                        <span class="text-xs text-white/40">Settled {{ $trade->closed_at?->format('M j, Y') }}</span>
                                        <form action="{{ route('admin.trades.destroy', $trade) }}" method="post" onsubmit="return confirm('Delete this position record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl bg-rose-500/15 px-3 py-1.5 text-xs font-bold text-rose-300 transition hover:bg-rose-500/25">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-10 text-center text-white/45">No {{ strtolower($marketLabel) }} positions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $trades->links() }}</div>

</x-admin-layout>
