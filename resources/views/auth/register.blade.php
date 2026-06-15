<x-layout title="Create account — Wamo" description="Open a free Wamo account and start investing in minutes.">

    <section class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-32">
        <div class="absolute inset-0 -z-10 bg-grid"></div>

        <div class="reveal w-full max-w-md">
            <div class="gradient-border rounded-3xl glass p-8 shadow-2xl shadow-black/40">
                <div class="text-center">
                    <h1 class="text-3xl font-black tracking-tight">Create your account</h1>
                    <p class="mt-2 text-sm text-white/55">Start investing in minutes — it's free.</p>
                </div>

                <form action="{{ route('register') }}" method="post" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-medium text-white/50">Full name</label>
                        <input id="name" name="name" type="text" required autofocus value="{{ old('name') }}" placeholder="Jane Doe" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('name')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-medium text-white/50">Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="you@example.com" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('email')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-medium text-white/50">Password</label>
                        <input id="password" name="password" type="password" required placeholder="At least 8 characters" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('password')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-xs font-medium text-white/50">Confirm password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Re-enter your password" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                    </div>
                    <label class="flex items-start gap-2 text-sm text-white/60">
                        <input type="checkbox" name="terms" value="1" required class="mt-0.5 h-4 w-4 rounded border-white/20 bg-white/5 accent-brand">
                        <span>I agree to the <a href="{{ route('terms') }}" class="text-brand-bright hover:underline">Terms</a> and <a href="{{ route('privacy') }}" class="text-brand-bright hover:underline">Privacy Policy</a>.</span>
                    </label>
                    @error('terms')<p class="-mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                    <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-base font-bold text-white">Create free account</button>
                </form>

                <p class="mt-6 text-center text-sm text-white/55">
                    Already have an account? <a href="{{ route('login') }}" class="font-semibold text-brand-bright hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </section>

</x-layout>
