@props([
    'title' => 'Admin — Wamo',
])

@php
    $adminNav = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => '📊'],
        ['label' => 'Users', 'route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'icon' => '👥'],
        ['label' => 'Plans', 'route' => 'admin.plans.index', 'pattern' => 'admin.plans.*', 'icon' => '💼'],
        ['label' => 'Investments', 'route' => 'admin.investments.index', 'pattern' => 'admin.investments.*', 'icon' => '📈'],
        ['label' => 'Deposits', 'route' => 'admin.deposits.index', 'pattern' => 'admin.deposits.*', 'icon' => '⬇️'],
        ['label' => 'Deposit Methods', 'route' => 'admin.deposit-methods.index', 'pattern' => 'admin.deposit-methods.*', 'icon' => '🏧'],
        ['label' => 'Transactions', 'route' => 'admin.transactions.index', 'pattern' => 'admin.transactions.*', 'icon' => '💳'],
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

    <div class="lg:flex">
        {{-- Sidebar --}}
        <aside class="border-b border-white/10 bg-ink-900/60 backdrop-blur-xl lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-b-0 lg:border-r">
            <div class="flex items-center justify-between px-5 py-4">
                <a href="{{ route('admin.dashboard') }}"><x-logo /></a>
                <span class="rounded-full bg-brand/20 px-2.5 py-1 text-xs font-bold text-brand-bright">ADMIN</span>
            </div>

            <nav class="flex gap-1 overflow-x-auto px-3 pb-3 lg:flex-1 lg:flex-col lg:overflow-visible lg:py-2">
                @foreach ($adminNav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex shrink-0 items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs($item['pattern']) ? 'bg-white/10 text-white' : 'text-white/65 hover:bg-white/5 hover:text-white' }}">
                        <span>{{ $item['icon'] }}</span>{{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="hidden border-t border-white/10 p-3 lg:block">
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-white/65 transition hover:bg-white/5 hover:text-white">
                        <span>↩︎</span> Sign out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 lg:pl-64">
            <header class="flex items-center justify-between border-b border-white/10 px-6 py-4 lg:px-8">
                <h1 class="text-lg font-bold">{{ $title }}</h1>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="hidden text-sm text-white/60 transition hover:text-white sm:block">View site ↗</a>
                    <span class="hidden text-sm text-white/70 sm:block">{{ auth('admin')->user()?->name }}</span>
                    <span class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-brand to-violet text-sm font-bold">{{ strtoupper(substr(auth('admin')->user()?->name ?? 'A', 0, 1)) }}</span>
                    <form action="{{ route('admin.logout') }}" method="post" class="lg:hidden">
                        @csrf
                        <button type="submit" class="rounded-full glass px-3 py-2 text-xs font-medium text-white/80">Sign out</button>
                    </form>
                </div>
            </header>

            <main class="px-6 py-8 lg:px-8">
                @if (session('status'))
                    <div class="mb-6 rounded-2xl border border-emerald/30 bg-emerald/10 px-5 py-4 text-sm font-medium text-emerald">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-rose-400/30 bg-rose-400/10 px-5 py-4 text-sm font-medium text-rose-300">{{ $errors->first() }}</div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>
