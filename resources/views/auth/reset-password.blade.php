<x-layout title="Set a new password — Fintriva" description="Choose a new password for your Fintriva account.">

    <section class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-32">
        <div class="absolute inset-0 -z-10 bg-grid"></div>

        <div class="reveal w-full max-w-md">
            <div class="gradient-border rounded-3xl glass p-8 shadow-2xl shadow-black/40">
                <div class="text-center">
                    <h1 class="text-3xl font-black tracking-tight">Set a new password</h1>
                    <p class="mt-2 text-sm text-white/55">Choose a strong password to secure your account.</p>
                </div>

                <form action="{{ route('password.store') }}" method="post" class="mt-8 space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-medium text-white/50">Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email', $email) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('email')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-medium text-white/50">New password</label>
                        <input id="password" name="password" type="password" required placeholder="At least 8 characters" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                        @error('password')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-xs font-medium text-white/50">Confirm password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Re-enter your password" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
                    </div>
                    <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-base font-bold text-white">Reset password</button>
                </form>
            </div>
        </div>
    </section>

</x-layout>
