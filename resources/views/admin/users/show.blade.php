<x-admin-layout title="Manage user">

    <a href="{{ route('admin.users.index') }}" class="text-sm text-white/50 transition hover:text-white">← Back to users</a>

    {{-- Header --}}
    <div class="mt-4 flex flex-col gap-4 rounded-3xl glass p-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-4">
            <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-brand to-violet text-xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-xl font-black sm:text-2xl">{{ $user->name }}</h2>
                    @if ($user->isBlocked())
                        <span class="rounded-full bg-rose-500/15 px-2.5 py-0.5 text-xs font-semibold text-rose-300">Blocked</span>
                    @endif
                    @if ($user->email_verified_at)
                        <span class="rounded-full bg-emerald/15 px-2.5 py-0.5 text-xs font-semibold text-emerald">Verified</span>
                    @else
                        <span class="rounded-full bg-amber-400/15 px-2.5 py-0.5 text-xs font-semibold text-amber-300">Pending</span>
                    @endif
                </div>
                <p class="truncate text-white/55">{{ $user->email }}</p>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="flex flex-wrap gap-2">
            <form action="{{ route('admin.users.impersonate', $user) }}" method="post">
                @csrf
                <button type="submit" class="btn-glow rounded-2xl px-4 py-2.5 text-sm font-bold text-white">Login as user</button>
            </form>
            <a href="{{ route('admin.users.edit', $user) }}" class="rounded-2xl glass px-4 py-2.5 text-sm font-semibold text-white/90 transition hover:bg-white/10">Edit</a>
            <form action="{{ route('admin.users.block', $user) }}" method="post" onsubmit="return confirm('{{ $user->isBlocked() ? 'Unblock' : 'Block' }} this user?')">
                @csrf
                <button type="submit" class="rounded-2xl px-4 py-2.5 text-sm font-semibold transition {{ $user->isBlocked() ? 'bg-emerald/15 text-emerald hover:bg-emerald/25' : 'bg-amber-400/15 text-amber-300 hover:bg-amber-400/25' }}">{{ $user->isBlocked() ? 'Unblock' : 'Block' }}</button>
            </form>
        </div>
    </div>

    {{-- Mini nav (tabs) --}}
    <div class="mt-6 flex gap-1 overflow-x-auto rounded-2xl glass p-1.5" data-tabs>
        @foreach (['overview' => 'Overview', 'transactions' => 'Transactions', 'investments' => 'Investments', 'deposits' => 'Deposits', 'manage' => 'Manage'] as $key => $label)
            <button type="button" data-tab="{{ $key }}" class="shrink-0 rounded-xl px-4 py-2 text-sm font-semibold text-white/60 transition hover:text-white">{{ $label }}</button>
        @endforeach
    </div>

    {{-- ===== OVERVIEW ===== --}}
    <section data-panel="overview" class="mt-6 space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    ['Wallet balance', '$'.number_format((float) $user->balance, 2), 'from-brand to-violet'],
                    ['Active invested', '$'.number_format((float) $totalInvested, 2), 'from-sky-500 to-indigo-600'],
                    ['Total deposits', '$'.number_format((float) $depositsTotal, 2), 'from-emerald-500 to-teal-600'],
                    ['Total withdrawals', '$'.number_format((float) $withdrawalsTotal, 2), 'from-amber-400 to-orange-500'],
                ];
            @endphp
            @foreach ($stats as [$label, $value, $grad])
                <div class="rounded-3xl glass p-5">
                    <div class="h-1.5 w-10 rounded-full bg-gradient-to-r {{ $grad }}"></div>
                    <p class="mt-4 text-sm text-white/55">{{ $label }}</p>
                    <p class="mt-1 text-xl font-black tabular-nums">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-3xl glass p-5"><p class="text-sm text-white/55">Joined</p><p class="mt-1 font-bold">{{ $user->created_at->format('M j, Y') }}</p></div>
            <div class="rounded-3xl glass p-5"><p class="text-sm text-white/55">Status</p><p class="mt-1 font-bold">{{ $user->isBlocked() ? 'Blocked' : 'Active' }}</p></div>
            <div class="rounded-3xl glass p-5"><p class="text-sm text-white/55">Email</p><p class="mt-1 truncate font-bold">{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</p></div>
        </div>

        {{-- Adjust funds --}}
        <div class="rounded-3xl glass p-6">
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
    </section>

    {{-- ===== TRANSACTIONS ===== --}}
    <section data-panel="transactions" id="tab-transactions" class="mt-6 hidden">
        <div class="overflow-hidden rounded-3xl glass">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">Type</th>
                        <th class="px-6 py-4 font-medium">Description</th>
                        <th class="px-6 py-4 text-right font-medium">Amount</th>
                        <th class="px-6 py-4 text-right font-medium">Balance</th>
                        <th class="px-6 py-4 text-right font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($transactions as $txn)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $txn->isCredit() ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/70' }}">{{ $txn->type }}</span></td>
                            <td data-label="Description" class="px-6 py-4 text-white/60">{{ $txn->description }}</td>
                            <td data-label="Amount" class="px-6 py-4 text-right font-semibold tabular-nums {{ $txn->isCredit() ? 'text-emerald' : 'text-rose-400' }}">{{ $txn->isCredit() ? '+' : '−' }}${{ number_format((float) $txn->amount, 2) }}</td>
                            <td data-label="Balance" class="px-6 py-4 text-right tabular-nums text-white/60">${{ number_format((float) $txn->balance_after, 2) }}</td>
                            <td data-label="Date" class="px-6 py-4 text-right tabular-nums text-white/50">{{ $txn->created_at->format('M j, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-white/45">No transactions.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $transactions->links() }}</div>
    </section>

    {{-- ===== INVESTMENTS ===== --}}
    <section data-panel="investments" class="mt-6 hidden">
        <div class="overflow-hidden rounded-3xl glass">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">Plan</th>
                        <th class="px-6 py-4 text-right font-medium">Amount</th>
                        <th class="px-6 py-4 text-right font-medium">Return</th>
                        <th class="px-6 py-4 text-right font-medium">Matures</th>
                        <th class="px-6 py-4 text-right font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($investments as $inv)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4 font-medium">{{ $inv->plan?->name }}</td>
                            <td data-label="Amount" class="px-6 py-4 text-right tabular-nums">${{ number_format((float) $inv->amount, 2) }}</td>
                            <td data-label="Return" class="px-6 py-4 text-right tabular-nums text-emerald">+${{ number_format((float) $inv->expected_return, 2) }}</td>
                            <td data-label="Matures" class="px-6 py-4 text-right tabular-nums text-white/55">{{ $inv->matures_at?->format('M j, Y') }}</td>
                            <td data-label="Status" class="px-6 py-4 text-right"><span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $inv->status === 'active' ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/60' }}">{{ $inv->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-white/45">No investments.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- ===== DEPOSITS ===== --}}
    <section data-panel="deposits" id="tab-deposits" class="mt-6 hidden">
        <div class="overflow-hidden rounded-3xl glass">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">Method</th>
                        <th class="px-6 py-4 text-right font-medium">Amount</th>
                        <th class="px-6 py-4 font-medium">Reference</th>
                        <th class="px-6 py-4 text-center font-medium">Status</th>
                        <th class="px-6 py-4 text-right font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($deposits as $d)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4 font-medium">{{ $d->method_label }}</td>
                            <td data-label="Amount" class="px-6 py-4 text-right font-semibold tabular-nums">${{ number_format((float) $d->amount, 2) }}</td>
                            <td data-label="Reference" class="px-6 py-4 text-white/60">
                                <span class="break-all">{{ $d->reference ?: '—' }}</span>
                                @if ($d->proofUrl())<a href="{{ $d->proofUrl() }}" target="_blank" class="ml-1 text-xs font-semibold text-brand-bright hover:underline">proof</a>@endif
                            </td>
                            <td data-label="Status" class="px-6 py-4 text-center">
                                @php $b = ['pending'=>'bg-amber-400/15 text-amber-300','approved'=>'bg-emerald/15 text-emerald','rejected'=>'bg-rose-400/15 text-rose-300'][$d->status] ?? 'bg-white/10 text-white/60'; @endphp
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $b }}">{{ $d->status }}</span>
                            </td>
                            <td data-label="Date" class="px-6 py-4 text-right tabular-nums text-white/50">{{ $d->created_at->format('M j, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-white/45">No deposits.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $deposits->links() }}</div>
    </section>

    {{-- ===== MANAGE ===== --}}
    <section data-panel="manage" class="mt-6 space-y-6 hidden">
        {{-- Email user --}}
        <div class="rounded-3xl glass p-6">
            <h3 class="font-bold">Email this user</h3>
            <p class="mt-1 text-sm text-white/50">Sends a branded email to {{ $user->email }}.</p>
            <form action="{{ route('admin.users.email', $user) }}" method="post" class="mt-4 space-y-3">
                @csrf
                <input type="text" name="subject" required maxlength="150" placeholder="Subject" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                <textarea name="message" required rows="4" maxlength="5000" placeholder="Write your message…" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright"></textarea>
                <button type="submit" class="btn-glow rounded-2xl px-5 py-2.5 text-sm font-bold text-white">Send email</button>
            </form>
        </div>

        {{-- Danger zone --}}
        <div class="rounded-3xl border border-rose-500/20 bg-rose-500/[0.04] p-6">
            <h3 class="font-bold text-rose-300">Danger zone</h3>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-white/[0.03] p-4">
                    <p class="font-semibold">Clear account</p>
                    <p class="mt-1 text-xs text-white/50">Wipes balance, investments, deposits and transactions. Keeps the account.</p>
                    <form action="{{ route('admin.users.clear', $user) }}" method="post" onsubmit="return confirm('Clear this account? This removes all balance, investments, deposits and transactions and cannot be undone.')" class="mt-3">
                        @csrf
                        <button type="submit" class="rounded-2xl bg-amber-400/15 px-4 py-2.5 text-sm font-bold text-amber-300 transition hover:bg-amber-400/25">Clear account</button>
                    </form>
                </div>
                <div class="rounded-2xl bg-white/[0.03] p-4">
                    <p class="font-semibold">Delete user</p>
                    <p class="mt-1 text-xs text-white/50">Permanently deletes the user and all their data.</p>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="post" onsubmit="return confirm('Permanently delete this user and all their data?')" class="mt-3">
                        @csrf @method('DELETE')
                        <button type="submit" class="rounded-2xl bg-rose-500/15 px-4 py-2.5 text-sm font-bold text-rose-300 transition hover:bg-rose-500/25">Delete user</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const tabsBar = document.querySelector('[data-tabs]');
            if (!tabsBar) return;
            const tabs = [...tabsBar.querySelectorAll('[data-tab]')];
            const panels = [...document.querySelectorAll('[data-panel]')];

            function activate(name) {
                tabs.forEach((t) => {
                    const on = t.dataset.tab === name;
                    t.classList.toggle('bg-white/10', on);
                    t.classList.toggle('text-white', on);
                    t.classList.toggle('text-white/60', !on);
                });
                panels.forEach((p) => p.classList.toggle('hidden', p.dataset.panel !== name));
            }

            tabs.forEach((t) => t.addEventListener('click', () => {
                activate(t.dataset.tab);
                history.replaceState(null, '', '#tab-' + t.dataset.tab);
            }));

            const fromHash = (location.hash.match(/^#tab-(\w+)/) || [])[1];
            activate(tabs.some((t) => t.dataset.tab === fromHash) ? fromHash : 'overview');
        })();
    </script>

</x-admin-layout>
