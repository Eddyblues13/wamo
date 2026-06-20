<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'method', 'amount',
    'account_name', 'bank_name', 'account_number', 'swift_code',
    'crypto_network', 'wallet_address',
    'status', 'admin_note', 'processed_at',
])]
class WithdrawalRequest extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'processed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isBank(): bool
    {
        return $this->method === 'bank';
    }

    public function isCrypto(): bool
    {
        return $this->method === 'crypto';
    }

    public function methodLabel(): string
    {
        return $this->isBank() ? 'Bank transfer' : 'Crypto wallet';
    }

    /**
     * Human-readable destination summary for admin lists / emails.
     */
    public function destinationSummary(): string
    {
        if ($this->isBank()) {
            return trim("{$this->bank_name} · ****".substr((string) $this->account_number, -4), ' ·');
        }

        return trim("{$this->crypto_network} · ".substr((string) $this->wallet_address, 0, 10).'…', ' ·');
    }
}
