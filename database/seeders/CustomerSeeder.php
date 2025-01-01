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
        $records = Reader::createFromPath($csvFilePath, 'r')
            ->setHeaderOffset(0)
            ->getRecords();

        foreach ($records as $record) {
            User::withoutEvents(function () use ($record, $service) {
                $user = $this->createUser($record['name']);
                $customer = $this->createCustomer($record, $user->id);
                $this->createAccount($record, $service, $customer->id);
            });
        }
    }

    private function createUser(string $name): User
    {
        return User::factory()->customer()->create([
            'name' => Str::ucfirst($name),
            'email' => Str::lower(Str::replace(' ', '', $name)) . '@gmail.com',
        ]);
    }

    private function createCustomer(array $record, string $userId): Customer
    {
        return Customer::withoutEvents(function () use ($record, $userId) {
            return Customer::create([
                'nik' => str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT),
                'full_name' => Str::ucfirst($record['name']),
                'place_of_birth' => 'kosong',
                'date_of_birth' => now()->toDateString(),
                'address' => Str::ucfirst($record['address']),
                'rt' => $record['rt'],
                'rw' => $record['rw'],
                'village' => $record['village'],
                'district' => $record['district'],
                'city' => $record['city'],
                'postal_code' => $record['postal_code'],
                'phone' => '0',
                'user_id' => $userId,
            ]);
        });
    }

    private function createAccount(array $record, AccountServiceInterface $service, string $customerId): void
    {
        Account::create([
            'account_number' => $service->generateAccountNumber($record['postal_code']),
            'debit' => $record['debit'],
            'credit' => $record['credit'],
            'balance' => $record['balance'],
            'customer_id' => $customerId,
        ]);
    }
}
