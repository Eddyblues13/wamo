<x-layout title="Verify your email — Wamo" description="Enter the 4-digit code we sent to your email.">

    <section class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-32">
        <div class="absolute inset-0 -z-10 bg-grid"></div>

        <div class="reveal w-full max-w-md">
            <div class="gradient-border rounded-3xl glass p-8 shadow-2xl shadow-black/40">
                <div class="text-center">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-brand to-violet text-2xl shadow-lg">✉️</div>
                    <h1 class="mt-5 text-3xl font-black tracking-tight">Verify your email</h1>
                    <p class="mt-2 text-sm text-white/55">We sent a 4-digit code to<br><span class="font-semibold text-white/80">{{ auth()->user()->email }}</span></p>
                </div>

                @if (session('status'))
                    <div class="mt-6 rounded-2xl border border-emerald/30 bg-emerald/10 px-4 py-3 text-center text-sm text-emerald">{{ session('status') }}</div>
                @endif

                @if (session('dev_code'))
                    <div class="mt-6 rounded-2xl border border-amber-400/30 bg-amber-400/10 px-4 py-3 text-center text-sm text-amber-300">
                        <span class="font-semibold">Local dev:</span> your code is <span class="font-mono text-lg tracking-widest">{{ session('dev_code') }}</span>
                    </div>
                @endif

                <form action="{{ route('verification.verify') }}" method="post" class="mt-8" data-otp-form>
                    @csrf
                    <input type="hidden" name="code" data-otp-value>
                    <div class="flex justify-center gap-3" data-otp>
                        @for ($i = 0; $i < 4; $i++)
                            <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" @if($i === 0) autofocus @endif
                                class="h-16 w-14 rounded-2xl bg-white/5 text-center text-2xl font-bold text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright" data-otp-input>
                        @endfor
                    </div>
                    @error('code')<p class="mt-3 text-center text-sm text-rose-400">{{ $message }}</p>@enderror

                    <button type="submit" class="btn-glow mt-7 w-full rounded-2xl py-3.5 text-base font-bold text-white">Verify &amp; continue</button>
                </form>

                <form action="{{ route('verification.resend') }}" method="post" class="mt-5 text-center">
                    @csrf
                    <span class="text-sm text-white/50">Didn't get the code?</span>
                    <button type="submit" class="text-sm font-semibold text-brand-bright hover:underline">Resend</button>
                </form>
            </div>

            <form action="{{ route('logout') }}" method="post" class="mt-4 text-center">
                @csrf
                <button type="submit" class="text-xs text-white/40 transition hover:text-white/70">Sign out</button>
            </form>
        </div>
    </section>

    <script>
        (function () {
            const wrap = document.querySelector('[data-otp]');
            if (!wrap) return;
            const inputs = [...wrap.querySelectorAll('[data-otp-input]')];
            const hidden = document.querySelector('[data-otp-value]');
            const form = document.querySelector('[data-otp-form]');

            const sync = () => { hidden.value = inputs.map((i) => i.value).join(''); };

            inputs.forEach((input, idx) => {
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/\D/g, '').slice(0, 1);
                    if (input.value && idx < inputs.length - 1) inputs[idx + 1].focus();
                    sync();
                    if (hidden.value.length === 4) form.requestSubmit();
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && idx > 0) inputs[idx - 1].focus();
                });
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const digits = (e.clipboardData.getData('text') || '').replace(/\D/g, '').slice(0, 4).split('');
                    digits.forEach((d, i) => { if (inputs[i]) inputs[i].value = d; });
                    sync();
                    (inputs[digits.length] || inputs[3]).focus();
                    if (hidden.value.length === 4) form.requestSubmit();
                });
            });
        })();
    </script>

</x-layout>
