<x-app-layout title="Withdraw — Fintriva">

    <div class="reveal">
        <h1 class="text-2xl font-black tracking-tight sm:text-3xl">Withdraw funds</h1>
        <p class="mt-1 text-white/55">Request a payout to your bank account or crypto wallet. Requests are reviewed by our team before funds are released.</p>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        {{-- Form --}}
        <div class="reveal rounded-3xl glass p-7 lg:col-span-2">
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-2xl bg-white/5 p-5">
                    <p class="text-sm text-white/55">Available to withdraw</p>
                    <p class="mt-1 text-3xl font-black tabular-nums">${{ number_format($available, 2) }}</p>
                </div>
                <div class="rounded-2xl bg-white/5 p-5">
                    <p class="text-sm text-white/55">Wallet balance</p>
                    <p class="mt-1 text-3xl font-black tabular-nums text-white/70">${{ number_format((float) $user->balance, 2) }}</p>
                </div>
            </div>
            @if ($available < (float) $user->balance)
                <p class="mt-3 text-xs text-amber-300/80">You have pending withdrawal requests reserving ${{ number_format((float) $user->balance - $available, 2) }}.</p>
            @endif

            <form action="{{ route('user.withdraw.store') }}" method="post" class="mt-6 space-y-5" data-withdraw>
                @csrf

                {{-- Method selector --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-white/60">Withdrawal method</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label data-method-card="bank" class="flex cursor-pointer items-center gap-3 rounded-2xl bg-white/5 px-4 py-3.5 ring-1 ring-white/10 transition">
                            <input type="radio" name="method" value="bank" {{ old('method', 'bank') === 'bank' ? 'checked' : '' }} class="accent-brand-bright" data-method-radio>
                            <span class="text-sm font-semibold">🏦 Bank transfer</span>
                        </label>
                        <label data-method-card="crypto" class="flex cursor-pointer items-center gap-3 rounded-2xl bg-white/5 px-4 py-3.5 ring-1 ring-white/10 transition">
                            <input type="radio" name="method" value="crypto" {{ old('method') === 'crypto' ? 'checked' : '' }} class="accent-brand-bright" data-method-radio>
                            <span class="text-sm font-semibold">₿ Crypto wallet</span>
                        </label>
                    </div>
                    @error('method')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

                {{-- Amount --}}
                <div>
                    <label for="amount" class="mb-1.5 block text-sm font-medium text-white/60">Amount (USD)</label>
                    <div class="flex items-center rounded-2xl bg-white/5 px-4 ring-1 ring-white/10 focus-within:ring-brand-bright">
                        <span class="text-lg text-white/40">$</span>
                        <input id="amount" type="number" name="amount" min="10" step="0.01" max="{{ $available }}" required value="{{ old('amount') }}" placeholder="100.00" class="w-full bg-transparent py-3.5 pl-2 text-lg font-bold text-white outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                    </div>
                    @error('amount')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    <button type="button" data-maxfill="{{ $available }}" class="mt-3 rounded-lg bg-white/5 px-3 py-1.5 text-xs font-semibold text-white/70 transition hover:bg-white/10">Withdraw max</button>
                </div>

                {{-- Bank details --}}
                <div data-fields="bank" class="space-y-4 rounded-2xl border border-white/10 bg-white/[0.03] p-5">
                    <p class="text-sm font-semibold text-white/80">Bank account details</p>
                    <div>
                        <label for="account_name" class="mb-1.5 block text-xs font-medium text-white/55">Account holder name</label>
                        <input id="account_name" type="text" name="account_name" value="{{ old('account_name') }}" placeholder="John Doe" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                        @error('account_name')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="bank_name" class="mb-1.5 block text-xs font-medium text-white/55">Bank name</label>
                            <input id="bank_name" type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="Chase Bank" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                            @error('bank_name')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="account_number" class="mb-1.5 block text-xs font-medium text-white/55">Account number / IBAN</label>
                            <input id="account_number" type="text" name="account_number" value="{{ old('account_number') }}" placeholder="0123456789" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                            @error('account_number')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="swift_code" class="mb-1.5 block text-xs font-medium text-white/55">SWIFT / BIC / Routing number</label>
                        <input id="swift_code" type="text" name="swift_code" value="{{ old('swift_code') }}" placeholder="CHASUS33" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                        @error('swift_code')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Crypto details --}}
                <div data-fields="crypto" class="hidden space-y-4 rounded-2xl border border-white/10 bg-white/[0.03] p-5">
                    <p class="text-sm font-semibold text-white/80">Crypto wallet details</p>
                    <div>
                        <label for="crypto_network" class="mb-1.5 block text-xs font-medium text-white/55">Network / Coin</label>
                        <input id="crypto_network" type="text" name="crypto_network" value="{{ old('crypto_network') }}" placeholder="USDT (TRC20), BTC, ETH (ERC20)…" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                        @error('crypto_network')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="wallet_address" class="mb-1.5 block text-xs font-medium text-white/55">Wallet address</label>
                        <input id="wallet_address" type="text" name="wallet_address" value="{{ old('wallet_address') }}" placeholder="Paste the destination wallet address" class="w-full break-all rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                        @error('wallet_address')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <p class="text-xs text-amber-300/80">Double-check the address and network. Crypto transfers cannot be reversed once processed.</p>
                </div>

                <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-base font-bold text-white">Request withdrawal</button>
                <p class="text-center text-xs text-white/35">Your funds stay in your wallet until an administrator approves the request.</p>
            </form>
        </div>

        {{-- Recent withdrawals --}}
        <div class="reveal rounded-3xl glass p-6">
            <h2 class="font-bold">Recent requests</h2>
            <div class="mt-4 divide-y divide-white/5">
                @forelse ($recent as $req)
                    @php $badge = ['pending' => 'bg-amber-400/15 text-amber-300', 'approved' => 'bg-emerald/15 text-emerald', 'rejected' => 'bg-rose-400/15 text-rose-300'][$req->status] ?? 'bg-white/10 text-white/60'; @endphp
                    <div class="flex items-center justify-between gap-2 py-3">
                        <div>
                            <p class="text-sm font-semibold tabular-nums">${{ number_format((float) $req->amount, 2) }}</p>
                            <p class="text-xs text-white/45">{{ $req->methodLabel() }} · {{ $req->created_at->format('M j, Y') }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $badge }}">{{ $req->status }}</span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-white/45">No withdrawal requests yet.</p>
                @endforelse
            </div>
            <a href="{{ route('user.wallet') }}" class="mt-4 block text-center text-sm text-brand-bright hover:underline">Full history</a>
        </div>
    </div>

    <script>
        (function () {
            const form = document.querySelector('[data-withdraw]');
            if (!form) return;
            const $ = (s) => form.querySelector(s);

            function sync() {
                const method = form.querySelector('[data-method-radio]:checked')?.value || 'bank';
                form.querySelectorAll('[data-fields]').forEach((el) =>
                    el.classList.toggle('hidden', el.dataset.fields !== method));
                form.querySelectorAll('[data-method-card]').forEach((el) => {
                    const active = el.dataset.methodCard === method;
                    el.classList.toggle('ring-brand-bright', active);
                    el.classList.toggle('bg-white/10', active);
                    el.classList.toggle('ring-white/10', !active);
                    el.classList.toggle('bg-white/5', !active);
                });
            }

            form.querySelectorAll('[data-method-radio]').forEach((r) => r.addEventListener('change', sync));
            sync();

            document.querySelectorAll('[data-maxfill]').forEach((b) =>
                b.addEventListener('click', () => { $('#amount').value = b.dataset.maxfill; }));
        })();
    </script>

</x-app-layout>
