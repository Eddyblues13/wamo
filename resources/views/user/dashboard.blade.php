<x-app-layout title="Dashboard — Fintriva">

    {{-- Live ticker tape --}}
    <div class="reveal mb-8 overflow-hidden rounded-2xl glass">
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
            {
            "symbols": [
                {"proName": "BINANCE:BTCUSDT", "title": "BTC"},
                {"proName": "BINANCE:ETHUSDT", "title": "ETH"},
                {"proName": "NASDAQ:TSLA", "title": "Tesla"},
                {"proName": "NASDAQ:AMZN", "title": "Amazon"},
                {"proName": "NASDAQ:NVDA", "title": "Nvidia"},
                {"proName": "FX:EURUSD", "title": "EUR/USD"},
                {"proName": "TVC:GOLD", "title": "Gold"}
            ],
            "showSymbolLogo": true,
            "isTransparent": true,
            "displayMode": "adaptive",
            "colorTheme": "dark",
            "locale": "en"
            }
            </script>
        </div>
    </div>

    {{-- Greeting + quick actions --}}
    <div class="reveal flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight sm:text-3xl">Welcome back, {{ explode(' ', $user->name)[0] }}</h1>
            <p class="mt-1 text-white/55">Here's your portfolio at a glance.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('user.deposit') }}" class="btn-glow rounded-2xl px-5 py-2.5 text-sm font-bold text-white">Deposit</a>
            <a href="{{ route('user.withdraw') }}" class="rounded-2xl glass px-5 py-2.5 text-sm font-semibold text-white/90 transition hover:bg-white/10">Withdraw</a>
            <a href="{{ route('user.invest') }}" class="rounded-2xl glass px-5 py-2.5 text-sm font-semibold text-white/90 transition hover:bg-white/10">Invest</a>
        </div>
    </div>

    {{-- Summary stats --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['Wallet balance', '$' . number_format((float) $user->balance, 2), 'from-brand to-violet'],
                ['Total invested', '$' . number_format((float) $totalInvested, 2), 'from-sky-500 to-indigo-600'],
                ['Expected returns', '$' . number_format((float) $expectedReturns, 2), 'from-emerald-500 to-teal-600'],
                ['Active plans', (string) $activeCount, 'from-amber-400 to-orange-500'],
            ];
        @endphp
        @foreach ($cards as [$label, $value, $grad])
            <div class="reveal rounded-3xl glass p-5 sm:p-6" data-delay="{{ $loop->index * 60 }}">
                <div class="h-1.5 w-10 rounded-full bg-gradient-to-r {{ $grad }}"></div>
                <p class="mt-4 text-sm text-white/55">{{ $label }}</p>
                <p class="mt-1 text-2xl font-black tabular-nums">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    {{-- Live chart + market overview --}}
    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="reveal overflow-hidden rounded-3xl glass p-2 lg:col-span-2">
            <div class="h-[420px] w-full overflow-hidden rounded-2xl">
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
                    "hide_side_toolbar": true,
                    "allow_symbol_change": true,
                    "support_host": "https://www.tradingview.com"
                    }
                    </script>
                </div>
            </div>
        </div>

        <div class="reveal overflow-hidden rounded-3xl glass p-2">
            <div class="h-[420px] w-full overflow-hidden rounded-2xl">
                <div class="tradingview-widget-container h-full w-full">
                    <div class="tradingview-widget-container__widget h-full w-full"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
                    {
                    "colorTheme": "dark",
                    "dateRange": "1D",
                    "showChart": false,
                    "locale": "en",
                    "isTransparent": true,
                    "width": "100%",
                    "height": "100%",
                    "tabs": [
                        {"title": "Crypto", "symbols": [{"s": "BINANCE:BTCUSDT"}, {"s": "BINANCE:ETHUSDT"}, {"s": "BINANCE:SOLUSDT"}, {"s": "BINANCE:XRPUSDT"}]},
                        {"title": "Stocks", "symbols": [{"s": "NASDAQ:TSLA"}, {"s": "NASDAQ:AMZN"}, {"s": "NASDAQ:AAPL"}, {"s": "NASDAQ:NVDA"}]},
                        {"title": "Forex", "symbols": [{"s": "FX:EURUSD"}, {"s": "FX:GBPUSD"}, {"s": "FX:USDJPY"}]}
                    ]
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>

    {{-- Trading desks quick links --}}
    <div class="mt-8 grid gap-4 sm:grid-cols-3">
        @foreach ([['Stocks', 'Buy Tesla, Amazon & more', '📈', 'user.stocks'], ['Forex', 'Trade 60+ currency pairs', '💱', 'user.forex'], ['Crypto', 'Bitcoin, Ethereum & 200+', '₿', 'user.crypto']] as [$t, $d, $icon, $route])
            <a href="{{ route($route) }}" class="reveal group flex items-center gap-4 rounded-3xl glass p-5 transition hover:bg-white/[0.07]" data-delay="{{ $loop->index * 70 }}">
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-brand to-violet text-2xl">{{ $icon }}</span>
                <div>
                    <p class="font-bold">{{ $t }}</p>
                    <p class="text-sm text-white/55">{{ $d }}</p>
                </div>
                <svg class="ml-auto h-5 w-5 text-white/30 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        @endforeach
    </div>

    {{-- Recent activity + invest teaser --}}
    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="reveal rounded-3xl glass p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-bold">Recent activity</h2>
                <a href="{{ route('user.wallet') }}" class="text-sm text-brand-bright hover:underline">View all</a>
            </div>
            <div class="mt-4 divide-y divide-white/5">
                @forelse ($recentTransactions as $txn)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="text-sm font-medium capitalize">{{ $txn->type }}</p>
                            <p class="text-xs text-white/45">{{ $txn->created_at->format('M j, Y') }}</p>
                        </div>
                        <span class="text-sm font-semibold tabular-nums {{ $txn->isCredit() ? 'text-emerald' : 'text-rose-400' }}">{{ $txn->isCredit() ? '+' : '−' }}${{ number_format((float) $txn->amount, 2) }}</span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-white/45">No activity yet. Make your first deposit to begin.</p>
                @endforelse
            </div>
        </div>

        <div class="reveal rounded-3xl glass p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-bold">Grow with a plan</h2>
                <a href="{{ route('user.invest') }}" class="text-sm text-brand-bright hover:underline">View plans</a>
            </div>
            <div class="mt-4 space-y-3">
                @foreach ($plans->take(3) as $plan)
                    <a href="{{ route('user.invest') }}" class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3 transition hover:bg-white/10">
                        <div class="flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br {{ $plan->gradient ?? 'from-brand to-violet' }} text-base">{{ $plan->icon }}</span>
                            <div>
                                <p class="text-sm font-semibold">{{ $plan->name }}</p>
                                <p class="text-xs text-white/45">{{ $plan->duration_days }} days</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-emerald">{{ rtrim(rtrim(number_format((float) $plan->roi_percent, 2), '0'), '.') }}%</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>
