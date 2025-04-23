<?php

namespace App\Models;

use App\Observers\CompanyProfileObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(CompanyProfileObserver::class)]
class CompanyProfile extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'address',
        'weighing_location',
        'annountcement',
        'account_number',
        'on_behalf',
        'balance',
        'sales_balance'
    ];
}
