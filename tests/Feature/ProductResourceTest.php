<?php

use App\Models\User;
use function Pest\Livewire\livewire;
use App\Filament\Resources\ProductResource;

it('create product resource: can validate required inputs', function () {
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
