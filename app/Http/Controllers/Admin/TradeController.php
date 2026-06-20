<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TradeController extends Controller
{
    private const MARKETS = [
        'stocks' => 'Stocks',
        'forex' => 'Forex',
        'crypto' => 'Crypto',
    ];

    /**
     * List every position for a given market.
     */
    public function index(string $market): View
    {
        abort_unless(array_key_exists($market, self::MARKETS), 404);

        $trades = Trade::with('user')
            ->market($market)
            ->latest()
            ->paginate(20);

        return view('admin.trades.index', [
            'market' => $market,
            'marketLabel' => self::MARKETS[$market],
            'trades' => $trades,
        ]);
    }

    /**
     * Adjust the profit/loss carried on an open position.
     * A positive amount increases profit, a negative amount records a loss.
     */
    public function adjustProfit(Request $request, Trade $trade): RedirectResponse
    {
        if (! $trade->isOpen()) {
            return back()->with('error', 'This position is closed and can no longer be adjusted.');
        }

        $validated = $request->validate([
            'profit' => ['required', 'numeric', 'min:-1000000', 'max:1000000'],
        ]);

        $trade->increment('profit', round((float) $validated['profit'], 2));

        return back()->with('status', "Profit updated for {$trade->symbol}.");
    }

    /**
     * Settle an open position: return capital plus profit to the wallet and close it.
     */
    public function close(Trade $trade): RedirectResponse
    {
        if (! $trade->isOpen()) {
            return back()->with('error', 'This position is already closed.');
        }

        DB::transaction(function () use ($trade): void {
            $payout = max(0.0, $trade->currentValue());

            $trade->user->credit($payout, 'return', "Position settled: {$trade->symbol} ({$trade->market})");
            $trade->update([
                'status' => 'closed',
                'closed_at' => Carbon::now(),
            ]);
        });

        return back()->with('status', "{$trade->symbol} position settled to the user's wallet.");
    }

    /**
     * Remove a position without paying it out.
     */
    public function destroy(Trade $trade): RedirectResponse
    {
        $trade->delete();

        return back()->with('status', 'Position deleted.');
    }
}
