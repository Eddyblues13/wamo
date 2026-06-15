<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'type', 'code', 'network', 'address',
    'bank_name', 'account_name', 'account_number',
    'instructions', 'icon', 'min_amount', 'is_active', 'sort_order',
])]
class DepositMethod extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'min_amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @param  Builder<DepositMethod>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true)->orderBy('sort_order');
    }

    public function isCrypto(): bool
    {
        return $this->type === 'crypto';
    }
}
