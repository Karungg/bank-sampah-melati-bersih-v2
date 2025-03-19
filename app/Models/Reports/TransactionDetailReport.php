<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TransactionDetailReport extends Model
{
    use HasUuids;

    protected $table = "transaction_detail_reports";

    protected $keyType = 'string';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'weight',
        'liter',
        'subtotal'
    ];
}
