<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TransactionReport extends Model
{
    use HasUuids;

    protected $table = 'transaction_reports';
    protected $keyType = 'string';

    protected $fillable = [
        'transaction_code',
        'total_quantity',
        'total_weight',
        'total_liter',
        'total_amount',
        'type',
        'location',
        'user_id',
        'customer_id',
    ];
}
