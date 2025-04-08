<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = DB::table('customer_reports')
            ->select([
                'id',
                'transaction_code',
                'debit',
                'credit',
                'balance',
                DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y %H:%i:%s") as created_at')
            ])
            ->where('customer_id', auth()->user()->customer->id)
            ->get();

        $totalDebit = DB::table('customer_reports')
            ->sum('debit');

        $totalCredit = DB::table('customer_reports')
            ->sum('credit');

        return view('transactions.index', [
            'transactions' => $transactions,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit
        ]);
    }
}
