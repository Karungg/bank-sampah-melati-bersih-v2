<x-app-layout>
    <div class="py-20">
        <div class="w-full flex mx-auto justify-center">
            <div class="overflow-x-auto p-3 rounded-box border border-base-content/5 bg-base-100">
                <table id="transactions" class="table">
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
</x-app-layout>
