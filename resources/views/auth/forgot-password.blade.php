<x-layout title="Reset password — Fintriva" description="Reset your Fintriva account password.">

    <section class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-32">
        <div class="absolute inset-0 -z-10 bg-grid"></div>

        <div class="reveal w-full max-w-md">
            <div class="gradient-border rounded-3xl glass p-8 shadow-2xl shadow-black/40">
                <div class="text-center">
                    <h1 class="text-3xl font-black tracking-tight">Forgot password?</h1>
                    <p class="mt-2 text-sm text-white/55">Enter your email and we'll send you a secure reset link.</p>
                </div>

                <form action="{{ route('password.email') }}" method="post" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-medium text-white/50">Email</label>
                        <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}" placeholder="you@example.com" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('email')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-base font-bold text-white">Send reset link</button>
                </form>

                <p class="mt-6 text-center text-sm text-white/55">
                    Remembered it? <a href="{{ route('login') }}" class="font-semibold text-brand-bright hover:underline">Back to sign in</a>
                </p>
            </div>
        </div>
    </section>

</x-layout>
