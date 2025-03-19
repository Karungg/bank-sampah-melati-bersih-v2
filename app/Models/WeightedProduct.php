<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeightedProduct extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'weighted_products';
    protected $keyType = 'string';

    protected $fillable = [
        'total_quantity',
        'total_weight',
        'total_liter',
        'product_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
