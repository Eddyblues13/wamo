@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
])

<section class="relative overflow-hidden pt-36 pb-16 lg:pt-44">
    <div class="absolute inset-0 -z-10 bg-grid"></div>
    <div class="mx-auto max-w-4xl px-6 text-center lg:px-8">
        @if ($eyebrow)
            <p class="reveal text-sm font-semibold uppercase tracking-widest text-brand-bright">{{ $eyebrow }}</p>
        @endif
        <h1 class="reveal mt-4 text-5xl font-black leading-[1.05] tracking-tight sm:text-6xl">{!! $title !!}</h1>
        @if ($subtitle)
            <p class="reveal mx-auto mt-6 max-w-2xl text-lg text-white/65">{{ $subtitle }}</p>
        @endif
        @isset($actions)
            <div class="reveal mt-9 flex flex-wrap items-center justify-center gap-4">{{ $actions }}</div>
        @endisset
    </div>
</section>
