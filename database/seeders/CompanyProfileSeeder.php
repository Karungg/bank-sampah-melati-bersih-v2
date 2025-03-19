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
            'account_number' => '7230051652',
            'on_behalf' => 'Siti Awan',
            'balance' => 2500000
        ]);
    }
}
