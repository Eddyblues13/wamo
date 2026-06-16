<x-admin-layout title="Deposits">

    <div class="mb-6 flex flex-wrap items-center gap-2">
        @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All'] as $value => $label)
            <a href="{{ route('admin.deposits.index', ['status' => $value]) }}"
               class="rounded-full px-4 py-2 text-sm font-medium transition {{ $status === $value ? 'bg-white text-ink-950' : 'glass text-white/70 hover:bg-white/10' }}">
                {{ $label }}@if ($value === 'pending' && $pendingCount) <span class="ml-1 rounded-full bg-amber-400/20 px-1.5 text-xs text-amber-300">{{ $pendingCount }}</span>@endif
            </a>
        @endforeach
    </div>

    <div class="overflow-hidden rounded-3xl glass">
        <div class="overflow-x-auto">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Method</th>
                        <th class="px-6 py-4 text-right font-medium">Amount</th>
                        <th class="hidden px-6 py-4 font-medium md:table-cell">Reference</th>
                        <th class="px-6 py-4 text-center font-medium">Status</th>
                        <th class="px-6 py-4 text-right font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($requests as $r)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.users.show', $r->user) }}" class="font-medium hover:text-brand-bright">{{ $r->user?->name }}</a>
                                <p class="text-xs text-white/45">{{ $r->user?->email }}</p>
                            </td>
                            <td data-label="Method" class="px-6 py-4">{{ $r->method_label }}</td>
                            <td data-label="Amount" class="px-6 py-4 text-right font-semibold tabular-nums">${{ number_format((float) $r->amount, 2) }}</td>
                            <td data-label="Reference" class="px-6 py-4 text-white/55 md:table-cell">
                                <span class="break-all">{{ $r->reference ?: '—' }}</span>
                                @if ($r->proofUrl())
                                    <a href="{{ $r->proofUrl() }}" target="_blank" class="ml-2 inline-block rounded-lg bg-white/10 px-2 py-0.5 text-xs font-semibold text-brand-bright transition hover:bg-white/20">View proof</a>
                                @endif
                            </td>
                            <td data-label="Status" class="px-6 py-4 text-center">
                                @php $badge = ['pending' => 'bg-amber-400/15 text-amber-300', 'approved' => 'bg-emerald/15 text-emerald', 'rejected' => 'bg-rose-400/15 text-rose-300'][$r->status] ?? 'bg-white/10 text-white/60'; @endphp
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $badge }}">{{ $r->status }}</span>
                            </td>
                            <td data-label="Action" class="px-6 py-4 text-right">
                                @if ($r->isPending())
                                    <div class="inline-flex items-center gap-2">
                                        <form action="{{ route('admin.deposits.approve', $r) }}" method="post" onsubmit="return confirm('Approve and credit ${{ number_format((float) $r->amount, 2) }} to {{ $r->user?->name }}?')">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-emerald/15 px-3 py-1.5 text-xs font-bold text-emerald transition hover:bg-emerald/25">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.deposits.reject', $r) }}" method="post" onsubmit="return confirm('Reject this deposit request?')">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-rose-500/15 px-3 py-1.5 text-xs font-bold text-rose-300 transition hover:bg-rose-500/25">Reject</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-white/30">{{ $r->processed_at?->format('M j, Y') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-white/45">No deposit requests.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $requests->links() }}</div>

</x-admin-layout>
