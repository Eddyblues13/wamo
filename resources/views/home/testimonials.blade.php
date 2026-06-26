{{-- ============ TESTIMONIALS ============ --}}
<section id="testimonials" class="py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <x-section-heading title="Trusted by investors worldwide" subtitle="Individuals and professionals rely on Fintriva to manage and grow their portfolios." />

        <div class="mt-16 grid gap-6 lg:grid-cols-3">
            @php
                $reviews = [
                    ['Sophia Adeyemi', 'Private investor', 'Fintriva lets me manage cryptocurrency and equities side by side in a single, clear portfolio. The reporting is genuinely excellent.'],
                    ['Daniel Okafor', 'Foreign exchange trader', 'Tight spreads, reliable execution and professional charting. I trade currencies daily and the platform has never let me down.'],
                    ['Amara Bello', 'Long-term investor', 'I allocated to a managed portfolio and it rebalances automatically. It has been the most considered financial decision I made this year.'],
                ];
            @endphp
            @foreach ($reviews as [$name, $role, $quote])
                <div class="reveal rounded-3xl glass p-7" data-delay="{{ $loop->index * 100 }}">
                    <div class="flex gap-1 text-gold">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                    <p class="mt-5 text-white/80">“{{ $quote }}”</p>
                    <div class="mt-6 flex items-center gap-3">
                        <span class="grid h-11 w-11 place-items-center rounded-full bg-gradient-to-br from-brand to-violet font-bold">{{ substr($name, 0, 1) }}</span>
                        <div>
                            <p class="text-sm font-semibold">{{ $name }}</p>
                            <p class="text-xs text-white/50">{{ $role }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
