<x-layout title="Sign in — Fintriva" description="Sign in to your Fintriva account.">

    <section class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-32">
        <div class="absolute inset-0 -z-10 bg-grid"></div>

        <div class="reveal w-full max-w-md">
            <div class="gradient-border rounded-3xl glass p-8 shadow-2xl shadow-black/40">
                <div class="text-center">
                    <h1 class="text-3xl font-black tracking-tight">Welcome back</h1>
                    <p class="mt-2 text-sm text-white/55">Sign in to continue investing.</p>
                </div>

                <form action="{{ route('login') }}" method="post" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-medium text-white/50">Email</label>
                        <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}" placeholder="you@example.com" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('email')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <div class="mb-1.5 flex items-center justify-between">
                            <label for="password" class="block text-xs font-medium text-white/50">Password</label>
                            <a href="{{ route('password.request') }}" class="text-xs text-brand-bright hover:underline">Forgot?</a>
                        </div>
                        <input id="password" name="password" type="password" required placeholder="••••••••" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('password')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <label class="flex items-center gap-2 text-sm text-white/60">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/20 bg-white/5 accent-brand"> Remember me
                    </label>
                    <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-base font-bold text-white">Sign in</button>
                </form>

                <p class="mt-6 text-center text-sm text-white/55">
                    New to Fintriva? <a href="{{ route('register') }}" class="font-semibold text-brand-bright hover:underline">Create an account</a>
                </p>
            </div>
        </div>
    </section>

</x-layout>
