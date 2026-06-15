{{-- ============ ASSET UNIVERSE (3D orbital animation) ============ --}}
<section class="overflow-hidden py-24">
    <div class="mx-auto grid max-w-7xl items-center gap-16 px-6 lg:grid-cols-2 lg:px-8">
        {{-- Copy --}}
        <div class="reveal">
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-bright">A unified portfolio</p>
            <h2 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">One account. Every asset class.</h2>
            <p class="mt-5 text-lg leading-relaxed text-white/65">
                Digital assets, global equities, currencies, commodities and real estate sit within a single,
                reconciled portfolio. Allocate capital, rebalance and monitor exposure across markets without
                ever leaving the platform.
            </p>

            <dl class="mt-9 grid grid-cols-2 gap-6 sm:max-w-md">
                @foreach ([['200+', 'Digital assets'],['5,000+', 'Global equities'],['60+', 'Currency pairs'],['24/7', 'Market access']] as [$num, $label])
                    <div>
                        <dt class="text-3xl font-black text-gradient">{{ $num }}</dt>
                        <dd class="mt-1 text-sm text-white/55">{{ $label }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        {{-- 3D orbital scene --}}
        <div class="reveal" data-delay="150">
            <div class="relative mx-auto h-[440px] w-full max-w-lg" style="perspective:1000px">
                {{-- ambient glow --}}
                <div class="absolute left-1/2 top-1/2 h-64 w-64 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand/25 blur-[90px] animate-pulse-glow"></div>

                {{-- tilted orbital plane --}}
                <div class="absolute inset-0" style="transform-style:preserve-3d;transform:rotateX(64deg)">
                    {{-- ring guides --}}
                    <div class="absolute inset-0 grid place-items-center"><div class="h-56 w-56 rounded-full border border-white/10"></div></div>
                    <div class="absolute inset-0 grid place-items-center"><div class="h-80 w-80 rounded-full border border-white/[0.06]"></div></div>
                    <div class="absolute inset-0 grid place-items-center"><div class="h-[26rem] w-[26rem] rounded-full border border-white/[0.04]"></div></div>

                    {{-- orbiting asset coins --}}
                    @php
                        // [symbol, gradient, radius(px), duration(s), delay(s)]
                        $orbs = [
                            ['₿', 'from-amber-400 to-orange-500', 112, 13, 0],
                            ['Ξ', 'from-indigo-400 to-blue-600', 112, 13, 6.5],
                            ['T', 'from-rose-400 to-red-600', 160, 19, 3],
                            ['a', 'from-orange-400 to-amber-500', 160, 19, 12],
                            ['€', 'from-sky-400 to-indigo-500', 208, 25, 8],
                            ['Au', 'from-yellow-400 to-amber-600', 208, 25, 18],
                        ];
                    @endphp
                    @foreach ($orbs as [$sym, $grad, $r, $dur, $delay])
                        <div class="orbit-spin absolute inset-0" style="animation-duration:{{ $dur }}s;animation-delay:-{{ $delay }}s">
                            <span class="absolute left-1/2 top-1/2 grid h-12 w-12 place-items-center rounded-full bg-gradient-to-br {{ $grad }} text-lg font-black text-white shadow-xl shadow-black/40 ring-1 ring-white/20"
                                  style="transform:translate(-50%,-50%) translateY(-{{ $r }}px) rotateX(-64deg)">{{ $sym }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- rotating 3D cube core --}}
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" style="perspective:600px">
                    <div class="cube h-28 w-28">
                        <div class="cube__face" style="transform:translateZ(56px)"><span class="text-3xl font-black text-gradient">W</span></div>
                        <div class="cube__face" style="transform:rotateY(180deg) translateZ(56px)"><span class="text-2xl">₿</span></div>
                        <div class="cube__face" style="transform:rotateY(90deg) translateZ(56px)"><span class="text-2xl">Ξ</span></div>
                        <div class="cube__face" style="transform:rotateY(-90deg) translateZ(56px)"><span class="text-xl font-black text-white/80">T</span></div>
                        <div class="cube__face" style="transform:rotateX(90deg) translateZ(56px)"><span class="text-2xl">€</span></div>
                        <div class="cube__face" style="transform:rotateX(-90deg) translateZ(56px)"><span class="text-2xl">$</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
