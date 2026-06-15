{{-- ============ LIVE TICKER ============ --}}
<section class="border-y border-white/5 bg-white/[0.02] py-5">
    <div class="relative overflow-hidden">
        <div class="flex w-max animate-marquee gap-10 whitespace-nowrap">
            @php
                $ticks = [
                    ['BTC', '$67,420', '+3.8%', true], ['ETH', '$3,540', '+2.4%', true],
                    ['TSLA', '$248.50', '+1.9%', true], ['AAPL', '$226.10', '+0.7%', true],
                    ['EUR/USD', '1.0875', '-0.2%', false], ['SOL', '$172.30', '+6.1%', true],
                    ['GBP/USD', '1.2710', '+0.4%', true], ['NVDA', '$124.80', '+2.2%', true],
                    ['GOLD', '$2,358', '+0.5%', true], ['XRP', '$0.612', '-1.1%', false],
                ];
            @endphp
            @foreach (array_merge($ticks, $ticks) as [$sym, $price, $chg, $up])
                <div class="flex items-center gap-3 text-sm">
                    <span class="font-semibold text-white/90">{{ $sym }}</span>
                    <span class="text-white/60">{{ $price }}</span>
                    <span class="{{ $up ? 'text-emerald' : 'text-rose-400' }} font-medium">{{ $chg }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>
