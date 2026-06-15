@props([
    'title' => 'Start building your <span class="text-gradient">wealth</span> today',
    'subtitle' => 'Open a free account in minutes. No minimums, no hidden fees — just professional-grade investing.',
])

<section id="cta" class="px-6 py-24 lg:px-8">
    <div class="reveal gradient-border relative mx-auto max-w-5xl overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-brand/20 via-violet/10 to-emerald/10 p-10 text-center sm:p-16">
        <div class="pointer-events-none absolute -top-20 left-1/2 h-60 w-60 -translate-x-1/2 rounded-full bg-violet/30 blur-[100px]"></div>

        {{-- decorative spinning 3D coins --}}
        <div class="scene-3d pointer-events-none absolute -left-6 top-10 h-20 w-20 animate-float opacity-80 sm:left-10">
            <div class="coin coin-spin h-full w-full" style="--coin-a:#f9d65c;--coin-b:#c08a16">
                <span class="grid h-full w-full place-items-center text-2xl font-black text-amber-900/80">₿</span>
            </div>
        </div>
        <div class="scene-3d pointer-events-none absolute -right-4 bottom-10 h-16 w-16 animate-float-slow opacity-80 sm:right-12">
            <div class="coin coin-spin h-full w-full" style="--coin-a:#9bb7ff;--coin-b:#3b56b0;animation-duration:9s">
                <span class="grid h-full w-full place-items-center text-xl font-black text-blue-950/80">Ξ</span>
            </div>
        </div>
        <h2 class="relative text-4xl font-black tracking-tight sm:text-5xl">{!! $title !!}</h2>
        <p class="relative mx-auto mt-4 max-w-xl text-lg text-white/70">{{ $subtitle }}</p>
        <div class="relative mt-9 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('register') }}" data-magnetic class="btn-glow inline-flex items-center gap-2 rounded-full px-8 py-4 text-base font-semibold">Create free account</a>
            <a href="{{ route('markets') }}" class="rounded-full glass px-8 py-4 text-base font-semibold text-white/90 transition hover:bg-white/10">Explore markets</a>
        </div>
    </div>
</section>
