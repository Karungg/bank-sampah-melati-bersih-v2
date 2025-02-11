<?php

namespace Database\Seeders;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\WeightedProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function __construct(protected ProductServiceInterface $productService) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_code' => 'KA' . date('Ymd') . '001',
                'title' => 'Kaleng',
                'description' => 'Sampah kaleng',
                'unit' => 'kg',
                'price' => 1500
            ],
            [
                'product_code' => 'AL' . date('Ymd') . '002',
                'title' => 'Aluminium',
                'description' => 'Sampah aluminium',
                'unit' => 'kg',
                'price' => 6500
            ],
            [
                'product_code' => 'JE' . date('Ymd') . '003',
                'title' => 'Jelantah',
                'description' => 'Sampah jelantah',
                'unit' => 'liter',
                'price' => 3500
            ],
            [
                'product_code' => 'AQ' . date('Ymd') . '004',
                'title' => 'Aqua',
                'description' => 'Sampah aqua',
                'unit' => 'kg',
                'price' => 100
            ],
            [
                'product_code' => 'EM' . date('Ymd') . '005',
                'title' => 'Emberan',
                'description' => 'Sampah emberan',
                'unit' => 'kg',
                'price' => 100
            ],
            [
                'product_code' => 'BE' . date('Ymd') . '006',
                'title' => 'Besi',
                'description' => 'Sampah besi',
                'unit' => 'kg',
                'price' => 3500
            ],
            [
                'product_code' => 'KA' . date('Ymd') . '007',
                'title' => 'Kardus',
                'description' => 'Sampah kardus',
                'unit' => 'kg',
                'price' => 900
            ],
            [
                'product_code' => 'BU' . date('Ymd') . '008',
                'title' => 'Buku',
                'description' => 'Sampah buku',
                'unit' => 'kg',
                'price' => 800
            ],
            [
                'product_code' => 'PE' . date('Ymd') . '009',
                'title' => 'PE plastik',
                'description' => 'Sampah PE plastik',
                'unit' => 'kg',
                'price' => 500
            ],
            [
                'product_code' => 'BO' . date('Ymd') . '010',
                'title' => 'Boncos',
                'description' => 'Sampah boncos',
                'unit' => 'kg',
                'price' => 300
            ],
            [
                'product_code' => 'BE' . date('Ymd') . '011',
                'title' => 'Beling',
                'description' => 'Sampah beling',
                'unit' => 'kg',
                'price' => 150
            ],
            [
                'product_code' => 'KR' . date('Ymd') . '012',
                'title' => 'Kristal',
                'description' => 'Sampah kristal',
                'unit' => 'pcs',
                'price' => 800
            ],
            [
                'product_code' => 'KA' . date('Ymd') . '013',
                'title' => 'Kabin',
                'description' => 'Sampah kabin',
                'unit' => 'pcs',
                'price' => 1000
            ],
            [
                'product_code' => 'ME' . date('Ymd') . '014',
                'title' => 'Mesin cuci',
                'description' => 'Sampah mesin cuci',
                'unit' => 'pcs',
                'price' => 45000
            ],
            [
                'product_code' => 'KU' . date('Ymd') . '015',
                'title' => 'Kulkas 2 pintu',
                'description' => 'Sampah kulkas 2 pintu',
                'unit' => 'pcs',
                'price' => 130000
            ],
            [
                'product_code' => 'KU' . date('Ymd') . '016',
                'title' => 'Kulkas 1 pintu',
                'description' => 'Sampah kulkas 1 pintu',
                'unit' => 'pcs',
                'price' => 80000
            ],
            [
                'product_code' => 'TV' . date('Ymd') . '017',
                'title' => 'TV jadul',
                'description' => 'Sampah TV jadul',
                'unit' => 'pcs',
                'price' => 15000
            ],
        ];

        foreach ($products as $product) {
            Product::withoutEvents(function () use ($product) {

                $createProduct = Product::create([
                    'product_code' => $product['product_code'],
                    'title' => $product['title'],
                    'description' => $product['description'],
                    'unit' => $product['unit'],
                    'price' => $product['price']
                ]);

                $createProduct->weightedProduct()->create([
                    'total_quantity' => 0,
                    'total_weight' => 0,
                    'total_liter' => 0
                ]);
            });
        }
    }
}
