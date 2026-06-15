<x-app-layout title="Invest — Wamo">

    <div class="reveal">
        <h1 class="text-2xl font-black tracking-tight sm:text-3xl">Investment plans</h1>
        <p class="mt-1 text-white/55">Choose a plan and start earning. Returns are credited at maturity or on the stated schedule.</p>
    </div>

    {{-- Summary --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        @foreach ([['Wallet balance', '$'.number_format((float) $user->balance, 2)], ['Total invested', '$'.number_format((float) $totalInvested, 2)], ['Expected returns', '$'.number_format((float) $expectedReturns, 2)]] as [$label, $value])
            <div class="reveal rounded-3xl glass p-5" data-delay="{{ $loop->index * 60 }}">
                <p class="text-sm text-white/55">{{ $label }}</p>
                <p class="mt-1 text-xl font-black tabular-nums">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    {{-- Plans --}}
    <div class="mt-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($plans as $plan)
            <div class="reveal flex h-full flex-col rounded-3xl glass p-6 {{ $plan->is_featured ? 'gradient-border ring-1 ring-brand/30' : '' }}" data-delay="{{ ($loop->index % 4) * 60 }}">
                @if ($plan->is_featured)
                    <span class="mb-4 inline-flex w-max items-center rounded-full bg-brand/20 px-3 py-1 text-xs font-bold text-brand-bright">Most popular</span>
                @endif
                <div class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br {{ $plan->gradient ?? 'from-brand to-violet' }} text-2xl ring-1 ring-white/10">{{ $plan->icon }}</div>
                <h3 class="mt-4 text-lg font-bold">{{ $plan->name }}</h3>
                <p class="mt-1 text-xs text-white/50">{{ $plan->tagline }}</p>

                <div class="mt-5 flex items-baseline gap-1">
                    <span class="text-3xl font-black text-gradient">{{ rtrim(rtrim(number_format((float) $plan->roi_percent, 2), '0'), '.') }}%</span>
                    <span class="text-sm text-white/50">ROI</span>
                </div>

                <dl class="mt-4 space-y-1.5 text-sm text-white/60">
                    <div class="flex justify-between"><dt>Range</dt><dd class="text-white/80">${{ number_format((float) $plan->min_amount) }}–{{ number_format((float) $plan->max_amount) }}</dd></div>
                    <div class="flex justify-between"><dt>Term</dt><dd class="text-white/80">{{ $plan->duration_days }} days</dd></div>
                    <div class="flex justify-between"><dt>Payout</dt><dd class="text-white/80">{{ $plan->payout_interval }}</dd></div>
                </dl>

                <form action="{{ route('user.invest.store') }}" method="post" class="mt-auto pt-5">
                    @csrf
                    <input type="hidden" name="investment_plan_id" value="{{ $plan->id }}">
                    <div class="flex items-center rounded-2xl bg-white/5 px-3 ring-1 ring-white/10 focus-within:ring-brand-bright">
                        <span class="text-white/40">$</span>
                        <input type="number" name="amount" min="{{ (int) $plan->min_amount }}" max="{{ (int) $plan->max_amount }}" step="0.01" placeholder="{{ number_format((float) $plan->min_amount) }}" class="w-full bg-transparent py-2.5 pl-1 text-sm font-semibold text-white outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                    </div>
                    <button type="submit" class="btn-glow mt-3 w-full rounded-2xl py-2.5 text-sm font-bold text-white">Invest now</button>
                </form>
            </div>
        @endforeach
    </div>

    {{-- Active investments --}}
    <div class="mt-12">
        <h2 class="reveal text-xl font-bold">Your investments</h2>
        @if ($investments->isEmpty())
            <div class="reveal mt-6 rounded-3xl glass p-10 text-center">
                <p class="text-white/55">You haven't made any investments yet. Choose a plan above to get started.</p>
            </div>
        @else
            <div class="reveal mt-6 overflow-hidden rounded-3xl glass">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                            <tr>
                                <th class="px-6 py-4 font-medium">Plan</th>
                                <th class="px-6 py-4 text-right font-medium">Amount</th>
                                <th class="px-6 py-4 text-right font-medium">Expected return</th>
                                <th class="hidden px-6 py-4 text-right font-medium sm:table-cell">Matures</th>
                                <th class="px-6 py-4 text-right font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ($investments as $inv)
                                <tr class="transition hover:bg-white/5">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br {{ $inv->plan->gradient ?? 'from-brand to-violet' }} text-base ring-1 ring-white/10">{{ $inv->plan->icon }}</span>
                                            <span class="font-semibold">{{ $inv->plan->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold tabular-nums">${{ number_format((float) $inv->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-right font-semibold tabular-nums text-emerald">+${{ number_format((float) $inv->expected_return, 2) }}</td>
                                    <td class="hidden px-6 py-4 text-right tabular-nums text-white/60 sm:table-cell">{{ $inv->matures_at?->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="rounded-full bg-emerald/15 px-3 py-1 text-xs font-semibold capitalize text-emerald">{{ $inv->status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

</x-app-layout>
