@props([
    'title' => 'Admin — Wamo',
])

@php
    $adminNav = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => '📊'],
        ['label' => 'Users', 'route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'icon' => '👥'],
        ['label' => 'Plans', 'route' => 'admin.plans.index', 'pattern' => 'admin.plans.*', 'icon' => '💼'],
        ['label' => 'Investments', 'route' => 'admin.investments.index', 'pattern' => 'admin.investments.*', 'icon' => '📈'],
        ['label' => 'Stocks', 'route' => 'admin.trades.index', 'params' => ['market' => 'stocks'], 'active' => 'stocks', 'icon' => '🏦'],
        ['label' => 'Forex', 'route' => 'admin.trades.index', 'params' => ['market' => 'forex'], 'active' => 'forex', 'icon' => '💱'],
        ['label' => 'Crypto', 'route' => 'admin.trades.index', 'params' => ['market' => 'crypto'], 'active' => 'crypto', 'icon' => '🪙'],
        ['label' => 'Deposits', 'route' => 'admin.deposits.index', 'pattern' => 'admin.deposits.*', 'icon' => '⬇️'],
        ['label' => 'Withdrawals', 'route' => 'admin.withdrawals.index', 'pattern' => 'admin.withdrawals.*', 'icon' => '⬆️'],
        ['label' => 'Deposit Methods', 'route' => 'admin.deposit-methods.index', 'pattern' => 'admin.deposit-methods.*', 'icon' => '🏧'],
        ['label' => 'Transactions', 'route' => 'admin.transactions.index', 'pattern' => 'admin.transactions.*', 'icon' => '💳'],
    ];
    $adminName = auth('admin')->user()?->name;
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

    <div class="lg:flex">
        {{-- Desktop sidebar --}}
        <aside class="hidden bg-ink-900/60 backdrop-blur-xl lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-white/10">
            <div class="flex items-center justify-between px-5 py-4">
                <a href="{{ route('admin.dashboard') }}"><x-logo /></a>
                <span class="rounded-full bg-brand/20 px-2.5 py-1 text-xs font-bold text-brand-bright">ADMIN</span>
            </div>

            <nav class="flex flex-1 flex-col gap-1 px-3 py-2">
                @foreach ($adminNav as $item)
                    @php
                        $isActive = isset($item['active'])
                            ? (request()->routeIs($item['route']) && request()->route('market') === $item['active'])
                            : request()->routeIs($item['pattern']);
                    @endphp
                    <a href="{{ route($item['route'], $item['params'] ?? []) }}"
                       class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium transition {{ $isActive ? 'bg-white/10 text-white' : 'text-white/65 hover:bg-white/5 hover:text-white' }}">
                        <span>{{ $item['icon'] }}</span>{{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-white/10 p-3">
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-white/65 transition hover:bg-white/5 hover:text-white">
                        <span>↩︎</span> Sign out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main column --}}
        <div class="flex-1 lg:pl-64">
            {{-- Mobile top navbar --}}
            <header class="sticky top-0 z-50 flex items-center justify-between border-b border-white/10 bg-ink-950/70 px-5 py-3.5 backdrop-blur-xl lg:hidden">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2"><x-logo /><span class="rounded-full bg-brand/20 px-2 py-0.5 text-[10px] font-bold text-brand-bright">ADMIN</span></a>
                <button data-nav-toggle class="grid h-11 w-11 place-items-center rounded-2xl glass transition active:scale-95" aria-label="Open menu" aria-expanded="false">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </header>

            {{-- Desktop header --}}
            <header class="hidden items-center justify-between border-b border-white/10 px-8 py-4 lg:flex">
                <h1 class="text-lg font-bold">{{ $title }}</h1>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="text-sm text-white/60 transition hover:text-white">View site ↗</a>
                    <span class="text-sm text-white/70">{{ $adminName }}</span>
                    <span class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-brand to-violet text-sm font-bold">{{ strtoupper(substr($adminName ?? 'A', 0, 1)) }}</span>
                </div>
            </header>

            <main class="px-5 py-6 sm:px-6 lg:px-8 lg:py-8">
                {{-- Mobile page title --}}
                <h1 class="mb-5 text-xl font-black tracking-tight lg:hidden">{{ $title }}</h1>

                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Full-screen mobile menu --}}
    <div data-nav-menu class="fixed inset-0 z-[70] hidden lg:hidden">
        <div class="nav-overlay flex h-[100dvh] flex-col bg-ink-950/95 backdrop-blur-2xl">
            <div class="absolute inset-0 -z-10 bg-grid opacity-60"></div>
            <div class="flex items-center justify-between px-5 py-3.5">
                <span class="flex items-center gap-2"><x-logo /><span class="rounded-full bg-brand/20 px-2 py-0.5 text-[10px] font-bold text-brand-bright">ADMIN</span></span>
                <button data-nav-close class="grid h-11 w-11 place-items-center rounded-2xl glass" aria-label="Close menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>

            @if ($adminName)
                <div class="px-6 py-2 text-sm text-white/50">Signed in as <span class="font-semibold text-white/80">{{ $adminName }}</span></div>
            @endif

            <nav class="flex flex-1 flex-col justify-center gap-1 px-6">
                @foreach ($adminNav as $item)
                    @php
                        $isActive = isset($item['active'])
                            ? (request()->routeIs($item['route']) && request()->route('market') === $item['active'])
                            : request()->routeIs($item['pattern']);
                    @endphp
                    <a href="{{ route($item['route'], $item['params'] ?? []) }}" class="nav-item flex items-center justify-between border-b border-white/5 py-4 text-xl font-bold {{ $isActive ? 'text-gradient' : 'text-white/85' }}">
                        <span class="flex items-center gap-3"><span class="text-base">{{ $item['icon'] }}</span>{{ $item['label'] }}</span>
                        <svg class="h-5 w-5 text-white/25" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6"/></svg>
                    </a>
                @endforeach
            </nav>

            <div class="grid grid-cols-2 gap-3 px-6 pb-[max(2rem,env(safe-area-inset-bottom))]">
                <a href="{{ route('home') }}" target="_blank" class="rounded-2xl glass py-3.5 text-center text-base font-semibold text-white/90">View site ↗</a>
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-center text-base font-bold text-white">Sign out</button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.toasts')

</body>
</html>
