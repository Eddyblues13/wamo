{{-- ============ POPULAR STOCKS ============ --}}
<section id="stocks" class="py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="reveal flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-widest text-brand-bright">Equities</p>
                <h2 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">Invest in the world's leading companies</h2>
                <p class="mt-4 text-lg text-white/60">Acquire fractional shares of the largest publicly listed companies from as little as $1 — commission-free, settled in real time.</p>
            </div>
            <a href="{{ route('stocks') }}" class="inline-flex shrink-0 items-center gap-2 rounded-full glass px-6 py-3 text-sm font-semibold text-white/90 transition hover:bg-white/10">
                View all stocks
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @php
                // [ticker, company, badge, price, change%, up?, gradient, sparkline-points]
                $stocks = [
                    ['TSLA', 'Tesla, Inc.', 'T', '248.50', '+1.9%', true, 'from-red-500 to-rose-600', '0,28 12,22 24,25 36,14 48,18 60,8 72,12 84,4'],
                    ['AMZN', 'Amazon.com', 'a', '186.40', '+2.6%', true, 'from-orange-400 to-amber-500', '0,30 12,26 24,28 36,20 48,22 60,12 72,15 84,6'],
                    ['AAPL', 'Apple Inc.', '', '226.10', '+0.7%', true, 'from-zinc-400 to-zinc-600', '0,20 12,18 24,22 36,16 48,19 60,12 72,14 84,9'],
                    ['NVDA', 'NVIDIA Corp.', 'N', '124.80', '+3.2%', true, 'from-green-500 to-emerald-600', '0,32 12,26 24,24 36,18 48,14 60,10 72,8 84,3'],
                    ['MSFT', 'Microsoft', '⊞', '441.20', '+1.1%', true, 'from-sky-500 to-blue-600', '0,22 12,20 24,18 36,17 48,14 60,13 72,10 84,8'],
                    ['GOOGL', 'Alphabet', 'G', '178.90', '-0.4%', false, 'from-blue-400 to-indigo-500', '0,10 12,14 24,12 36,18 48,16 60,22 72,20 84,26'],
                    ['META', 'Meta Platforms', 'M', '512.30', '+2.0%', true, 'from-blue-500 to-sky-500', '0,28 12,24 24,26 36,18 48,20 60,12 72,14 84,7'],
                    ['NFLX', 'Netflix', 'N', '678.10', '-0.8%', false, 'from-red-600 to-rose-700', '0,8 12,12 24,10 36,16 48,14 60,20 72,18 84,24'],
                ];
            @endphp
            @foreach ($stocks as [$ticker, $company, $badge, $price, $change, $up, $grad, $spark])
                <div class="reveal" data-delay="{{ ($loop->index % 4) * 80 }}">
                    <div data-tilt class="tilt group flex h-full flex-col rounded-3xl glass p-5 transition hover:bg-white/[0.07]">
                        <div class="tilt-pop flex h-full flex-col">
                            <div class="flex items-center gap-3">
                                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br {{ $grad }} text-lg font-black text-white shadow-lg">{{ $badge !== '' ? $badge : $ticker[0] }}</span>
                                <div class="min-w-0">
                                    <p class="font-bold leading-tight">{{ $ticker }}</p>
                                    <p class="truncate text-xs text-white/50">{{ $company }}</p>
                                </div>
                            </div>

                            {{-- sparkline --}}
                            <div class="mt-5 h-10">
                                <svg viewBox="0 0 84 36" preserveAspectRatio="none" class="h-full w-full">
                                    <polyline points="{{ $spark }}" fill="none" stroke="{{ $up ? 'oklch(0.78 0.18 165)' : 'oklch(0.65 0.2 20)' }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            <div class="mt-5 flex items-end justify-between">
                                <div>
                                    <p class="text-xl font-bold tabular-nums" data-stock-price>${{ $price }}</p>
                                    <p class="text-xs font-semibold tabular-nums {{ $up ? 'text-emerald' : 'text-rose-400' }}" data-stock-change>{{ $change }} today</p>
                                </div>
                                <a href="{{ route('register') }}" class="rounded-full bg-white px-4 py-2 text-sm font-bold text-ink-950 shadow-lg transition group-hover:bg-brand-bright group-hover:text-white">Buy</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
