<?php

namespace App\Console\Commands;

use App\Models\UserInvestment;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

#[Signature('app:mature-investments')]
#[Description('Credit principal + returns for any investments that have reached maturity.')]
class MatureInvestments extends Command
{
    public function handle(): int
    {
        $due = UserInvestment::with(['user', 'plan'])
            ->where('status', 'active')
            ->where('matures_at', '<=', Carbon::now())
            ->get();

        if ($due->isEmpty()) {
            $this->info('No investments are due for maturity.');

            return self::SUCCESS;
        }

        $matured = 0;

        foreach ($due as $investment) {
            DB::transaction(function () use ($investment): void {
                $payout = (float) $investment->amount + (float) $investment->expected_return;

                $investment->user->credit(
                    $payout,
                    'return',
                    "Matured: {$investment->plan->name} plan (principal + return)",
                );

                $investment->update(['status' => 'completed']);
            });

            $matured++;
        }

        $this->info("Matured {$matured} investment(s).");

        return self::SUCCESS;
    }
}
