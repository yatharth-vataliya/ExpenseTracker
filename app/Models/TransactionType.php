<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'transaction_type_name', 'description',
    ];

    public function editUrl(): string
    {
        return route('transaction-types-edit', [
            'transactionType' => $this->id,
        ]);
    }

    public function scopeCurrentUserTransactionType(Builder $query): void
    {
        $query->where('user_id', auth()->id());
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transaction_type_id', 'id');
    }
}
