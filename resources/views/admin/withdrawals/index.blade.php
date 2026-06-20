<x-admin-layout title="Withdrawals">

    <div class="mb-6 flex flex-wrap items-center gap-2">
        @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All'] as $value => $label)
            <a href="{{ route('admin.withdrawals.index', ['status' => $value]) }}"
               class="rounded-full px-4 py-2 text-sm font-medium transition {{ $status === $value ? 'bg-white text-ink-950' : 'glass text-white/70 hover:bg-white/10' }}">
                {{ $label }}@if ($value === 'pending' && $pendingCount) <span class="ml-1 rounded-full bg-amber-400/20 px-1.5 text-xs text-amber-300">{{ $pendingCount }}</span>@endif
            </a>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse ($requests as $r)
            @php $badge = ['pending' => 'bg-amber-400/15 text-amber-300', 'approved' => 'bg-emerald/15 text-emerald', 'rejected' => 'bg-rose-400/15 text-rose-300'][$r->status] ?? 'bg-white/10 text-white/60'; @endphp
            <div class="rounded-3xl glass p-6">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    {{-- User + amount --}}
                    <div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.users.show', $r->user) }}" class="font-semibold hover:text-brand-bright">{{ $r->user?->name }}</a>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $badge }}">{{ $r->status }}</span>
                        </div>
                        <p class="text-xs text-white/45">{{ $r->user?->email }}</p>
                        <p class="mt-3 text-2xl font-black tabular-nums">${{ number_format((float) $r->amount, 2) }}</p>
                        <p class="text-xs text-white/45">{{ $r->methodLabel() }} · requested {{ $r->created_at->format('M j, Y · g:i A') }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="shrink-0">
                        @if ($r->isPending())
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.withdrawals.approve', $r) }}" method="post" onsubmit="return confirm('Approve and debit ${{ number_format((float) $r->amount, 2) }} from {{ $r->user?->name }}?')">
                                    @csrf
                                    <button type="submit" class="rounded-lg bg-emerald/15 px-3.5 py-2 text-xs font-bold text-emerald transition hover:bg-emerald/25">Approve</button>
                                </form>
                                <form action="{{ route('admin.withdrawals.reject', $r) }}" method="post" onsubmit="return confirm('Reject this withdrawal request?')">
                                    @csrf
                                    <button type="submit" class="rounded-lg bg-rose-500/15 px-3.5 py-2 text-xs font-bold text-rose-300 transition hover:bg-rose-500/25">Reject</button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-white/40">Processed {{ $r->processed_at?->format('M j, Y') }}</span>
                        @endif
                    </div>
                </div>

                {{-- Payout details --}}
                <div class="mt-5 grid gap-3 rounded-2xl bg-white/5 p-5 text-sm sm:grid-cols-2">
                    @if ($r->isBank())
                        <div><p class="text-xs text-white/45">Account holder</p><p class="font-semibold">{{ $r->account_name ?: '—' }}</p></div>
                        <div><p class="text-xs text-white/45">Bank name</p><p class="font-semibold">{{ $r->bank_name ?: '—' }}</p></div>
                        <div><p class="text-xs text-white/45">Account number / IBAN</p><p class="font-semibold break-all">{{ $r->account_number ?: '—' }}</p></div>
                        <div><p class="text-xs text-white/45">SWIFT / BIC / Routing</p><p class="font-semibold break-all">{{ $r->swift_code ?: '—' }}</p></div>
                    @else
                        <div><p class="text-xs text-white/45">Network / Coin</p><p class="font-semibold">{{ $r->crypto_network ?: '—' }}</p></div>
                        <div><p class="text-xs text-white/45">Wallet address</p><p class="font-semibold break-all">{{ $r->wallet_address ?: '—' }}</p></div>
                    @endif
                    @if ($r->admin_note)
                        <div class="sm:col-span-2"><p class="text-xs text-white/45">Admin note</p><p class="font-semibold text-rose-300">{{ $r->admin_note }}</p></div>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-3xl glass p-10 text-center text-white/45">No withdrawal requests.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $requests->links() }}</div>

</x-admin-layout>
