<?php

namespace Database\Seeders;

use App\Models\DepositMethod;
use Illuminate\Database\Seeder;

class DepositMethodSeeder extends Seeder
{
    public function run(): void
    {
        // Placeholder wallet addresses — the admin replaces these with real ones.
        $crypto = [
            ['Bitcoin', 'BTC', 'Bitcoin', '🟠', 'bc1qexampleplaceholderbtcaddress0000000000'],
            ['Ethereum', 'ETH', 'ERC20', '🔷', '0x00000000000000000000000000000000000Example'],
            ['USDT', 'USDT', 'TRC20', '🟢', 'TXExamplePlaceholderUsdtTrc20Address000000'],
            ['USDT', 'USDT', 'ERC20', '🟢', '0x00000000000000000000000000000000usdtErc20'],
            ['USDT', 'USDT', 'BEP20', '🟢', '0x00000000000000000000000000000000usdtBep20'],
            ['USD Coin', 'USDC', 'ERC20', '🔵', '0x0000000000000000000000000000000000usdcEx'],
            ['BNB', 'BNB', 'BEP20', '🟡', 'bnb1exampleplaceholderbnbaddress0000000000'],
            ['Solana', 'SOL', 'Solana', '🟣', 'SoLExamplePlaceholderSolanaAddress00000000'],
            ['XRP', 'XRP', 'Ripple', '⚪', 'rExamplePlaceholderXrpAddress000000000000'],
            ['Litecoin', 'LTC', 'Litecoin', '⚪', 'ltc1qexampleplaceholderltcaddress0000000000'],
            ['Tron', 'TRX', 'TRC20', '🔴', 'TXExamplePlaceholderTronAddress0000000000'],
            ['Dogecoin', 'DOGE', 'Dogecoin', '🟡', 'DExamplePlaceholderDogeAddress0000000000'],
        ];

        $sort = 0;
        foreach ($crypto as [$name, $code, $network, $icon, $address]) {
            DepositMethod::updateOrCreate(
                ['code' => $code, 'network' => $network],
                [
                    'name' => $network && $network !== $name ? "{$name} ({$network})" : $name,
                    'type' => 'crypto',
                    'icon' => $icon,
                    'address' => $address,
                    'instructions' => "Send only {$code} over the {$network} network to the address above. Deposits credited after network confirmation.",
                    'min_amount' => 10,
                    'is_active' => true,
                    'sort_order' => $sort++,
                ],
            );
        }

        DepositMethod::updateOrCreate(
            ['type' => 'bank', 'name' => 'Bank Transfer'],
            [
                'icon' => '🏦',
                'bank_name' => 'Fintriva Financial (Demo Bank)',
                'account_name' => 'Fintriva Holdings Ltd',
                'account_number' => '0123456789',
                'instructions' => 'Transfer to the account above and enter your transfer reference. Funds credited after confirmation.',
                'min_amount' => 50,
                'is_active' => true,
                'sort_order' => 100,
            ],
        );
    }
}
