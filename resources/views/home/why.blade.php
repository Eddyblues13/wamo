{{-- ============ WHY FINTRIVA (bento) ============ --}}
<section class="py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <x-section-heading eyebrow="Built for serious investors" title="Why investors choose Fintriva" />

        <div class="mt-14 grid auto-rows-[180px] grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Feature hero cell --}}
            <div class="reveal gradient-border group relative col-span-1 row-span-2 overflow-hidden rounded-3xl glass p-7 sm:col-span-2">
                <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full bg-brand/20 blur-2xl transition group-hover:bg-brand/30"></div>
                <div class="relative flex h-full flex-col justify-between">
                    <div class="grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-brand to-violet text-2xl shadow-lg">🛡️</div>
                    <div>
                        <h3 class="text-2xl font-bold">Institutional-grade security</h3>
                        <p class="mt-2 max-w-md text-white/60">Client funds are held in insured, cold-storage custody, protected by 256-bit encryption, biometric authentication and continuous fraud monitoring.</p>
                    </div>
                </div>
            </div>

            @php
                $bento = [
                    ['⚡', 'Rapid withdrawals', 'Settle funds to your bank in seconds, any day of the week.'],
                    ['💸', 'Transparent pricing', 'A flat 0.1% fee with no hidden spreads or surprise charges.'],
                    ['🔒', 'Insured to $250k', 'Eligible balances are protected by custodial insurance.'],
                    ['🌍', '180+ countries', 'Invest globally across 30+ currencies from one account.'],
                ];
            @endphp
            @foreach ($bento as [$icon, $title, $desc])
                <div class="reveal group rounded-3xl glass p-6 transition hover:bg-white/[0.07]" data-delay="{{ $loop->index * 80 }}">
                    <div class="text-3xl transition group-hover:scale-110">{{ $icon }}</div>
                    <h3 class="mt-3 font-bold">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-white/55">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
