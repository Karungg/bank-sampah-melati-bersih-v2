<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyProfile::create([
            'name' => 'BSMB Atsiri Permai RW.012.',
            'description' => 'Bank sampah Atsiri RW.012. diresmikan 31 agustus 2013 atas hasil kerja sama bank sampah melati bersih (BSMB) dengan universitas di Jakarta bank sampah atsiri',
            'address' => 'JL. Kenanga 4 No 13 atsiri permai ragajaya bojong gede bogor.',
            'weighing_location' => 'Lapangan bola atsiri',
            'annountcement' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'account_number' => '7230051652',
            'on_behalf' => 'Siti Awan',
            'balance' => 2500000
        ]);
    }
}
