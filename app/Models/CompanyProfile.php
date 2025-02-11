<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'address',
        'weighing_location',
        'account_number',
        'on_behalf',
        'balance'
    ];
}
