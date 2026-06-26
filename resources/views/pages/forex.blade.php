<x-layout title="Forex — Fintriva" description="Trade 60+ currency pairs 24/5 with tight spreads, leverage and pro-grade charting.">

    <x-page-hero
        eyebrow="Forex"
        title='Trade the world&apos;s <span class="text-gradient">currencies</span>'
        subtitle="60+ major, minor and exotic pairs, 24/5, with razor-tight spreads, leverage up to 20x and institutional-grade execution.">
        <x-slot:actions>
            <a href="{{ route('register') }}" data-magnetic class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">Start trading forex</a>
            <a href="{{ route('trading') }}" class="rounded-full glass px-7 py-3.5 text-base font-semibold text-white/90 transition hover:bg-white/10">Open live chart</a>
        </x-slot:actions>
    </x-page-hero>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading eyebrow="Major pairs" title="Live forex rates" />
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $pairs = [
                        ['EUR/USD', '1.0875', '-0.2%', false], ['GBP/USD', '1.2710', '+0.4%', true],
                        ['USD/JPY', '157.32', '+0.3%', true], ['USD/CHF', '0.8945', '-0.1%', false],
                        ['AUD/USD', '0.6642', '+0.5%', true], ['USD/CAD', '1.3705', '-0.2%', false],
                        ['NZD/USD', '0.6128', '+0.6%', true], ['EUR/GBP', '0.8556', '-0.3%', false],
                    ];
                @endphp
                @foreach ($pairs as [$pair, $rate, $chg, $up])
                    <div class="reveal rounded-3xl glass p-6 transition hover:bg-white/[0.07]" data-delay="{{ ($loop->index % 4) * 70 }}">
                        <p class="text-sm font-semibold text-white/70">{{ $pair }}</p>
                        <p class="mt-3 text-2xl font-bold tabular-nums" data-stock-price>{{ $rate }}</p>
                        <p class="mt-1 text-sm font-semibold {{ $up ? 'text-emerald' : 'text-rose-400' }}" data-stock-change>{{ $chg }} today</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid gap-5 sm:grid-cols-3">
                @foreach ([['💧','Deep liquidity','Tap institutional liquidity for tight spreads on every pair.'],['📈','Up to 20x leverage','Amplify your positions with flexible, transparent margin.'],['🛡️','Negative-balance protection','You can never lose more than your account balance.']] as [$icon, $title, $desc])
                    <div class="reveal rounded-3xl glass p-7" data-delay="{{ $loop->index * 80 }}">
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
