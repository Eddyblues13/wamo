@php
    $navLinks = [
        ['label' => 'Markets', 'href' => route('markets'), 'active' => request()->routeIs('markets')],
        ['label' => 'Invest', 'href' => route('invest'), 'active' => request()->routeIs('invest')],
        ['label' => 'Stocks', 'href' => route('stocks'), 'active' => request()->routeIs('stocks')],
        ['label' => 'Live Trading', 'href' => route('trading'), 'active' => request()->routeIs('trading')],
        ['label' => 'How it works', 'href' => route('home') . '#how', 'active' => false],
        ['label' => 'Reviews', 'href' => route('home') . '#testimonials', 'active' => false],
    ];
@endphp

<header data-nav class="fixed inset-x-0 top-0 z-50">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3.5 lg:px-8">
        <a href="{{ route('home') }}" aria-label="Fintriva home">
            <x-logo />
        </a>

        <div class="hidden items-center gap-8 md:flex">
            @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}" class="text-sm transition hover:text-white {{ $link['active'] ? 'text-white' : 'text-white/70' }}">{{ $link['label'] }}</a>
            @endforeach
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('login') }}" class="hidden text-sm font-medium text-white/80 transition hover:text-white md:block">Sign in</a>
            <a href="{{ route('register') }}" class="btn-glow hidden rounded-full px-5 py-2.5 text-sm font-semibold text-white sm:inline-flex">Start investing</a>

            {{-- Hamburger (opens full-screen menu) --}}
            <button data-nav-toggle class="grid h-11 w-11 place-items-center rounded-2xl glass transition active:scale-95 md:hidden" aria-label="Open menu" aria-expanded="false">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </nav>

    {{-- Full-screen mobile menu --}}
    <div data-nav-menu class="fixed inset-0 z-[70] hidden md:hidden">
        <div class="nav-overlay flex h-[100dvh] flex-col bg-ink-950/95 backdrop-blur-2xl">
            <div class="absolute inset-0 -z-10 bg-grid opacity-60"></div>
            <div class="pointer-events-none absolute -top-24 right-0 h-72 w-72 rounded-full bg-brand/20 blur-[100px]"></div>

            {{-- top bar --}}
            <div class="flex items-center justify-between px-5 py-3.5">
                <a href="{{ route('home') }}" aria-label="Fintriva home">
                    <x-logo />
                </a>
                <button data-nav-close class="grid h-11 w-11 place-items-center rounded-2xl glass transition active:scale-95" aria-label="Close menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>

            {{-- links --}}
            <nav class="flex flex-1 flex-col justify-center gap-1 px-6">
                @foreach ($navLinks as $link)
                    <a href="{{ $link['href'] }}" class="nav-item flex items-center justify-between border-b border-white/5 py-5 text-2xl font-bold tracking-tight transition {{ $link['active'] ? 'text-gradient' : 'text-white/85 hover:text-white' }}">
                        {{ $link['label'] }}
                        <svg class="h-5 w-5 text-white/25" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6"/></svg>
                    </a>
                @endforeach
            </nav>

            {{-- footer CTAs --}}
            <div class="grid grid-cols-2 gap-3 px-6 pb-[max(2.5rem,env(safe-area-inset-bottom))]">
                <a href="{{ route('login') }}" class="rounded-2xl glass py-3.5 text-center text-base font-semibold text-white/90 transition hover:bg-white/10">Sign in</a>
                <a href="{{ route('register') }}" class="btn-glow rounded-2xl py-3.5 text-center text-base font-bold text-white">Start investing</a>
            </div>
        </div>
    </div>
</header>
