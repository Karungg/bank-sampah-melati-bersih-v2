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
}
