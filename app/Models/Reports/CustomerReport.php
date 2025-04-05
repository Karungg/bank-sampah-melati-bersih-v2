<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerReport extends Model
{
    use HasUuids, HasFactory;

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
