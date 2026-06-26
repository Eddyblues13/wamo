<x-layout title="Press — Fintriva" description="Fintriva press releases, media coverage and brand assets.">

    <x-page-hero
        eyebrow="Press"
        title='Fintriva in the <span class="text-gradient">news</span>'
        subtitle="Latest announcements, media coverage and resources for journalists.">
        <x-slot:actions>
            <a href="mailto:press@fintriva.com" class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">Contact press team</a>
        </x-slot:actions>
    </x-page-hero>

    <section class="py-16">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <x-section-heading eyebrow="Announcements" title="Latest releases" />
            <div class="mt-12 space-y-4">
                @php
                    $releases = [
                        ['Jun 2026', 'Fintriva surpasses 240,000 active investors worldwide'],
                        ['Apr 2026', 'Fintriva launches tokenized real estate in 12 new markets'],
                        ['Feb 2026', 'Fintriva raises $85M Series B to expand global trading'],
                        ['Nov 2025', 'Fintriva introduces commission-free fractional stock trading'],
                    ];
                @endphp
                @foreach ($releases as [$date, $title])
                    <a href="#" class="reveal flex items-center justify-between gap-4 rounded-2xl glass p-6 transition hover:bg-white/[0.07]" data-delay="{{ $loop->index * 60 }}">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-brand-bright">{{ $date }}</p>
                            <h3 class="mt-1 font-bold">{{ $title }}</h3>
                        </div>
                        <svg class="h-5 w-5 shrink-0 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading title="As featured in" />
            <div class="mt-10 flex flex-wrap items-center justify-center gap-x-12 gap-y-6 opacity-60">
                @foreach (['Bloomberg', 'Forbes', 'TechCrunch', 'Reuters', 'CoinDesk', 'WSJ'] as $brand)
                    <span class="reveal text-xl font-black tracking-tight text-white/70" data-delay="{{ $loop->index * 60 }}">{{ $brand }}</span>
                @endforeach
            </div>
        </div>
    </section>

</x-layout>
