<x-layout title="Live Trading — Wamo" description="Trade crypto, stocks and forex with real-time charts, instant execution and pro tools.">

    <x-page-hero
        eyebrow="Live Trading"
        title='Trade like a <span class="text-gradient">professional</span>'
        subtitle="Real-time charts, deep liquidity, instant execution and leverage up to 20x — across crypto, stocks and forex.">
        <x-slot:actions>
            <a href="{{ route('register') }}" data-magnetic class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">Open trading account</a>
            <a href="{{ route('markets') }}" class="rounded-full glass px-7 py-3.5 text-base font-semibold text-white/90 transition hover:bg-white/10">View markets</a>
        </x-slot:actions>
    </x-page-hero>

    @include('home.trading')

    {{-- Trading features --}}
    <section class="pb-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([['🕐','24/7 markets','Crypto never closes, and forex runs 24/5 — trade whenever opportunity strikes.'],['📊','Advanced charting','100+ indicators, drawing tools and multi-timeframe analysis powered by TradingView.'],['⚙️','Smart order types','Market, limit, stop-loss and take-profit orders to automate your strategy.'],['🛡️','Risk controls','Set leverage, margin alerts and auto-liquidation buffers to stay in control.'],['⚡','Instant execution','Ultra-low latency matching engine fills your orders in milliseconds.'],['💬','24/7 support','Real humans, any time zone, whenever you need a hand.']] as [$icon, $title, $desc])
                    <div class="reveal rounded-3xl glass p-7 transition hover:bg-white/[0.07]" data-delay="{{ ($loop->index % 3) * 80 }}">
                        <div class="text-3xl">{{ $icon }}</div>
                        <h3 class="mt-4 text-lg font-bold">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-white/60">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta />

</x-layout>
