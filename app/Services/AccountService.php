<?php

namespace App\Services;

use App\Contracts\AccountServiceInterface;
use Illuminate\Support\Facades\DB;

class AccountService implements AccountServiceInterface
{
    public function generateAccountNumber(string $postalCode): string
    {
        do {
            $accountNumber = $postalCode . random_int(10000, 99999);
        } while (DB::table('accounts')->where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }
}
