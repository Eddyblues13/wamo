<x-app-layout :title="$config['title'].' — Wamo'">

    @php $isCrypto = $market === 'crypto'; @endphp

    <div class="reveal flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-bright">{{ $config['eyebrow'] }}</p>
            <h1 class="mt-1 text-2xl font-black tracking-tight sm:text-3xl">{{ $config['heading'] }}</h1>
        </div>
        <span class="rounded-full glass px-4 py-2 text-sm text-white/70">Balance <span class="ml-1 font-bold text-white">${{ number_format((float) $user->balance, 2) }}</span></span>
    </div>

    {{-- Live ticker tape (real-time prices) --}}
    <div class="reveal mt-5 overflow-hidden rounded-2xl glass">
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
            {
            "symbols": [@foreach ($config['tvSymbols'] as $s){"proName":"{{ $s[0] }}","title":"{{ $s[1] }}"}@if (! $loop->last),@endif @endforeach],
            "showSymbolLogo": true,
            "isTransparent": true,
            "displayMode": "compact",
            "colorTheme": "dark",
            "locale": "en"
            }
            </script>
        </div>
    </div>

    {{-- Live chart --}}
    <div class="reveal mt-6 overflow-hidden rounded-3xl glass p-2">
        <div class="h-[460px] w-full overflow-hidden rounded-2xl">
            <div class="tradingview-widget-container h-full w-full">
                <div class="tradingview-widget-container__widget h-full w-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                "autosize": true,
                "symbol": "{{ $config['tvSymbol'] }}",
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

    {{-- Open positions --}}
    @if ($positions->isNotEmpty())
        <h2 class="reveal mt-10 text-xl font-bold">Your {{ $config['title'] }} positions</h2>
        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($positions as $position)
                @php $pl = (float) $position->profit; @endphp
                <div class="reveal flex flex-col rounded-3xl glass p-5" data-delay="{{ ($loop->index % 3) * 60 }}">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="font-bold leading-tight">{{ $position->symbol }}</p>
                            <p class="truncate text-xs text-white/50">{{ $position->name ?? 'Open position' }}</p>
                        </div>
                        <span class="rounded-full bg-emerald/15 px-2.5 py-1 text-xs font-semibold text-emerald">Open</span>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <p class="text-xs text-white/45">Invested</p>
                            <p class="text-lg font-bold tabular-nums">${{ number_format((float) $position->amount, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-white/45">Profit / loss</p>
                            <p class="text-lg font-bold tabular-nums {{ $pl >= 0 ? 'text-emerald' : 'text-rose-400' }}">{{ $pl >= 0 ? '+' : '-' }}${{ number_format(abs($pl), 2) }}</p>
                        </div>
                    </div>
                    <div class="mt-3 border-t border-white/10 pt-3 text-sm text-white/60">
                        Current value <span class="float-right font-bold text-white tabular-nums">${{ number_format($position->currentValue(), 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Asset list with trade forms --}}
    <h2 class="reveal mt-10 text-xl font-bold">Markets</h2>
    <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($config['assets'] as [$symbol, $name, $price, $change, $up, $grad])
            @php $base = \Illuminate\Support\Str::of($symbol)->before('/')->upper()->value(); @endphp
            <div class="reveal flex flex-col rounded-3xl glass p-5" data-delay="{{ ($loop->index % 3) * 60 }}">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br {{ $grad }} text-sm font-black text-white">{{ \Illuminate\Support\Str::substr($base, 0, 4) }}</span>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight">{{ $symbol }}</p>
                            <p class="truncate text-xs text-white/50">{{ $name }}</p>
                        </div>
                    </div>
                    @if ($isCrypto)
                        <div class="text-right">
                            <p class="font-bold tabular-nums" data-live="{{ $base }}USDT" data-live-prefix="$">${{ $price }}</p>
                            <p class="text-xs font-semibold {{ $up ? 'text-emerald' : 'text-rose-400' }}" data-live-change="{{ $base }}USDT">{{ $change }}</p>
                        </div>
                    @endif
                </div>

                <form action="{{ route('user.trade') }}" method="post" class="mt-5">
                    @csrf
                    <input type="hidden" name="market" value="{{ $market }}">
                    <input type="hidden" name="symbol" value="{{ $symbol }}">
                    <div class="flex items-center rounded-2xl bg-white/5 px-3 ring-1 ring-white/10 focus-within:ring-brand-bright">
                        <span class="text-white/40">$</span>
                        <input type="number" name="amount" min="1" step="0.01" placeholder="Amount in USD" class="w-full bg-transparent py-2.5 pl-1 text-sm font-semibold text-white outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                    </div>
                    <button type="submit" class="btn-glow mt-3 w-full rounded-2xl py-2.5 text-sm font-bold text-white">Buy {{ $base }}</button>
                </form>
            </div>
        @endforeach
    </div>

    <p class="reveal mt-6 text-xs text-white/35">
        Live prices are sourced from {{ $isCrypto ? 'Binance' : 'TradingView' }} in real time. Executed trades settle from your wallet balance.
    </p>

</x-app-layout>
