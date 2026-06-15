<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token', 'verification_code'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verification_code_expires_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
        ];
    }

    /**
     * @return HasMany<UserInvestment, $this>
     */
    public function investments(): HasMany
    {
        return $this->hasMany(UserInvestment::class)->latest();
    }

    /**
     * @return HasMany<Transaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    /**
     * @return HasMany<DepositRequest, $this>
     */
    public function depositRequests(): HasMany
    {
        return $this->hasMany(DepositRequest::class)->latest();
    }

    /**
     * Add funds to the wallet and record a ledger entry, atomically.
     */
    public function credit(float $amount, string $type, ?string $description = null): Transaction
    {
        return DB::transaction(function () use ($amount, $type, $description): Transaction {
            $this->increment('balance', $amount);

            return $this->transactions()->create([
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $this->balance,
                'description' => $description,
            ]);
        });
    }

    /**
     * Remove funds from the wallet and record a ledger entry, atomically.
     *
     * @throws \RuntimeException when the balance is insufficient.
     */
    public function debit(float $amount, string $type, ?string $description = null): Transaction
    {
        return DB::transaction(function () use ($amount, $type, $description): Transaction {
            $fresh = static::whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if ((float) $fresh->balance < $amount) {
                throw new \RuntimeException('Insufficient wallet balance.');
            }

            $this->decrement('balance', $amount);

            return $this->transactions()->create([
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $this->balance,
                'description' => $description,
            ]);
        });
    }

    /**
     * Generate, hash and persist a fresh 4-digit verification code.
     * Returns the plain code so it can be emailed.
     */
    public function issueVerificationCode(): string
    {
        $code = (string) random_int(1000, 9999);

        $this->forceFill([
            'verification_code' => Hash::make($code),
            'verification_code_expires_at' => Carbon::now()->addMinutes(10),
            'verification_attempts' => 0,
        ])->save();

        return $code;
    }

    public function verificationCodeMatches(string $code): bool
    {
        return $this->verification_code !== null
            && Hash::check($code, $this->verification_code);
    }

    public function verificationCodeExpired(): bool
    {
        return $this->verification_code_expires_at === null
            || $this->verification_code_expires_at->isPast();
    }

    public function markEmailVerified(): void
    {
        $this->forceFill([
            'email_verified_at' => Carbon::now(),
            'verification_code' => null,
            'verification_code_expires_at' => null,
            'verification_attempts' => 0,
        ])->save();
    }
}
