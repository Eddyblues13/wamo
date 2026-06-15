<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin sign in — Wamo</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ink-950 text-white font-sans antialiased">

    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 left-1/2 h-[34rem] w-[34rem] -translate-x-1/2 rounded-full bg-brand/20 blur-[120px]"></div>
    </div>

    <section class="relative flex min-h-screen items-center justify-center overflow-hidden px-6">
        <div class="absolute inset-0 -z-10 bg-grid"></div>

        <div class="w-full max-w-md">
            <div class="mb-6 flex justify-center"><x-logo /></div>

            <div class="gradient-border rounded-3xl glass p-8 shadow-2xl shadow-black/40">
                <div class="text-center">
                    <span class="inline-flex items-center gap-2 rounded-full bg-brand/20 px-3 py-1 text-xs font-bold text-brand-bright">ADMIN PORTAL</span>
                    <h1 class="mt-4 text-3xl font-black tracking-tight">Sign in</h1>
                    <p class="mt-2 text-sm text-white/55">Authorized personnel only.</p>
                </div>

                <form action="{{ route('admin.login') }}" method="post" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-medium text-white/50">Email</label>
                        <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}" placeholder="admin@wamo.com" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('email')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-medium text-white/50">Password</label>
                        <input id="password" name="password" type="password" required placeholder="••••••••" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('password')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <label class="flex items-center gap-2 text-sm text-white/60">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/20 bg-white/5 accent-brand"> Remember me
                    </label>
                    <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-base font-bold text-white">Sign in to dashboard</button>
                </form>
            </div>

            <p class="mt-4 text-center text-xs text-white/30">← <a href="{{ route('home') }}" class="hover:text-white/60">Back to website</a></p>
        </div>
    </section>

</body>
</html>
