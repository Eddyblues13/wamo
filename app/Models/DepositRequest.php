<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'user_id', 'deposit_method_id', 'method_label',
    'amount', 'reference', 'proof_path', 'status', 'admin_note', 'processed_at',
])]
class DepositRequest extends Model
{
    public function proofUrl(): ?string
    {
        return $this->proof_path ? Storage::disk('public')->url($this->proof_path) : null;
    }

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

    /**
     * @return BelongsTo<DepositMethod, $this>
     */
    public function method(): BelongsTo
    {
        return $this->belongsTo(DepositMethod::class, 'deposit_method_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
