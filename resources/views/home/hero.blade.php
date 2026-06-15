{{-- ============ HERO ============ --}}
<section class="relative overflow-hidden pt-36 pb-24 lg:pt-44">
    <div class="absolute inset-0 -z-10 bg-grid"></div>
    <canvas id="constellation"></canvas>
    <div class="spotlight pointer-events-none absolute inset-0 -z-10" data-spotlight></div>

    <div class="mx-auto grid max-w-7xl items-center gap-16 px-6 lg:grid-cols-2 lg:px-8">
        {{-- Copy --}}
        <div class="reveal">
            <span class="inline-flex items-center gap-2 rounded-full glass px-4 py-1.5 text-xs font-medium text-white/80">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald"></span>
                </span>
                Trusted by 240,000+ investors worldwide
            </span>

            <h1 class="mt-6 text-5xl font-black leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                Invest with confidence in<br>
                <span class="word-rotate text-gradient" data-rotate='["digital assets","global equities","forex","commodities","real estate"]'>digital assets</span>
            </h1>

            <p class="mt-6 max-w-xl text-lg text-white/70">
                A single, secure platform to invest in cryptocurrencies, global equities, real estate and
                currency markets — engineered with institutional-grade security and real-time market intelligence.
            </p>

            <div class="mt-9 flex flex-col gap-4 sm:flex-row">
                <a href="{{ route('register') }}" data-magnetic class="btn-glow inline-flex items-center justify-center gap-2 rounded-full px-7 py-3.5 text-base font-semibold">
                    Open free account
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
                <a href="{{ route('markets') }}" class="inline-flex items-center justify-center gap-2 rounded-full glass px-7 py-3.5 text-base font-semibold text-white/90 transition hover:bg-white/10">
                    View live markets
                </a>
            </div>

            <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-4 text-sm text-white/60">
                <div class="flex items-center gap-2"><svg class="h-5 w-5 text-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> Regulated &amp; compliant</div>
                <div class="flex items-center gap-2"><svg class="h-5 w-5 text-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> Insured cold-storage custody</div>
                <div class="flex items-center gap-2"><svg class="h-5 w-5 text-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> Transparent, low fees</div>
            </div>
        </div>

        {{-- 3D visual: floating dashboard + coins --}}
        <div class="reveal mt-6 lg:mt-0" data-delay="150">
            <div class="relative mx-auto w-full max-w-sm lg:max-w-none" style="perspective:1400px">
                {{-- floating + spinning 3D coins --}}
                <div class="scene-3d absolute -left-3 top-4 z-20 h-16 w-16 animate-float sm:-left-6 sm:top-8 sm:h-24 sm:w-24" style="animation-delay:.3s">
                    <div class="coin coin-spin h-full w-full" style="--coin-a:#f9d65c;--coin-b:#c08a16">
                        <span class="grid h-full w-full place-items-center text-2xl font-black text-amber-900/80 sm:text-3xl">₿</span>
                    </div>
                </div>
                <div class="scene-3d absolute -right-2 top-1/3 z-20 h-14 w-14 animate-float-slow sm:-right-4 sm:h-20 sm:w-20">
                    <div class="coin coin-spin h-full w-full" style="--coin-a:#9bb7ff;--coin-b:#3b56b0;animation-duration:9s">
                        <span class="grid h-full w-full place-items-center text-xl font-black text-blue-950/80 sm:text-2xl">Ξ</span>
                    </div>
                </div>
                <div class="scene-3d absolute bottom-4 left-1/4 z-20 h-12 w-12 animate-float sm:bottom-6 sm:h-16 sm:w-16" style="animation-delay:.8s">
                    <div class="coin coin-spin h-full w-full" style="--coin-a:#bdf5d8;--coin-b:#1f9d6b;animation-duration:6s">
                        <span class="grid h-full w-full place-items-center text-base font-black text-emerald-950/80 sm:text-xl">$</span>
                    </div>
                </div>

                {{-- glass dashboard card --}}
                <div class="tilt gradient-border rounded-3xl glass p-6 shadow-2xl shadow-black/40" data-tilt>
                    <div class="tilt-pop">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-white/60">Portfolio value</p>
                                <p class="mt-1 text-3xl font-bold">$<span data-count="184920.42" data-decimals="2">0</span></p>
                            </div>
                            <span class="rounded-full bg-emerald/15 px-3 py-1 text-sm font-semibold text-emerald">+18.4%</span>
                        </div>

                        {{-- mini chart --}}
                        <div class="mt-6 h-28 w-full">
                            <svg viewBox="0 0 320 100" preserveAspectRatio="none" class="h-full w-full">
                                <defs>
                                    <linearGradient id="area" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="oklch(0.78 0.18 165)" stop-opacity="0.5"/>
                                        <stop offset="100%" stop-color="oklch(0.78 0.18 165)" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M0 80 C 40 60, 60 70, 90 55 S 150 30, 180 40 S 240 12, 280 22 S 310 8, 320 6" fill="none" stroke="oklch(0.78 0.18 165)" stroke-width="3" stroke-linecap="round"/>
                                <path d="M0 80 C 40 60, 60 70, 90 55 S 150 30, 180 40 S 240 12, 280 22 S 310 8, 320 6 L320 100 L0 100 Z" fill="url(#area)"/>
                            </svg>
                        </div>

                        {{-- holdings --}}
                        <div class="mt-4 space-y-3">
                            @foreach ([['Bitcoin','BTC','+4.2%','from-amber-400 to-orange-500'],['Tesla','TSLA','+2.1%','from-red-400 to-rose-600'],['EUR / USD','FX','-0.3%','from-sky-400 to-indigo-500']] as [$name, $sym, $chg, $grad])
                                <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br {{ $grad }} text-xs font-bold text-white">{{ $sym }}</span>
                                        <span class="text-sm font-medium">{{ $name }}</span>
                                    </div>
                                    <span class="text-sm font-semibold {{ str_starts_with($chg, '-') ? 'text-rose-400' : 'text-emerald' }}">{{ $chg }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
