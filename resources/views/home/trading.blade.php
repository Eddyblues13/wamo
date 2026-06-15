{{-- ============ LIVE TRADING ============ --}}
<section id="trading" class="py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="reveal mx-auto max-w-2xl text-center">
            <p class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest text-brand-bright">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-rose-500 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-rose-500"></span>
                </span>
                Live market data
            </p>
            <h2 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">A professional trading environment</h2>
            <p class="mt-4 text-lg text-white/60">Real-time charts, deep liquidity and instant execution — trade cryptocurrencies, equities and forex from one interface.</p>
        </div>

        <div class="reveal mt-14 grid gap-6 lg:grid-cols-3">
            {{-- Live chart (TradingView) --}}
            <div class="overflow-hidden rounded-3xl glass p-2 lg:col-span-2">
                <div class="h-[480px] w-full overflow-hidden rounded-2xl">
                    <div class="tradingview-widget-container h-full w-full">
                        <div class="tradingview-widget-container__widget h-full w-full"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                        {
                        "autosize": true,
                        "symbol": "BINANCE:BTCUSDT",
                        "interval": "60",
                        "timezone": "Etc/UTC",
                        "theme": "dark",
                        "style": "1",
                        "locale": "en",
                        "hide_top_toolbar": false,
                        "hide_side_toolbar": true,
                        "allow_symbol_change": true,
                        "calendar": false,
                        "support_host": "https://www.tradingview.com"
                        }
                        </script>
                    </div>
                </div>
            </div>

            {{-- Trade panel --}}
            <div class="flex flex-col rounded-3xl glass p-6" data-trade>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-amber-400 to-orange-500 text-sm font-black text-amber-950">₿</span>
                        <div>
                            <p class="text-sm font-bold leading-tight">BTC / USDT</p>
                            <p class="text-xs text-white/50">Bitcoin</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold tabular-nums" data-trade-price>67,420.00</p>
                        <p class="text-xs font-semibold text-emerald tabular-nums" data-trade-change>+3.80%</p>
                    </div>
                </div>

                {{-- Buy / Sell tabs --}}
                <div class="mt-6 grid grid-cols-2 gap-2 rounded-2xl bg-white/5 p-1">
                    <button type="button" data-trade-side="buy" class="rounded-xl bg-emerald py-2.5 text-sm font-bold text-emerald-950 transition">Buy</button>
                    <button type="button" data-trade-side="sell" class="rounded-xl py-2.5 text-sm font-bold text-white/60 transition">Sell</button>
                </div>

                {{-- Amount --}}
                <label class="mt-5 block text-xs font-medium text-white/50">Amount (USD)</label>
                <div class="mt-1.5 flex items-center rounded-2xl bg-white/5 px-4 ring-1 ring-white/10 focus-within:ring-brand-bright">
                    <span class="text-white/40">$</span>
                    <input type="number" value="500" min="1" data-trade-amount class="w-full bg-transparent py-3 pl-1 text-base font-semibold text-white outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                </div>
                <div class="mt-2 grid grid-cols-4 gap-2">
                    @foreach ([100, 500, 1000, 5000] as $amt)
                        <button type="button" data-trade-quick="{{ $amt }}" class="rounded-lg bg-white/5 py-1.5 text-xs font-semibold text-white/70 transition hover:bg-white/10">${{ $amt }}</button>
                    @endforeach
                </div>

                {{-- Leverage --}}
                <label class="mt-5 block text-xs font-medium text-white/50">Leverage</label>
                <div class="mt-1.5 grid grid-cols-4 gap-2">
                    @foreach (['1x', '5x', '10x', '20x'] as $lev)
                        <button type="button" data-trade-lev="{{ $lev }}" class="rounded-lg py-2 text-xs font-bold ring-1 ring-white/10 transition {{ $lev === '1x' ? 'bg-brand/20 text-brand-bright ring-brand/40' : 'bg-white/5 text-white/60 hover:bg-white/10' }}">{{ $lev }}</button>
                    @endforeach
                </div>

                {{-- Summary --}}
                <div class="mt-5 space-y-2 rounded-2xl bg-white/5 p-4 text-sm">
                    <div class="flex justify-between text-white/50"><span>Est. quantity</span><span class="tabular-nums text-white/80" data-trade-qty>0.00742 BTC</span></div>
                    <div class="flex justify-between text-white/50"><span>Fee (0.1%)</span><span class="tabular-nums text-white/80" data-trade-fee>$0.50</span></div>
                </div>

                <button type="button" data-trade-submit class="btn-glow mt-5 w-full rounded-2xl py-3.5 text-base font-bold text-white">Buy BTC</button>
                <p class="mt-3 text-center text-xs text-white/40">Demo interface · trading involves risk</p>
            </div>
        </div>
    </div>
</section>
