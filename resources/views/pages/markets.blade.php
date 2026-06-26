<x-layout title="Markets — Fintriva" description="Track live prices across crypto, stocks, forex and commodities on Fintriva.">

    <x-page-hero
        eyebrow="Markets"
        title='Every market, <span class="text-gradient">one screen</span>'
        subtitle="Live prices and pro charting across crypto, global stocks, forex and commodities — updated in real time.">
        <x-slot:actions>
            <a href="{{ route('register') }}" data-magnetic class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">Start trading</a>
            <a href="{{ route('trading') }}" class="rounded-full glass px-7 py-3.5 text-base font-semibold text-white/90 transition hover:bg-white/10">Open live chart</a>
        </x-slot:actions>
    </x-page-hero>

    @include('home.ticker')

    {{-- Market table --}}
    <section class="py-20">
        <div class="mx-auto max-w-5xl px-6 lg:px-8">
            <x-section-heading class="!mx-0 !text-left" eyebrow="Top movers" title="Live market overview" />

            <div class="reveal mt-10 overflow-hidden rounded-3xl glass">
                <table class="table-cards w-full text-left text-sm">
                    <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                        <tr>
                            <th class="px-6 py-4 font-medium">Asset</th>
                            <th class="px-6 py-4 text-right font-medium">Price</th>
                            <th class="px-6 py-4 text-right font-medium">24h</th>
                            <th class="hidden px-6 py-4 text-right font-medium sm:table-cell">Market cap</th>
                            <th class="px-6 py-4 text-right font-medium"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @php
                            $rows = [
                                ['₿', 'Bitcoin', 'BTC', '$67,420.00', '+3.8%', true, '$1.33T'],
                                ['Ξ', 'Ethereum', 'ETH', '$3,540.10', '+2.4%', true, '$425B'],
                                ['T', 'Tesla', 'TSLA', '$248.50', '+1.9%', true, '$791B'],
                                ['a', 'Amazon', 'AMZN', '$186.40', '+2.6%', true, '$1.94T'],
                                ['N', 'Nvidia', 'NVDA', '$124.80', '+3.2%', true, '$3.07T'],
                                ['€', 'EUR / USD', 'FX', '1.0875', '-0.2%', false, '—'],
                                ['◎', 'Solana', 'SOL', '$172.30', '+6.1%', true, '$80B'],
                                ['Au', 'Gold', 'XAU', '$2,358.00', '+0.5%', true, '—'],
                            ];
                        @endphp
                        @foreach ($rows as [$badge, $name, $sym, $price, $chg, $up, $cap])
                            <tr class="transition hover:bg-white/5">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-brand to-violet text-sm font-bold">{{ $badge }}</span>
                                        <div>
                                            <p class="font-semibold">{{ $name }}</p>
                                            <p class="text-xs text-white/40">{{ $sym }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Price" class="px-6 py-4 text-right font-semibold tabular-nums">{{ $price }}</td>
                                <td data-label="24h" class="px-6 py-4 text-right font-semibold tabular-nums {{ $up ? 'text-emerald' : 'text-rose-400' }}">{{ $chg }}</td>
                                <td data-label="Market cap" class="px-6 py-4 text-right tabular-nums text-white/60 md:table-cell">{{ $cap }}</td>
                                <td data-label="" class="px-6 py-4 text-right">
                                    <a href="{{ route('register') }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-ink-950 transition hover:bg-brand-bright hover:text-white">Trade</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @include('home.trading')

    <x-cta />

</x-layout>
