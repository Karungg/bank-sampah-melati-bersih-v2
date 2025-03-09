<?php

namespace App\Services;

use App\Contracts\WithDrawalServerInterface;
use Illuminate\Support\Facades\DB;

class WithDrawalService implements WithDrawalServerInterface
{
    public function generateCode(): string
    {
        $date = now()->format('Ymd');

        $latestTransaction = DB::table('with_drawals')
            ->whereDate('created_at', now())
            ->latest()
            ->value('with_drawal_code');

        $sequence = 1;
        if ($latestTransaction) {
            $latestSequence = substr($latestTransaction, -3);
            $sequence = $latestSequence + 1;
        }

        $sequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return 'WD' . $date . $sequence;
    }

    public function store(string $customerId, int $amount): bool
    {
        try {
            return DB::transaction(function () use ($customerId, $amount) {
                $account = DB::table('accounts')
                    ->where('customer_id', $customerId);

                $account->decrement('balance', $amount);
                $account->increment('credit', $amount);

                DB::table('company_profiles')
                    ->decrement('balance', $amount);
                return true;
            });
        } catch (\Throwable $th) {
            return false;
        }
    }
}
