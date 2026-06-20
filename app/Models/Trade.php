<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'market', 'symbol', 'name', 'amount', 'profit', 'status', 'closed_at',
])]
class Trade extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'profit' => 'decimal:2',
            'closed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Current position value: capital plus accrued profit/loss.
     */
    public function currentValue(): float
    {
        return (float) $this->amount + (float) $this->profit;
    }

    /**
     * @param  Builder<Trade>  $query
     * @return Builder<Trade>
     */
    public function scopeMarket(Builder $query, string $market): Builder
    {
        return $query->where('market', $market);
    }

    /**
     * @param  Builder<Trade>  $query
     * @return Builder<Trade>
     */
    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', 'open');
    }
}
