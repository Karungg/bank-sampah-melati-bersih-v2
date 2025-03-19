<?php

namespace App\Models;

use App\Observers\TransactionDetailObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(TransactionDetailObserver::class)]
class TransactionDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionDetailFactory> */
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    protected $fillable = [
        'quantity',
        'weight',
        'liter',
        'current_price',
        'subtotal',
        'transaction_id',
        'product_id'
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
