<?php

namespace App\Models\Reports;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
