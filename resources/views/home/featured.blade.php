{{-- ============ AS FEATURED IN ============ --}}
<section class="py-12">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <p class="reveal text-center text-xs font-semibold uppercase tracking-[0.2em] text-white/40">As featured in</p>
        <div class="mt-6 flex flex-wrap items-center justify-center gap-x-12 gap-y-6 opacity-60">
            @foreach (['Bloomberg', 'Forbes', 'TechCrunch', 'Reuters', 'CoinDesk', 'WSJ'] as $brand)
                <span class="reveal text-xl font-black tracking-tight text-white/70 transition hover:text-white" data-delay="{{ $loop->index * 60 }}">{{ $brand }}</span>
            @endforeach
        </div>
    </div>
</section>
