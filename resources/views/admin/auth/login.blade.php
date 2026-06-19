<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Console — Wamo</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ink-950 text-white font-sans antialiased">

    <div class="grid min-h-screen lg:grid-cols-2">
        {{-- Brand panel (desktop) --}}
        <div class="relative hidden overflow-hidden border-r border-white/10 lg:flex lg:flex-col lg:justify-between lg:p-12">
            <div class="absolute inset-0 -z-10 bg-grid"></div>
            <div class="pointer-events-none absolute -top-32 -left-24 h-[32rem] w-[32rem] rounded-full bg-brand/25 blur-[120px] animate-pulse-glow"></div>
            <div class="pointer-events-none absolute bottom-0 right-0 h-[26rem] w-[26rem] rounded-full bg-violet/20 blur-[120px]"></div>

            <a href="{{ route('home') }}"><x-logo /></a>

            <div>
                <span class="inline-flex items-center gap-2 rounded-full glass px-3 py-1 text-xs font-semibold text-brand-bright">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"/></svg>
                    Secured administration
                </span>
                <h1 class="mt-5 max-w-md text-4xl font-black leading-tight tracking-tight">The Wamo control center</h1>
                <p class="mt-4 max-w-sm text-white/55">Manage users, investments, deposits and platform operations from one secure console.</p>

                <div class="mt-8 flex flex-wrap gap-x-8 gap-y-3 text-sm text-white/60">
                    <span class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-emerald"></span> Encrypted sessions</span>
                    <span class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-emerald"></span> Role-based access</span>
                    <span class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-emerald"></span> Audit-ready</span>
                </div>
            </div>

            <p class="text-xs text-white/30">© {{ date('Y') }} Wamo International · Authorized personnel only</p>
        </div>

        {{-- Form panel --}}
        <div class="relative flex items-center justify-center px-6 py-12">
            <div class="absolute inset-0 -z-10 bg-grid lg:hidden"></div>
            <div class="w-full max-w-sm">
                <div class="mb-8 flex justify-center lg:hidden"><x-logo /></div>

                <div class="mb-7">
                    <span class="inline-flex items-center gap-2 rounded-full bg-brand/15 px-3 py-1 text-xs font-bold text-brand-bright">ADMIN CONSOLE</span>
                    <h2 class="mt-4 text-3xl font-black tracking-tight">Sign in</h2>
                    <p class="mt-2 text-sm text-white/55">Enter your administrator credentials to continue.</p>
                </div>

                <form action="{{ route('admin.login') }}" method="post" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-medium text-white/50">Email</label>
                        <div class="flex items-center rounded-2xl bg-white/5 px-4 ring-1 ring-white/10 focus-within:ring-brand-bright">
                            <svg class="h-4 w-4 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z"/></svg>
                            <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}" placeholder="admin@wamo.com" class="w-full bg-transparent py-3 pl-2 text-sm text-white outline-none">
                        </div>
                        @error('email')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-medium text-white/50">Password</label>
                        <div class="flex items-center rounded-2xl bg-white/5 px-4 ring-1 ring-white/10 focus-within:ring-brand-bright">
                            <svg class="h-4 w-4 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="5" y="11" width="14" height="9" rx="2"/><path stroke-linecap="round" d="M8 11V8a4 4 0 018 0v3"/></svg>
                            <input id="password" name="password" type="password" required placeholder="••••••••" class="w-full bg-transparent py-3 pl-2 text-sm text-white outline-none">
                        </div>
                        @error('password')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <label class="flex items-center gap-2 text-sm text-white/60">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/20 bg-white/5 accent-brand"> Keep me signed in
                    </label>
                    <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-base font-bold text-white">Sign in to console</button>
                </form>

                <p class="mt-8 text-center text-xs text-white/30">← <a href="{{ route('home') }}" class="hover:text-white/60">Back to website</a></p>
            </div>
        </div>
    </div>

</body>
</html>
