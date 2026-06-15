{{-- ============ STATS ============ --}}
<section class="py-20">
    <div class="mx-auto grid max-w-7xl grid-cols-2 gap-8 px-6 lg:grid-cols-4 lg:px-8">
        @foreach ([['12.4', 'B', 'Assets under management', '$'],['240', 'K+', 'Active investors', ''],['99.99', '%', 'Platform uptime', ''],['180', '+', 'Countries supported', '']] as [$num, $suf, $label, $pre])
            <div class="reveal text-center" data-delay="{{ $loop->index * 80 }}">
                <p class="text-4xl font-black text-gradient sm:text-5xl">
                    <span data-count="{{ $num }}" data-decimals="{{ str_contains($num, '.') ? 2 : 0 }}" data-prefix="{{ $pre }}" data-suffix="{{ $suf }}">0</span>
                </p>
                <p class="mt-2 text-sm text-white/60">{{ $label }}</p>
            </div>
        @endforeach
    </div>
</section>
