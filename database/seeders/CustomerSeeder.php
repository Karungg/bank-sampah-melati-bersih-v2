<?php

namespace Database\Seeders;

use App\Contracts\AccountServiceInterface;
use App\Models\Account;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(AccountServiceInterface $service): void
    {
        $csvFilePath = base_path('database/seeders/data/customers.csv');

        $csv = Reader::createFromPath($csvFilePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $index => $record) {
            User::withoutEvents(function () use ($record, $service) {
                $user = User::factory()->customer()->create([
                    'name' => Str::ucfirst($record['name']),
                    'email' => Str::lower(Str::replace(' ', '', $record['name'])) . '@gmail.com'
                ]);

                $customer =  Customer::create([
                    'nik' => str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT),
                    'full_name' => Str::ucfirst($record['name']),
                    'place_of_birth' => 'kosong',
                    'date_of_birth' => date('y-m-d'),
                    'address' => Str::ucfirst($record['address']),
                    'rt' => $record['rt'],
                    'rw' => $record['rw'],
                    'village' => $record['village'],
                    'district' => $record['district'],
                    'city' => $record['city'],
                    'postal_code' => $record['postal_code'],
                    'phone' => '0',
                    'user_id' => $user->id,
                ]);

                Account::create([
                    'account_number' => $service->generateAccountNumber($record['postal_code']),
                    'debit' => $record['debit'],
                    'credit' => $record['credit'],
                    'balance' => $record['balance'],
                    'customer_id' => $customer->id
                ]);
            });
        }
    }
}
