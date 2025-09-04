<?php

namespace App\Models;

use Database\Factories\ProductDisplayFactory;
use App\Observers\ProductDisplayObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ProductDisplayObserver::class)]
class ProductDisplay extends Model
{
    /** @use HasFactory<ProductDisplayFactory> */
    use HasFactory, HasUuids;

    protected $table = 'product_displays';
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'description',
        'image'
    ];

    public function getThumbnail(): string
    {
        return str_starts_with($this->image, 'https') ? $this->image : "/storage/$this->image";
    }
}
