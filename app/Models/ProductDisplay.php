<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDisplay extends Model
{
    /** @use HasFactory<\Database\Factories\ProductDisplayFactory> */
    use HasFactory, HasUuids;

    protected $table = 'product_displays';
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'description',
        'image'
    ];
}
