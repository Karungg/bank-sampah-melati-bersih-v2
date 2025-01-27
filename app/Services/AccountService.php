<?php

namespace App\Services;

use App\Contracts\AccountServiceInterface;
use Illuminate\Support\Facades\DB;

class AccountService implements AccountServiceInterface
{
    public function generateAccountNumber(string $customerId): string
    {
        $postalCode = DB::table('customers')->where('id', $customerId)->value('postal_code');

        do {
            $accountNumber = $postalCode . random_int(10000, 99999);
        } while (DB::table('accounts')->where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }
}
