<x-layout title="Crypto — Wamo" description="Buy, sell and stake Bitcoin, Ethereum and 200+ cryptocurrencies with rewards up to 9% APY.">

    <x-page-hero
        eyebrow="Crypto"
        title='Buy, sell & stake <span class="text-gradient">crypto</span>'
        subtitle="Bitcoin, Ethereum and 200+ tokens with instant swaps, insured custody and staking rewards up to 9% APY.">
        <x-slot:actions>
            <a href="{{ route('register') }}" data-magnetic class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">Buy crypto</a>
            <a href="{{ route('trading') }}" class="rounded-full glass px-7 py-3.5 text-base font-semibold text-white/90 transition hover:bg-white/10">Trade live</a>
        </x-slot:actions>
    </x-page-hero>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading eyebrow="Top coins" title="Popular cryptocurrencies" />
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $coins = [
                        ['₿', 'Bitcoin', 'BTC', '$67,420.00', '+3.8%', true, 'from-amber-400 to-orange-500'],
                        ['Ξ', 'Ethereum', 'ETH', '$3,540.10', '+2.4%', true, 'from-indigo-400 to-blue-600'],
                        ['◎', 'Solana', 'SOL', '$172.30', '+6.1%', true, 'from-purple-400 to-fuchsia-600'],
                        ['✕', 'XRP', 'XRP', '$0.612', '-1.1%', false, 'from-slate-400 to-slate-600'],
                        ['₳', 'Cardano', 'ADA', '$0.452', '+1.7%', true, 'from-sky-400 to-blue-600'],
                        ['🐕', 'Dogecoin', 'DOGE', '$0.138', '+4.5%', true, 'from-yellow-400 to-amber-600'],
                    ];
                @endphp
                @foreach ($coins as [$badge, $name, $sym, $price, $chg, $up, $grad])
                    <div class="reveal rounded-3xl glass p-6 transition hover:bg-white/[0.07]" data-delay="{{ ($loop->index % 3) * 80 }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="grid h-11 w-11 place-items-center rounded-full bg-gradient-to-br {{ $grad }} text-lg font-black text-white">{{ $badge }}</span>
                                <div>
                                    <p class="font-bold">{{ $name }}</p>
                                    <p class="text-xs text-white/45">{{ $sym }}</p>
                                </div>
                            </div>
                            <a href="{{ route('register') }}" class="rounded-full bg-white px-4 py-2 text-sm font-bold text-ink-950 transition hover:bg-brand-bright hover:text-white">Buy</a>
                        </div>
                        <div class="mt-5 flex items-end justify-between">
                            <p class="text-xl font-bold tabular-nums" data-stock-price>{{ $price }}</p>
                            <p class="text-sm font-semibold {{ $up ? 'text-emerald' : 'text-rose-400' }}" data-stock-change>{{ $chg }} today</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('home.why')

    <x-cta title='Start your <span class="text-gradient">crypto</span> journey' />

</x-layout>
