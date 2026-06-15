<x-layout title="Stocks & Tesla — Wamo" description="Buy fractional shares of Tesla, Amazon, Apple, Nvidia and thousands of global stocks, commission-free.">

    <x-page-hero
        eyebrow="Stocks & Tesla"
        title='Own a piece of <span class="text-gradient">Tesla, Amazon & more</span>'
        subtitle="Buy fractional shares of the world's biggest companies from as little as $1 — commission-free, in real time.">
        <x-slot:actions>
            <a href="{{ route('register') }}" data-magnetic class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">Buy your first stock</a>
            <a href="{{ route('markets') }}" class="rounded-full glass px-7 py-3.5 text-base font-semibold text-white/90 transition hover:bg-white/10">See all markets</a>
        </x-slot:actions>
    </x-page-hero>

    @include('home.stocks')

    {{-- Sectors --}}
    <section class="pb-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading eyebrow="Browse by sector" title="Find your next investment" />
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([['Technology','🖥️','AAPL · NVDA · MSFT'],['Automotive','🚗','TSLA · RIVN · F'],['E-commerce','🛒','AMZN · SHOP · MELI'],['Finance','🏦','JPM · V · MA'],['Healthcare','🧬','PFE · JNJ · MRNA'],['Energy','⚡','XOM · CVX · NEE'],['Media','🎬','NFLX · DIS · SPOT'],['Consumer','🛍️','NKE · SBUX · MCD']] as [$sector, $icon, $tickers])
                    <div class="reveal rounded-3xl glass p-6 transition hover:bg-white/[0.07]" data-delay="{{ ($loop->index % 4) * 70 }}">
                        <div class="text-3xl">{{ $icon }}</div>
                        <h3 class="mt-3 font-bold">{{ $sector }}</h3>
                        <p class="mt-1 text-xs text-white/45">{{ $tickers }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta title='Start your <span class="text-gradient">stock</span> portfolio today' />

</x-layout>
