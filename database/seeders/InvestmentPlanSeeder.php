<?php

namespace Database\Seeders;

use App\Models\InvestmentPlan;
use Illuminate\Database\Seeder;

class InvestmentPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'tagline' => 'Begin your investment journey',
                'description' => 'A low-risk entry plan ideal for first-time investors building diversified exposure across digital assets and equities.',
                'icon' => '🌱',
                'gradient' => 'from-emerald-400/30 to-teal-500/10',
                'min_amount' => 100,
                'max_amount' => 4999,
                'roi_percent' => 8.50,
                'duration_days' => 30,
                'payout_interval' => 'At maturity',
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Growth',
                'slug' => 'growth',
                'tagline' => 'Accelerate your portfolio',
                'description' => 'A balanced plan combining crypto, equities and forex for investors seeking steady, compounding growth over the medium term.',
                'icon' => '📈',
                'gradient' => 'from-sky-400/30 to-indigo-500/10',
                'min_amount' => 5000,
                'max_amount' => 24999,
                'roi_percent' => 14.00,
                'duration_days' => 60,
                'payout_interval' => 'Monthly',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'tagline' => 'For the committed investor',
                'description' => 'A higher-yield, actively managed strategy across all asset classes, with priority support and weekly performance reporting.',
                'icon' => '💎',
                'gradient' => 'from-violet-400/30 to-purple-500/10',
                'min_amount' => 25000,
                'max_amount' => 99999,
                'roi_percent' => 22.00,
                'duration_days' => 90,
                'payout_interval' => 'Monthly',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Private Wealth',
                'slug' => 'private-wealth',
                'tagline' => 'Institutional-grade returns',
                'description' => 'A bespoke portfolio for high-net-worth clients, featuring dedicated advisory, real estate allocation and the platform’s highest yields.',
                'icon' => '🏛️',
                'gradient' => 'from-amber-400/30 to-orange-500/10',
                'min_amount' => 100000,
                'max_amount' => 1000000,
                'roi_percent' => 30.00,
                'duration_days' => 180,
                'payout_interval' => 'Quarterly',
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($plans as $plan) {
            InvestmentPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
