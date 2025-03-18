<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;

class CustomerReport extends Model
{
    protected $table = 'customer_reports';
    protected $keyType = 'string';

    protected $fillable = [
        'transaction_code',
        'debit',
        'credit',
        'balance',
        'type',
        'customer_id'
    ];
}
