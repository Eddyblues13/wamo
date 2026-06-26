<x-layout title="Real Estate — Fintriva" description="Earn passive income from tokenized property portfolios across prime global cities.">

    <x-page-hero
        eyebrow="Real Estate"
        title='Own <span class="text-gradient">property</span>, earn passive income'
        subtitle="Invest in fractional, tokenized real estate across prime cities — from $50 — and collect rental income paid monthly.">
        <x-slot:actions>
            <a href="{{ route('register') }}" data-magnetic class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">Start investing</a>
            <a href="{{ route('invest') }}" class="rounded-full glass px-7 py-3.5 text-base font-semibold text-white/90 transition hover:bg-white/10">Explore all assets</a>
        </x-slot:actions>
    </x-page-hero>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading eyebrow="Featured properties" title="Tokenized portfolios" />
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $props = [
                        ['Dubai Marina Residences', 'Dubai, UAE', '8.4%', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=900&q=80'],
                        ['Manhattan Loft Fund', 'New York, USA', '6.9%', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=900&q=80'],
                        ['London Riverside Estate', 'London, UK', '7.2%', 'https://images.unsplash.com/photo-1529180184525-78f99adf0a9f?auto=format&fit=crop&w=900&q=80'],
                    ];
                @endphp
                @foreach ($props as [$name, $city, $yield, $img])
                    <div class="reveal group overflow-hidden rounded-3xl glass" data-delay="{{ $loop->index * 90 }}">
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-emerald-500/40 to-teal-600/30">
                            <img src="{{ $img }}" alt="{{ $name }}" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none'" class="h-full w-full object-cover opacity-80 transition duration-500 group-hover:scale-105">
                            <span class="absolute right-3 top-3 rounded-full bg-emerald px-3 py-1 text-xs font-bold text-emerald-950">{{ $yield }} yield</span>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold">{{ $name }}</h3>
                            <p class="mt-1 text-sm text-white/50">{{ $city }}</p>
                            <a href="{{ route('register') }}" class="mt-5 inline-flex w-full items-center justify-center rounded-full bg-white px-4 py-2.5 text-sm font-bold text-ink-950 transition hover:bg-brand-bright hover:text-white">Invest from $50</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta title='Build a <span class="text-gradient">property</span> portfolio' />

</x-layout>
