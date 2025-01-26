<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = collect([
            ['KA', 'Kaleng', 'Sampah kaleng', 'kg', 1500],
            ['AL', 'Aluminium', 'Sampah aluminium', 'kg', 6500],
            ['JE', 'Jelantah', 'Sampah jelantah', 'liter', 3500],
            ['AQ', 'Aqua', 'Sampah aqua', 'kg', 100],
            ['EM', 'Emberan', 'Sampah emberan', 'kg', 100],
            ['BE', 'Besi', 'Sampah besi', 'kg', 3500],
            ['KA', 'Kardus', 'Sampah kardus', 'kg', 900],
            ['BU', 'Buku', 'Sampah buku', 'kg', 800],
            ['PE', 'PE plastik', 'Sampah PE plastik', 'kg', 500],
            ['BO', 'Boncos', 'Sampah boncos', 'kg', 300],
            ['BE', 'Beling', 'Sampah beling', 'kg', 150],
            ['KR', 'Kristal', 'Sampah kristal', 'pcs', 800],
            ['KA', 'Kabin', 'Sampah kabin', 'pcs', 1000],
            ['ME', 'Mesin cuci', 'Sampah mesin cuci', 'pcs', 45000],
            ['KU', 'Kulkas 2 pintu', 'Sampah kulkas 2 pintu', 'pcs', 130000],
            ['KU', 'Kulkas 1 pintu', 'Sampah kulkas 1 pintu', 'pcs', 80000],
            ['TV', 'TV jadul', 'Sampah TV jadul', 'pcs', 15000],
        ])->map(function ($product, $index) {
            $timestamp = now()->addSeconds($index + 1);
            return [
                'id' => Str::uuid(),
                'product_code' => $product[0] . date('Ymd') . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'title' => $product[1],
                'description' => $product[2],
                'unit' => $product[3],
                'price' => $product[4],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        });

        DB::table('products')->insert($products->toArray());
    }
}
