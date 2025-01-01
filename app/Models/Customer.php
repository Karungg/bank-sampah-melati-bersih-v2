<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'full_name',
        'place_of_birth',
        'date_of_birth',
        'phone',
        'address',
        'rt',
        'rw',
        'village',
        'district',
        'city',
        'postal_code',
        'user_id',
        'identity_card_photo'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }
}
