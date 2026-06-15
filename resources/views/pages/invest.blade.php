<x-layout title="Invest — Wamo" description="Build a diversified portfolio across crypto, stocks, forex, real estate and managed funds.">

    <x-page-hero
        eyebrow="Invest"
        title='Build wealth that <span class="text-gradient">compounds</span>'
        subtitle="Diversify across every asset class from a single account — crypto, stocks, forex, real estate, commodities and expert-managed funds.">
        <x-slot:actions>
            <a href="{{ route('register') }}" data-magnetic class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">Open free account</a>
            <a href="{{ route('home') }}#how" class="rounded-full glass px-7 py-3.5 text-base font-semibold text-white/90 transition hover:bg-white/10">How it works</a>
        </x-slot:actions>
    </x-page-hero>

    @include('home.invest')
    @include('home.why')
    @include('home.how')

    <x-cta />

</x-layout>
