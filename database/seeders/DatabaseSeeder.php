<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            InvestmentPlanSeeder::class,
            DepositMethodSeeder::class,
            AdminSeeder::class,
        ]);

        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password'],
        );

        // balance and email_verified_at are intentionally not mass-assignable.
        $user->forceFill([
            'balance' => 50000,
            'email_verified_at' => Carbon::now(),
        ])->save();
    }
}
