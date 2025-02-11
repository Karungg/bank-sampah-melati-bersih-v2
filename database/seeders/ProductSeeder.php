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
                'title' => 'Kaleng',
                'description' => 'Sampah kaleng',
                'unit' => 'kg',
                'price' => 1500
            ],
            [
                'title' => 'Aluminium',
                'description' => 'Sampah aluminium',
                'unit' => 'kg',
                'price' => 6500
            ],
            [
                'title' => 'Jelantah',
                'description' => 'Sampah jelantah',
                'unit' => 'liter',
                'price' => 3500
            ],
            [
                'title' => 'Aqua',
                'description' => 'Sampah aqua',
                'unit' => 'kg',
                'price' => 100
            ],
            [
                'title' => 'Emberan',
                'description' => 'Sampah emberan',
                'unit' => 'kg',
                'price' => 100
            ],
            [
                'title' => 'Besi',
                'description' => 'Sampah besi',
                'unit' => 'kg',
                'price' => 3500
            ],
            [
                'title' => 'Kardus',
                'description' => 'Sampah kardus',
                'unit' => 'kg',
                'price' => 900
            ],
            [
                'title' => 'Buku',
                'description' => 'Sampah buku',
                'unit' => 'kg',
                'price' => 800
            ],
            [
                'title' => 'PE plastik',
                'description' => 'Sampah PE plastik',
                'unit' => 'kg',
                'price' => 500
            ],
            [
                'title' => 'Boncos',
                'description' => 'Sampah boncos',
                'unit' => 'kg',
                'price' => 300
            ],
            [
                'title' => 'Beling',
                'description' => 'Sampah beling',
                'unit' => 'kg',
                'price' => 150
            ],
            [
                'title' => 'Kristal',
                'description' => 'Sampah kristal',
                'unit' => 'pcs',
                'price' => 800
            ],
            [
                'title' => 'Kabin',
                'description' => 'Sampah kabin',
                'unit' => 'pcs',
                'price' => 1000
            ],
            [
                'title' => 'Mesin cuci',
                'description' => 'Sampah mesin cuci',
                'unit' => 'pcs',
                'price' => 45000
            ],
            [
                'title' => 'Kulkas 2 pintu',
                'description' => 'Sampah kulkas 2 pintu',
                'unit' => 'pcs',
                'price' => 130000
            ],
            [
                'title' => 'Kulkas 1 pintu',
                'description' => 'Sampah kulkas 1 pintu',
                'unit' => 'pcs',
                'price' => 80000
            ],
            [
                'title' => 'TV jadul',
                'description' => 'Sampah TV jadul',
                'unit' => 'pcs',
                'price' => 15000
            ],
        ];

        foreach ($products as $product) {
            Product::withoutEvents(function () use ($product) {

                $createProduct = Product::create([
                    'product_code' => $this->productService->generateCode($product['title']),
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
