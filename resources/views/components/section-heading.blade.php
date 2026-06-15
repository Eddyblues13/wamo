@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'reveal mx-auto max-w-2xl text-center']) }}>
    @if ($eyebrow)
        <p class="text-sm font-semibold uppercase tracking-widest text-brand-bright">{{ $eyebrow }}</p>
    @endif
    <h2 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">{!! $title !!}</h2>
    @if ($subtitle)
        <p class="mt-4 text-lg text-white/60">{{ $subtitle }}</p>
    @endif
</div>
