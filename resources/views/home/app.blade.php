{{-- ============ TRADE ANYWHERE (images) ============ --}}
<section class="py-24">
    <div class="mx-auto grid max-w-7xl items-center gap-14 px-6 lg:grid-cols-2 lg:px-8">
        {{-- Copy --}}
        <div class="reveal">
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-bright">Mobile platform</p>
            <h2 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">Your portfolio, wherever you are</h2>
            <p class="mt-4 text-lg text-white/60">Markets operate around the clock — and so does Fintriva. Monitor positions, execute trades and configure intelligent price alerts from any device, anywhere in the world.</p>

            <ul class="mt-8 space-y-4">
                @foreach (['Real-time alerts and price triggers', 'One-tap trading and recurring investments', 'Biometric authentication and insured custody', 'Consolidated portfolio tracking across every asset'] as $feature)
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-emerald/15 text-emerald">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        </span>
                        <span class="text-white/80">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="mt-9 flex flex-wrap gap-3">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-bold text-ink-950 transition hover:bg-white/90">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.05 12.04c-.03-2.6 2.13-3.85 2.22-3.91-1.21-1.77-3.1-2.02-3.77-2.04-1.6-.16-3.13.94-3.94.94-.81 0-2.07-.92-3.4-.9-1.75.03-3.36 1.02-4.26 2.58-1.82 3.16-.46 7.84 1.31 10.4.86 1.26 1.89 2.67 3.24 2.62 1.3-.05 1.79-.84 3.36-.84 1.57 0 2.01.84 3.39.81 1.4-.02 2.29-1.28 3.15-2.55.99-1.46 1.4-2.87 1.42-2.95-.03-.01-2.72-1.04-2.75-4.13zM14.6 4.6c.72-.87 1.2-2.08 1.07-3.29-1.03.04-2.28.69-3.02 1.56-.66.77-1.24 2-1.08 3.18 1.15.09 2.32-.58 3.03-1.45z"/></svg>
                    App Store
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-bold text-ink-950 transition hover:bg-white/90">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M3.6 2.3 13 11.7l-2.7 2.7L3.6 2.3zm12.1 12.1 3.1 1.8c.8.5.8 1.7 0 2.2l-3.1 1.8-3-3 3-2.8zM3 21.7V2.3l9.6 9.7L3 21.7zm10.3-7.3 2.7 2.7L3.6 21.7l9.7-9.6z"/></svg>
                    Google Play
                </a>
            </div>
        </div>

        {{-- Image / phone mockup --}}
        <div class="reveal" data-delay="150">
            <div class="relative mx-auto max-w-sm" style="perspective:1200px">
                {{-- floating live badges --}}
                <div class="absolute -left-6 top-16 z-20 animate-float rounded-2xl glass px-4 py-3 shadow-xl">
                    <p class="text-xs text-white/50">TSLA</p>
                    <p class="text-sm font-bold text-emerald">+1.9% ▲</p>
                </div>
                <div class="absolute -right-5 bottom-24 z-20 animate-float-slow rounded-2xl glass px-4 py-3 shadow-xl">
                    <p class="text-xs text-white/50">BTC</p>
                    <p class="text-sm font-bold text-emerald">$67,420</p>
                </div>

                {{-- phone frame with image --}}
                <div class="tilt relative rounded-[2.5rem] border-[10px] border-ink-900 bg-ink-900 shadow-2xl shadow-black/60" data-tilt>
                    <div class="tilt-pop overflow-hidden rounded-[1.8rem]">
                        <div class="aspect-[9/19] w-full bg-gradient-to-br from-brand/40 via-violet/30 to-emerald/30">
                            <img
                                src="https://images.unsplash.com/photo-1640340434855-6084b1f4901c?auto=format&fit=crop&w=700&q=80"
                                alt="Fintriva trading app with live crypto and stock charts"
                                loading="lazy"
                                referrerpolicy="no-referrer"
                                onerror="this.style.display='none'"
                                class="h-full w-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Imagery strip --}}
    <div class="mx-auto mt-20 max-w-7xl px-6 lg:px-8">
        <div class="grid gap-5 sm:grid-cols-3">
            @php
                $shots = [
                    ['Crypto markets', 'Bitcoin, Ethereum & 200+ assets', 'https://images.unsplash.com/photo-1621761191319-c6fb62004040?auto=format&fit=crop&w=900&q=80', 'from-amber-500/40 to-orange-600/30', route('crypto')],
                    ['Global stocks', 'Tesla, Amazon, Apple & more', 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=900&q=80', 'from-sky-500/40 to-indigo-600/30', route('stocks')],
                    ['Forex & commodities', '60+ pairs, gold, oil & silver', 'https://images.unsplash.com/photo-1535320903710-d993d3d77d29?auto=format&fit=crop&w=900&q=80', 'from-emerald-500/40 to-teal-600/30', route('forex')],
                ];
            @endphp
            @foreach ($shots as [$title, $sub, $img, $grad, $href])
                <a href="{{ $href }}" class="reveal group relative block h-56 overflow-hidden rounded-3xl glass" data-delay="{{ $loop->index * 100 }}">
                    <div class="absolute inset-0 bg-gradient-to-br {{ $grad }}"></div>
                    <img src="{{ $img }}" alt="{{ $title }}" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none'" class="absolute inset-0 h-full w-full object-cover opacity-70 transition duration-500 group-hover:scale-105 group-hover:opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-ink-950/40 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5">
                        <h3 class="text-lg font-bold">{{ $title }}</h3>
                        <p class="text-sm text-white/60">{{ $sub }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
