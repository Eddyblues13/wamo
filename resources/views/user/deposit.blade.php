<x-app-layout title="Deposit — Wamo">

    @php
        $typeMeta = [
            'crypto' => ['label' => 'Cryptocurrency', 'icon' => '₿', 'desc' => 'BTC, USDT, ETH, LTC & more'],
            'bank' => ['label' => 'Bank transfer', 'icon' => '🏦', 'desc' => 'Pay from your bank account'],
        ];
        $grouped = $methods->groupBy('type');
    @endphp

    <div class="reveal mx-auto max-w-3xl">
        <h1 class="text-2xl font-black tracking-tight sm:text-3xl">Deposit funds</h1>
        <p class="mt-1 text-white/55">Complete the steps below to fund your wallet.</p>

        {{-- Stepper --}}
        <div class="mt-6 flex items-center gap-2 text-xs font-semibold">
            @foreach (['Method', 'Currency', 'Payment'] as $i => $label)
                <div class="flex items-center gap-2" data-step-dot="{{ $i + 1 }}">
                    <span class="grid h-7 w-7 place-items-center rounded-full bg-white/10 text-white/50 transition" data-step-num>{{ $i + 1 }}</span>
                    <span class="hidden text-white/50 transition sm:inline" data-step-label>{{ $label }}</span>
                </div>
                @if ($i < 2)<div class="h-px flex-1 bg-white/10"></div>@endif
            @endforeach
        </div>
    </div>

    @if ($methods->isEmpty())
        <div class="reveal mx-auto mt-8 max-w-3xl rounded-3xl glass p-8 text-center text-white/55">No deposit methods are available right now. Please check back soon.</div>
    @else
    <form action="{{ route('user.deposit.store') }}" method="post" enctype="multipart/form-data" class="reveal mx-auto mt-6 max-w-3xl" data-deposit>
        @csrf
        <input type="hidden" name="deposit_method_id" data-method-id>

        {{-- STEP 1: payment type --}}
        <section data-step="1">
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($grouped as $type => $ms)
                    <button type="button" data-pick-type="{{ $type }}" class="flex items-center gap-4 rounded-3xl glass p-6 text-left transition hover:bg-white/[0.07]">
                        <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-brand to-violet text-2xl">{{ $typeMeta[$type]['icon'] ?? '💳' }}</span>
                        <div>
                            <p class="text-lg font-bold">{{ $typeMeta[$type]['label'] ?? ucfirst($type) }}</p>
                            <p class="text-sm text-white/55">{{ $typeMeta[$type]['desc'] ?? '' }}</p>
                        </div>
                        <svg class="ml-auto h-5 w-5 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6"/></svg>
                    </button>
                @endforeach
            </div>
        </section>

        {{-- STEP 2: choose specific method --}}
        <section data-step="2" class="hidden">
            <button type="button" data-back="1" class="mb-4 text-sm text-white/50 transition hover:text-white">← Back</button>
            <h2 class="mb-4 font-bold" data-step2-title>Select a currency</h2>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                @foreach ($methods as $m)
                    <button type="button"
                        data-pick-method
                        data-type="{{ $m->type }}"
                        data-id="{{ $m->id }}"
                        data-name="{{ $m->name }}"
                        data-code="{{ $m->code }}"
                        data-network="{{ $m->network }}"
                        data-address="{{ $m->address }}"
                        data-bank="{{ $m->bank_name }}"
                        data-account-name="{{ $m->account_name }}"
                        data-account-number="{{ $m->account_number }}"
                        data-instructions="{{ $m->instructions }}"
                        data-min="{{ $m->min_amount }}"
                        class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-3 py-3 text-left transition hover:border-brand hover:bg-brand/10">
                        <span class="text-xl">{{ $m->icon }}</span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold">{{ $m->isCrypto() ? $m->code : $m->name }}</p>
                            <p class="truncate text-[11px] text-white/45">{{ $m->network ?: ($m->isCrypto() ? '' : 'Bank') }}</p>
                        </div>
                    </button>
                @endforeach
            </div>
        </section>

        {{-- STEP 3: details + amount + proof --}}
        <section data-step="3" class="hidden space-y-6">
            <button type="button" data-back="2" class="text-sm text-white/50 transition hover:text-white">← Back</button>

            {{-- payment details --}}
            <div class="rounded-3xl glass p-6">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold">Send your payment to</h2>
                    <span data-d-badge class="rounded-full bg-brand/15 px-3 py-1 text-xs font-semibold text-brand-bright"></span>
                </div>

                <div data-d-crypto class="mt-4 hidden">
                    <div class="flex flex-col items-center gap-4 sm:flex-row">
                        <img data-d-qr alt="Wallet QR" class="h-32 w-32 shrink-0 rounded-xl bg-white p-1.5" referrerpolicy="no-referrer" onerror="this.style.display='none'">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs text-white/45">Wallet address</p>
                            <div class="mt-1 flex items-center gap-2 rounded-2xl bg-white/5 p-3 ring-1 ring-white/10">
                                <code data-d-address class="min-w-0 flex-1 break-all text-sm text-white/90"></code>
                                <button type="button" data-copy="address" class="shrink-0 rounded-lg bg-white/10 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-white/20">Copy</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-d-bank class="mt-4 hidden space-y-2 rounded-2xl bg-white/5 p-4 text-sm">
                    <div class="flex justify-between"><span class="text-white/50">Bank</span><span data-d-bankname class="font-semibold"></span></div>
                    <div class="flex justify-between"><span class="text-white/50">Account name</span><span data-d-accname class="font-semibold"></span></div>
                    <div class="flex items-center justify-between"><span class="text-white/50">Account number</span><span class="flex items-center gap-2"><span data-d-accnum class="font-semibold"></span><button type="button" data-copy="accnum" class="rounded-lg bg-white/10 px-2 py-1 text-xs font-semibold transition hover:bg-white/20">Copy</button></span></div>
                </div>

                <p data-d-instructions class="mt-4 text-sm text-white/55"></p>
            </div>

            {{-- amount + proof --}}
            <div class="rounded-3xl glass p-6">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="amount" class="mb-1.5 block text-sm font-medium text-white/60">Amount sent (USD)</label>
                        <div class="flex items-center rounded-2xl bg-white/5 px-4 ring-1 ring-white/10 focus-within:ring-brand-bright">
                            <span class="text-lg text-white/40">$</span>
                            <input id="amount" type="number" name="amount" min="1" step="0.01" required value="{{ old('amount') }}" placeholder="100.00" class="w-full bg-transparent py-3 pl-2 text-lg font-bold text-white outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                        @error('amount')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="reference" class="mb-1.5 block text-sm font-medium text-white/60">Tx ref / sender <span class="text-white/30">(optional)</span></label>
                        <input id="reference" type="text" name="reference" value="{{ old('reference') }}" placeholder="Tx hash or name" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                    </div>
                </div>

                {{-- proof of payment --}}
                <div class="mt-4">
                    <label class="mb-1.5 block text-sm font-medium text-white/60">Proof of payment</label>
                    <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-dashed border-white/20 bg-white/5 px-4 py-4 transition hover:border-brand">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/10 text-lg">📎</span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold" data-proof-label>Upload screenshot or receipt</p>
                            <p class="text-xs text-white/45">JPG, PNG, WEBP or PDF · max 5MB</p>
                        </div>
                        <input type="file" name="proof" accept="image/*,application/pdf" required class="sr-only" data-proof-input>
                    </label>
                    @error('proof')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-glow mt-5 w-full rounded-2xl py-3.5 text-base font-bold text-white">I have paid — submit deposit</button>
                <p class="mt-3 text-center text-xs text-white/35">Your wallet is credited after an administrator confirms your payment.</p>
            </div>
        </section>
    </form>

    {{-- Recent requests --}}
    <div class="reveal mx-auto mt-8 max-w-3xl rounded-3xl glass p-6">
        <h2 class="font-bold">Your deposits</h2>
        <div class="mt-4 divide-y divide-white/5">
            @forelse ($requests as $r)
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="text-sm font-semibold tabular-nums">${{ number_format((float) $r->amount, 2) }}</p>
                        <p class="text-xs text-white/45">{{ $r->method_label }} · {{ $r->created_at->format('M j, g:i A') }}</p>
                    </div>
                    @php $badge = ['pending' => 'bg-amber-400/15 text-amber-300', 'approved' => 'bg-emerald/15 text-emerald', 'rejected' => 'bg-rose-400/15 text-rose-300'][$r->status] ?? 'bg-white/10 text-white/60'; @endphp
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $badge }}">{{ $r->status }}</span>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-white/45">No deposits yet.</p>
            @endforelse
        </div>
    </div>
    @endif

    {{-- Processing overlay --}}
    @if (session('processing'))
        <div data-processing class="fixed inset-0 z-[80] grid place-items-center bg-ink-950/90 px-6 backdrop-blur-xl">
            <div class="w-full max-w-sm rounded-3xl glass p-8 text-center">
                <div data-proc-spin class="mx-auto h-16 w-16 animate-spin rounded-full border-4 border-white/10 border-t-brand-bright"></div>
                <div data-proc-done class="mx-auto hidden grid h-16 w-16 place-items-center rounded-full bg-emerald/15 text-3xl text-emerald">✓</div>
                <h2 data-proc-title class="mt-6 text-xl font-bold">Confirming your payment…</h2>
                <p data-proc-text class="mt-2 text-sm text-white/55">Please wait while we verify your transaction on the network. This can take a couple of minutes.</p>
                <div class="mt-5 h-1.5 w-full overflow-hidden rounded-full bg-white/10">
                    <div data-proc-bar class="h-full w-0 rounded-full bg-gradient-to-r from-brand to-violet transition-[width] duration-1000 ease-linear"></div>
                </div>
                <a href="{{ route('user.dashboard') }}" data-proc-cta class="btn-glow mt-6 hidden w-full rounded-2xl py-3 text-sm font-bold text-white">Go to dashboard</a>
            </div>
        </div>
    @endif

    <script>
        (function () {
            const form = document.querySelector('[data-deposit]');
            if (form) {
                const $ = (s, r = document) => r.querySelector(s);
                const steps = { 1: $('[data-step="1"]'), 2: $('[data-step="2"]'), 3: $('[data-step="3"]') };
                let chosenType = null;

                function goto(n) {
                    Object.entries(steps).forEach(([k, el]) => el && el.classList.toggle('hidden', +k !== n));
                    document.querySelectorAll('[data-step-dot]').forEach((d) => {
                        const active = +d.dataset.stepDot <= n;
                        $('[data-step-num]', d).classList.toggle('bg-brand', active);
                        $('[data-step-num]', d).classList.toggle('text-white', active);
                        $('[data-step-num]', d).classList.toggle('bg-white/10', !active);
                        $('[data-step-num]', d).classList.toggle('text-white/50', !active);
                    });
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }

                document.querySelectorAll('[data-pick-type]').forEach((b) =>
                    b.addEventListener('click', () => {
                        chosenType = b.dataset.pickType;
                        document.querySelectorAll('[data-pick-method]').forEach((m) =>
                            m.classList.toggle('hidden', m.dataset.type !== chosenType));
                        $('[data-step2-title]').textContent = chosenType === 'bank' ? 'Select a bank option' : 'Select a coin & network';
                        goto(2);
                    }));

                document.querySelectorAll('[data-back]').forEach((b) =>
                    b.addEventListener('click', () => goto(+b.dataset.back)));

                document.querySelectorAll('[data-pick-method]').forEach((b) =>
                    b.addEventListener('click', () => {
                        const d = b.dataset;
                        $('[data-method-id]').value = d.id;
                        $('[data-d-badge]').textContent = d.type === 'crypto' ? (d.code + (d.network ? ' · ' + d.network : '')) : 'Bank transfer';
                        $('[data-d-instructions]').textContent = d.instructions || '';
                        $('#amount').min = d.min || 1;
                        const crypto = $('[data-d-crypto]'), bank = $('[data-d-bank]');
                        if (d.type === 'crypto') {
                            crypto.classList.remove('hidden'); bank.classList.add('hidden');
                            $('[data-d-address]').textContent = d.address || '';
                            const qr = $('[data-d-qr]'); qr.style.display = '';
                            qr.src = 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=' + encodeURIComponent(d.address || '');
                        } else {
                            bank.classList.remove('hidden'); crypto.classList.add('hidden');
                            $('[data-d-bankname]').textContent = d.bank || '';
                            $('[data-d-accname]').textContent = d.accountName || '';
                            $('[data-d-accnum]').textContent = d.accountNumber || '';
                        }
                        goto(3);
                    }));

                form.addEventListener('click', (e) => {
                    const c = e.target.closest('[data-copy]');
                    if (!c) return;
                    const sel = c.dataset.copy === 'address' ? '[data-d-address]' : '[data-d-accnum]';
                    navigator.clipboard?.writeText($(sel).textContent);
                    const t = c.textContent; c.textContent = 'Copied'; setTimeout(() => (c.textContent = t), 1200);
                });

                const file = $('[data-proof-input]');
                file?.addEventListener('change', () => {
                    if (file.files[0]) $('[data-proof-label]').textContent = file.files[0].name;
                });
            }

            // Processing screen: run ~2 minutes, then show "pending".
            const proc = document.querySelector('[data-processing]');
            if (proc) {
                const DURATION = 120; // seconds
                const bar = proc.querySelector('[data-proc-bar]');
                let elapsed = 0;
                const tick = setInterval(() => {
                    elapsed++;
                    bar.style.width = Math.min(100, (elapsed / DURATION) * 100) + '%';
                    if (elapsed >= DURATION) {
                        clearInterval(tick);
                        proc.querySelector('[data-proc-spin]').classList.add('hidden');
                        proc.querySelector('[data-proc-done]').classList.remove('hidden');
                        proc.querySelector('[data-proc-title]').textContent = 'Deposit pending';
                        proc.querySelector('[data-proc-text]').textContent = 'Your deposit has been received and is pending administrator approval. You will be credited shortly.';
                        proc.querySelector('[data-proc-cta]').classList.remove('hidden');
                    }
                }, 1000);
            }
        })();
    </script>

</x-app-layout>
