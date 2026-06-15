<x-app-layout title="Withdraw — Wamo">

    <div class="reveal">
        <h1 class="text-2xl font-black tracking-tight sm:text-3xl">Withdraw funds</h1>
        <p class="mt-1 text-white/55">Transfer available funds from your wallet back to you.</p>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        {{-- Form --}}
        <div class="reveal rounded-3xl glass p-7 lg:col-span-2">
            <div class="rounded-2xl bg-white/5 p-5">
                <p class="text-sm text-white/55">Available balance</p>
                <p class="mt-1 text-3xl font-black tabular-nums">${{ number_format((float) $user->balance, 2) }}</p>
            </div>

            <form action="{{ route('user.withdraw.store') }}" method="post" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="method" class="mb-1.5 block text-sm font-medium text-white/60">Withdraw to</label>
                    <select id="method" name="method" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                        <option value="Bank transfer">Bank transfer</option>
                        <option value="Crypto wallet">Crypto wallet</option>
                        <option value="Card refund">Card refund</option>
                    </select>
                </div>

                <div>
                    <label for="amount" class="mb-1.5 block text-sm font-medium text-white/60">Amount (USD)</label>
                    <div class="flex items-center rounded-2xl bg-white/5 px-4 ring-1 ring-white/10 focus-within:ring-brand-bright">
                        <span class="text-lg text-white/40">$</span>
                        <input id="amount" type="number" name="amount" min="10" step="0.01" max="{{ (float) $user->balance }}" required value="{{ old('amount') }}" placeholder="100.00" class="w-full bg-transparent py-3.5 pl-2 text-lg font-bold text-white outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                    </div>
                    @error('amount')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
                    <button type="button" data-maxfill="{{ (float) $user->balance }}" class="mt-3 rounded-lg bg-white/5 px-3 py-1.5 text-xs font-semibold text-white/70 transition hover:bg-white/10">Withdraw max</button>
                </div>

                <button type="submit" class="btn-glow w-full rounded-2xl py-3.5 text-base font-bold text-white">Request withdrawal</button>
                <p class="text-center text-xs text-white/35">Demo environment — withdrawals settle instantly. A live system would queue this for processing.</p>
            </form>
        </div>

        {{-- Recent withdrawals --}}
        <div class="reveal rounded-3xl glass p-6">
            <h2 class="font-bold">Recent withdrawals</h2>
            <div class="mt-4 divide-y divide-white/5">
                @forelse ($recent as $txn)
                    <div class="flex items-center justify-between py-3">
                        <p class="text-xs text-white/50">{{ $txn->created_at->format('M j, Y') }}</p>
                        <span class="text-sm font-semibold tabular-nums text-rose-400">−${{ number_format((float) $txn->amount, 2) }}</span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-white/45">No withdrawals yet.</p>
                @endforelse
            </div>
            <a href="{{ route('user.wallet') }}" class="mt-4 block text-center text-sm text-brand-bright hover:underline">Full history</a>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-maxfill]').forEach((b) =>
            b.addEventListener('click', () => { document.getElementById('amount').value = b.dataset.maxfill; })
        );
    </script>

</x-app-layout>
