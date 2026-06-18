{{-- ============ LIVE TICKER (real-time, TradingView) ============ --}}
<section class="border-y border-white/5 bg-white/[0.02]">
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
        {
        "symbols": [
            {"proName": "BINANCE:BTCUSDT", "title": "BTC"},
            {"proName": "BINANCE:ETHUSDT", "title": "ETH"},
            {"proName": "BINANCE:SOLUSDT", "title": "SOL"},
            {"proName": "NASDAQ:TSLA", "title": "Tesla"},
            {"proName": "NASDAQ:AMZN", "title": "Amazon"},
            {"proName": "NASDAQ:NVDA", "title": "Nvidia"},
            {"proName": "NASDAQ:AAPL", "title": "Apple"},
            {"proName": "FX:EURUSD", "title": "EUR/USD"},
            {"proName": "FX:GBPUSD", "title": "GBP/USD"},
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
</section>
