<?php

use App\Filament\Clusters\Users\Resources\CustomerResource;
use App\Models\User;
use function Pest\Livewire\livewire;

use Illuminate\Support\Str;

beforeEach(function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
});

test('customer resource : create customer has no errors', function () {
    livewire(CustomerResource\Pages\CreateCustomer::class)
        ->fillForm([
            'nik' => '1234567890123456',
            'full_name' => fake()->name(),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => now()->toDateString(),
            'address' => fake()->address(),
            'rt' => random_int(100, 999),
            'rw' => random_int(100, 999),
            'village' => fake()->city(),
            'district' => fake()->city(),
            'city' => fake()->city(),
            'postal_code' => random_int(10000, 99999),
            'phone' => '123456789',
            'email' => fake()->email(),
            'password' => fake()->password(8)
        ])
        ->call('create')
        ->assertHasNoFormErrors();
});

test('customer resource : create customer has max errors', function () {
    livewire(CustomerResource\Pages\CreateCustomer::class)
        ->fillForm([
            'nik' => '12345678901234567', // max : 16, min : 16, test : 17
            'full_name' => Str::random(101), // max : 100, test : 101
            'place_of_birth' => Str::random(51), // max : 50, test : 51
            'date_of_birth' => 'not date',
            'address' => Str::random(2001), // max : 2000, test : 2001
            'rt' => random_int(1000, 9999), // max : 3, min : 3, test : 4
            'rw' => random_int(1000, 9999), // max : 3, min : 3, test : 4
            'village' => Str::random(101), // max : 100, test : 101
            'district' => Str::random(101), // max : 100, test : 101
            'city' => Str::random(101), // max : 100, test : 101
            'postal_code' => random_int(100000, 999999), // max : 5, test : 6
            'phone' => '123456789012345', // max : 14, min : 9, test : 15
            'email' => Str::random(256), // max : 255, test : 256
            'password' => Str::random(256) // max : 255, test : 256
        ])
        ->call('create')
        ->assertHasFormErrors([
            'nik' => 'max_digits',
            'full_name' => 'max',
            'place_of_birth' => 'max',
            'date_of_birth' => 'date',
            'address' => 'max',
            'rt' => 'max_digits',
            'rw' => 'max_digits',
            'village' => 'max',
            'district' => 'max',
            'city' => 'max',
            'postal_code' => 'max_digits',
            'phone' => 'max_digits',
            'email' => 'max',
            'password' => 'max'
        ]);
});

test('customer resource : create customer has min errors', function () {
    livewire(CustomerResource\Pages\CreateCustomer::class)
        ->fillForm([
            'nik' => '123456789012345', // max : 16, min : 16, test : 17
            'full_name' => Str::random(100), // max : 100, test : 100
            'place_of_birth' => Str::random(50), // max : 50, test : 50
            'date_of_birth' => now()->toDateString(),
            'address' => Str::random(100), // max : 2000, test : 100
            'rt' => random_int(10, 99), // max : 3, min : 3, test : 2
            'rw' => random_int(10, 99), // max : 3, min : 3, test : 2
            'village' => Str::random(100), // max : 100, test : 100
            'district' => Str::random(100), // max : 100, test : 100
            'city' => Str::random(100), // max : 100, test : 100
            'postal_code' => random_int(1000, 9999), // max : 5, test : 4
            'phone' => '12345678', // max : 14, min : 9, test : 15
            'email' => fake()->email(), // max : 255
            'password' => Str::random(255) // max : 255, test : 255
        ])
        ->call('create')
        ->assertHasFormErrors([
            'phone' => 'min_digits',
            'nik' => 'min_digits',
            'rt' => 'min_digits',
            'rw' => 'min_digits',
            'postal_code' => 'min_digits',
        ]);
});
