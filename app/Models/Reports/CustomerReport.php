<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;

class CustomerReport extends Model
{
    use HasUuids;

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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
