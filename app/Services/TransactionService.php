<?php

namespace App\Services;

use App\Contracts\TransactionServiceInterface;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
    public function unitCheck(string $unit, ?string $productId): bool
    {
        $productUnit = DB::table('products')
            ->where('id', $productId)
            ->value('unit');

        return $productUnit != $unit;
    }
}
