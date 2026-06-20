<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TradeController extends Controller
{
    /**
     * Market configuration for each tradable asset class.
     *
     * @return array<string, array<string, mixed>>
     */
    protected function markets(): array
    {
        return [
            'stocks' => [
                'title' => 'Stocks',
                'eyebrow' => 'Equities',
                'heading' => 'Buy & trade global stocks',
                'tvSymbol' => 'NASDAQ:TSLA',
                'tvSymbols' => [
                    ['NASDAQ:TSLA', 'Tesla'], ['NASDAQ:AMZN', 'Amazon'], ['NASDAQ:AAPL', 'Apple'],
                    ['NASDAQ:NVDA', 'Nvidia'], ['NASDAQ:MSFT', 'Microsoft'], ['NASDAQ:META', 'Meta'],
                ],
                'assets' => [
                    ['TSLA', 'Tesla, Inc.', '248.50', '+1.9%', true, 'from-red-500 to-rose-600'],
                    ['AMZN', 'Amazon.com', '186.40', '+2.6%', true, 'from-orange-400 to-amber-500'],
                    ['AAPL', 'Apple Inc.', '226.10', '+0.7%', true, 'from-zinc-400 to-zinc-600'],
                    ['NVDA', 'NVIDIA Corp.', '124.80', '+3.2%', true, 'from-green-500 to-emerald-600'],
                    ['MSFT', 'Microsoft', '441.20', '+1.1%', true, 'from-sky-500 to-blue-600'],
                    ['META', 'Meta Platforms', '512.30', '+2.0%', true, 'from-blue-500 to-sky-500'],
                ],
            ],
            'forex' => [
                'title' => 'Forex',
                'eyebrow' => 'Foreign exchange',
                'heading' => 'Trade currency pairs 24/5',
                'tvSymbol' => 'FX:EURUSD',
                'tvSymbols' => [
                    ['FX:EURUSD', 'EUR/USD'], ['FX:GBPUSD', 'GBP/USD'], ['FX:USDJPY', 'USD/JPY'],
                    ['FX:AUDUSD', 'AUD/USD'], ['FX:USDCAD', 'USD/CAD'], ['FX:USDCHF', 'USD/CHF'],
                ],
                'assets' => [
                    ['EUR/USD', 'Euro / US Dollar', '1.0875', '-0.2%', false, 'from-sky-400 to-indigo-500'],
                    ['GBP/USD', 'Pound / US Dollar', '1.2710', '+0.4%', true, 'from-indigo-400 to-violet-500'],
                    ['USD/JPY', 'US Dollar / Yen', '157.32', '+0.3%', true, 'from-rose-400 to-red-500'],
                    ['AUD/USD', 'Aussie / US Dollar', '0.6642', '+0.5%', true, 'from-emerald-400 to-teal-500'],
                    ['USD/CAD', 'US Dollar / Loonie', '1.3705', '-0.2%', false, 'from-amber-400 to-orange-500'],
                    ['USD/CHF', 'US Dollar / Franc', '0.8945', '-0.1%', false, 'from-slate-400 to-slate-600'],
                ],
            ],
            'crypto' => [
                'title' => 'Crypto',
                'eyebrow' => 'Digital assets',
                'heading' => 'Buy & swap cryptocurrencies',
                'tvSymbol' => 'BINANCE:BTCUSDT',
                'tvSymbols' => [
                    ['BINANCE:BTCUSDT', 'BTC'], ['BINANCE:ETHUSDT', 'ETH'], ['BINANCE:SOLUSDT', 'SOL'],
                    ['BINANCE:XRPUSDT', 'XRP'], ['BINANCE:ADAUSDT', 'ADA'], ['BINANCE:DOGEUSDT', 'DOGE'],
                ],
                'assets' => [
                    ['BTC', 'Bitcoin', '67,420.00', '+3.8%', true, 'from-amber-400 to-orange-500'],
                    ['ETH', 'Ethereum', '3,540.10', '+2.4%', true, 'from-indigo-400 to-blue-600'],
                    ['SOL', 'Solana', '172.30', '+6.1%', true, 'from-purple-400 to-fuchsia-600'],
                    ['XRP', 'XRP', '0.612', '-1.1%', false, 'from-slate-400 to-slate-600'],
                    ['ADA', 'Cardano', '0.452', '+1.7%', true, 'from-sky-400 to-blue-600'],
                    ['DOGE', 'Dogecoin', '0.138', '+4.5%', true, 'from-yellow-400 to-amber-600'],
                ],
            ],
        ];
    }

    public function stocks(Request $request): View
    {
        return $this->show($request, 'stocks');
    }

    public function forex(Request $request): View
    {
        return $this->show($request, 'forex');
    }

    public function crypto(Request $request): View
    {
        return $this->show($request, 'crypto');
    }

    protected function show(Request $request, string $market): View
    {
        return view('user.trade', [
            'user' => $request->user(),
            'market' => $market,
            'config' => $this->markets()[$market],
            'positions' => $request->user()->trades()->market($market)->open()->get(),
        ]);
    }

    /**
     * Resolve a human-readable asset name from the market configuration.
     */
    protected function assetName(string $market, string $symbol): ?string
    {
        foreach ($this->markets()[$market]['assets'] as $asset) {
            if (strtoupper($asset[0]) === strtoupper($symbol)) {
                return $asset[1];
            }
        }

        return null;
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'market' => ['required', 'in:stocks,forex,crypto'],
            'symbol' => ['required', 'string', 'max:20'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $amount = round((float) $validated['amount'], 2);
        $user = $request->user();

        if ($amount > (float) $user->balance) {
            throw ValidationException::withMessages([
                'amount' => 'Insufficient wallet balance. Please deposit funds first.',
            ]);
        }

        $symbol = strtoupper($validated['symbol']);

        DB::transaction(function () use ($user, $validated, $symbol, $amount): void {
            $user->debit($amount, 'trade', "Bought \${$amount} of {$symbol}");

            $user->trades()->create([
                'market' => $validated['market'],
                'symbol' => $symbol,
                'name' => $this->assetName($validated['market'], $symbol),
                'amount' => $amount,
                'profit' => 0,
                'status' => 'open',
            ]);
        });

        NotificationMail::deliver(
            $user,
            'Trade executed',
            'Your trade was executed',
            ['Your order has been filled successfully and settled from your wallet.'],
            [
                'Market' => ucfirst($validated['market']),
                'Asset' => $symbol,
                'Amount' => '$'.number_format($amount, 2),
                'Wallet balance' => '$'.number_format((float) $user->balance, 2),
            ],
        );

        return redirect()->route('user.'.$validated['market'])
            ->with('status', "Trade executed: \${$amount} of {$symbol}.");
    }
}
