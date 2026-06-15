{{-- ============ INVEST CATEGORIES ============ --}}
<section id="invest" class="py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <x-section-heading
            eyebrow="A complete asset suite"
            title="Invest across every major market"
            subtitle="Build a diversified portfolio from a single account — spanning digital assets, listed equities, real estate and currency markets." />

        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $cards = [
                    ['Cryptocurrency', 'Bitcoin, Ethereum and 200+ digital assets with instant settlement and staking rewards of up to 9% APY.', '₿', 'from-amber-400/30 to-orange-500/10', 'text-amber-300', route('crypto')],
                    ['Equities', 'Own fractional shares of Tesla, Apple, Nvidia and thousands of companies across global stock markets.', '📈', 'from-rose-400/30 to-red-500/10', 'text-rose-300', route('stocks')],
                    ['Foreign Exchange', 'Trade 60+ currency pairs around the clock with tight spreads and institutional-grade charting.', '💱', 'from-sky-400/30 to-indigo-500/10', 'text-sky-300', route('forex')],
                    ['Real Estate', 'Generate passive income through tokenized property portfolios across leading global cities.', '🏙️', 'from-emerald-400/30 to-teal-500/10', 'text-emerald-300', route('real-estate')],
                    ['Commodities', 'Hedge and diversify with gold, silver and oil — physically backed and fully liquid.', '🪙', 'from-yellow-400/30 to-amber-600/10', 'text-yellow-300', route('markets')],
                    ['Managed Portfolios', 'Allocate to expertly constructed portfolios that rebalance automatically to your strategy.', '🤖', 'from-violet-400/30 to-purple-600/10', 'text-violet-300', route('invest')],
                ];
            @endphp
            @foreach ($cards as [$title, $desc, $icon, $grad, $ic, $href])
                <a href="{{ $href }}" class="reveal" data-delay="{{ ($loop->index % 3) * 100 }}">
                    <div data-tilt class="tilt group h-full rounded-3xl glass p-7 transition hover:bg-white/[0.07]">
                        <div class="tilt-pop">
                            <div class="grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br {{ $grad }} text-2xl ring-1 ring-white/10">{{ $icon }}</div>
                            <h3 class="mt-5 text-xl font-bold {{ $ic }}">{{ $title }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-white/60">{{ $desc }}</p>
                            <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-white/80 transition group-hover:gap-2.5">
                                Explore
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
