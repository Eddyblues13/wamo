<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'slug', 'tagline', 'description', 'icon', 'gradient',
    'min_amount', 'max_amount', 'roi_percent', 'duration_days',
    'payout_interval', 'is_featured', 'is_active', 'sort_order',
])]
class InvestmentPlan extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'min_amount' => 'decimal:2',
            'max_amount' => 'decimal:2',
            'roi_percent' => 'decimal:2',
            'duration_days' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return HasMany<UserInvestment, $this>
     */
    public function investments(): HasMany
    {
        return $this->hasMany(UserInvestment::class);
    }

    /**
     * @param  Builder<InvestmentPlan>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true)->orderBy('sort_order');
    }

    public function returnFor(float $amount): float
    {
        return round($amount * ((float) $this->roi_percent / 100), 2);
    }
}
