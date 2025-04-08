<x-app-layout>
    <div class="py-20">
        <div class="w-full lg:pt-14 max-w-7xl flex flex-col mx-auto px-4">

            <div class="w-full mb-5 flex flex-col">
                <div class="stats stats-vertical sm:stats-horizontal shadow">
                    <div class="stat items-center">
                        <div class="stat-value text-sm">{{ Auth::user()->name }}</div>
                    </div>

                    <div class="stat">
                        <div class="stat-title">Total Debet</div>
                        <div class="stat-value text-sm">Rp.{{ number_format($totalDebit, 0, ',', '.') }}</div>
                    </div>

                    <div class="stat">
                        <div class="stat-title">Total Kredit</div>
                        <div class="stat-value text-sm">Rp.{{ number_format($totalCredit, 0, ',', '.') }}</div>
                    </div>

                    <div class="stat">
                        <div class="stat-title">Saldo</div>
                        <div class="stat-value text-sm">
                            Rp.{{ number_format(Auth::user()->customer->account->balance, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="w-full mx-auto">
                <div class="overflow-x-auto p-3 rounded-box border border-base-content/5 bg-base-100">
                    <div class="flex flex-col sm:flex-row justify-between items-center my-3 gap-4">

                        <div>

                            <button class="btn btn-xs sm:btn-sm" id="buttonCopy">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3a2.25 2.25 0 00-2.166 1.638m7.332 0c.055.194.084.4.084.612a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75c0-.212.03-.418.084-.612m7.332 0a48.21 48.21 0 011.927.184c1.1.128 1.907 1.077 1.907 2.185V19.5A2.25 2.25 0 0117.25 21.75H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.21 48.21 0 011.927-.184" />
                                </svg>
                                Copy
                            </button>

                            <button class="btn btn-xs sm:btn-sm" id="buttonExcel">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-5 text-green-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M8.25 15h7.5m-7.5 3H12M10.5 2.25H5.625A1.125 1.125 0 004.5 3.375v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9Z" />
                                </svg>
                                Excel
                            </button>

                            <button class="btn btn-xs sm:btn-sm" id="buttonPdf">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-5 text-red-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6M10.5 2.25H5.625A1.125 1.125 0 004.5 3.375v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9Z" />
                                </svg>
                                PDF
                            </button>

                            <button class="btn btn-xs sm:btn-sm" id="buttonPrint">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.42 42.42 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 01-1.12 1.227H7.23c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.32 0h1.09A2.25 2.25 0 0021 15.75V9.456a2.25 2.25 0 00-1.837-2.175 48.06 48.06 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456a2.25 2.25 0 011.837-2.175 48.04 48.04 0 011.913-.247M17.25 7.034a48.53 48.53 0 00-10.5 0V3.375A1.125 1.125 0 018.25 2.25h8.25A1.125 1.125 0 0117.625 3.375v3.659" />
                                </svg>
                                Print
                            </button>
                        </div>

                        <div>
                            <label class="input h-8">
                                <svg class="size-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </g>
                                </svg>
                                <input type="text" class="filter" id="filter" placeholder="Cari">
                            </label>
                        </div>
                    </div>

                    <table id="transactions" class="table table-xs sm:table-md">
                        <thead>
                            <tr>
                                <th class="dark:text-white">No</th>
                                <th class="dark:text-white">Kode Transaksi</th>
                                <th class="dark:text-white">Tanggal</th>
                                <th class="dark:text-white">Debet</th>
                                <th class="dark:text-white">Kredit</th>
                                <th class="dark:text-white">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $transaction->transaction_code }}</td>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td>Rp.{{ number_format($transaction->debit, 0, ',', '.') }}</td>
                                    <td>Rp.{{ number_format($transaction->credit, 0, ',', '.') }}</td>
                                    <td>Rp.{{ number_format($transaction->balance, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
