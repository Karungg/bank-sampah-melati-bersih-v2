<?php

use App\Models\User;
use function Pest\Livewire\livewire;
use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Str;

it('create product resource: can validate required inputs', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    livewire(ProductResource\Pages\CreateProduct::class)
        ->fillForm([
            'product_code' => Str::random(16),
            'title' => fake()->text(100),
            'description' => fake()->text(999),
            'price' => fake()->numberBetween(10000000000, 9999999999),
        ])
        ->call('create')
        ->assertHasFormErrors();
});

it('create product resource: required errors form input', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    livewire(ProductResource\Pages\CreateProduct::class)
        ->fillForm([
            'product_code' => null,
            'title' => null,
            'description' => null,
            'unit' => null,
            'price' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'product_code' => 'required',
            'title' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ]);
});

it('create product resource : max length errors form input', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    livewire(ProductResource\Pages\CreateProduct::class)
        ->fillForm([
            'product_code' => Str::random(17), // max length 16
            'title' => Str::random(101), // max length 100
            'description' => Str::random(1001), // max length 1000
            'unit' => 'pcs',
            'price' => 10000000000, // max digits is 10, test 11 digit
        ])
        ->call('create')
        ->assertHasFormErrors([
            'title' => 'max',
            'price' => 'max_digits'
        ])
        ->assertSeeText('Deskripsi tidak boleh lebih dari 1000 karakter.');
});

it('create product resource : unique validation errors form input', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    Product::create([
        'product_code' => 'SA20250216',
        'title' => 'Sampah',
        'description' => 'Deskripsi sampah',
        'unit' => 'pcs',
        'price' => 2000
    ]);

    livewire(ProductResource\Pages\CreateProduct::class)
        ->fillForm([
            'product_code' => 'SA20250216',
            'title' => 'Sampah',
            'description' => 'Deskripsi sampah',
            'unit' => 'pcs',
            'price' => 2000,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'title' => 'unique'
        ]);
});
