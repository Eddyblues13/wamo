@props([
    'title' => 'Dashboard — Wamo',
])

@php
    $userNav = [
        ['label' => 'Dashboard', 'route' => 'user.dashboard', 'pattern' => 'user.dashboard'],
        ['label' => 'Invest', 'route' => 'user.invest', 'pattern' => 'user.invest'],
        ['label' => 'Stocks', 'route' => 'user.stocks', 'pattern' => 'user.stocks'],
        ['label' => 'Forex', 'route' => 'user.forex', 'pattern' => 'user.forex'],
        ['label' => 'Crypto', 'route' => 'user.crypto', 'pattern' => 'user.crypto'],
        ['label' => 'Wallet', 'route' => 'user.wallet', 'pattern' => 'user.wallet'],
    ];
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ink-950 text-white font-sans antialiased">

    {{-- Ambient glows --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -left-40 h-[34rem] w-[34rem] rounded-full bg-brand/20 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 h-[28rem] w-[28rem] rounded-full bg-violet/15 blur-[120px]"></div>
    </div>

    {{-- Navbar --}}
    <header data-nav class="sticky top-0 z-50 border-b border-white/10 bg-ink-950/70 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-3.5 lg:px-8">
            <a href="{{ route('user.dashboard') }}" aria-label="Wamo dashboard"><x-logo /></a>

            {{-- desktop nav --}}
            <nav class="hidden items-center gap-6 lg:flex">
                @foreach ($userNav as $item)
                    <a href="{{ route($item['route']) }}" class="text-sm font-medium transition hover:text-white {{ request()->routeIs($item['pattern']) ? 'text-white' : 'text-white/65' }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2.5">
                <span class="hidden rounded-full glass px-4 py-2 text-sm text-white/70 sm:block">
                    Balance <span class="ml-1 font-bold text-white">${{ number_format((float) auth()->user()->balance, 2) }}</span>
                </span>
                <a href="{{ route('user.deposit') }}" class="btn-glow hidden rounded-full px-4 py-2 text-sm font-semibold text-white sm:inline-flex">Deposit</a>
                <span class="hidden h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-brand to-violet text-sm font-bold sm:grid">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <form action="{{ route('logout') }}" method="post" class="hidden lg:block">
                    @csrf
                    <button type="submit" class="rounded-full glass px-4 py-2 text-sm font-medium text-white/80 transition hover:bg-white/10">Sign out</button>
                </form>

                {{-- hamburger --}}
                <button data-nav-toggle class="grid h-11 w-11 place-items-center rounded-2xl glass transition active:scale-95 lg:hidden" aria-label="Open menu" aria-expanded="false">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Full-screen mobile menu --}}
    <div data-nav-menu class="fixed inset-0 z-[70] hidden lg:hidden">
        <div class="nav-overlay flex h-[100dvh] flex-col bg-ink-950/95 backdrop-blur-2xl">
            <div class="absolute inset-0 -z-10 bg-grid opacity-60"></div>
            <div class="flex items-center justify-between px-5 py-3.5">
                <x-logo />
                <button data-nav-close class="grid h-11 w-11 place-items-center rounded-2xl glass" aria-label="Close menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>

            <div class="px-6 py-3">
                <div class="rounded-2xl glass px-4 py-3 text-sm text-white/70">Balance <span class="ml-1 text-lg font-bold text-white">${{ number_format((float) auth()->user()->balance, 2) }}</span></div>
            </div>

            <nav class="flex flex-1 flex-col justify-center gap-1 px-6">
                @foreach ($userNav as $item)
                    <a href="{{ route($item['route']) }}" class="nav-item flex items-center justify-between border-b border-white/5 py-4 text-xl font-bold {{ request()->routeIs($item['pattern']) ? 'text-gradient' : 'text-white/85' }}">
                        {{ $item['label'] }}
                        <svg class="h-5 w-5 text-white/25" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6"/></svg>
                    </a>
                @endforeach
            </nav>

            <div class="grid grid-cols-2 gap-3 px-6 pb-[max(2rem,env(safe-area-inset-bottom))]">
                <a href="{{ route('user.deposit') }}" class="btn-glow rounded-2xl py-3.5 text-center text-base font-bold text-white">Deposit</a>
                <a href="{{ route('user.withdraw') }}" class="rounded-2xl glass py-3.5 text-center text-base font-semibold text-white/90">Withdraw</a>
                <form action="{{ route('logout') }}" method="post" class="col-span-2">
                    @csrf
                    <button type="submit" class="w-full rounded-2xl bg-white/5 py-3 text-center text-sm font-semibold text-white/70">Sign out</button>
                </form>
            </div>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="reveal mb-6 rounded-2xl border border-emerald/30 bg-emerald/10 px-5 py-4 text-sm font-medium text-emerald">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="reveal mb-6 rounded-2xl border border-rose-400/30 bg-rose-400/10 px-5 py-4 text-sm font-medium text-rose-300">
                {{ $errors->first() }}
            </div>
        @endif

        {{ $slot }}
    </main>

    @include('partials.translator')

</body>
</html>
