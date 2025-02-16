<?php

use App\Filament\Clusters\Users\Resources\AdminUserResource;
use App\Models\User;
use function Pest\Livewire\livewire;
use Illuminate\Support\Str;

beforeEach(function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
});

test('create admin user resource : create has no errors', function () {
    livewire(AdminUserResource\Pages\ManageAdminUsers::class)
        ->callAction('create', [
            'avatar_url' => null,
            'name' => null,
            'email' => null,
            'password' => null
        ])
        ->assertHasActionErrors([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
});

test('create admin user resource : create has validation errors max', function () {
    livewire(AdminUserResource\Pages\ManageAdminUsers::class)
        ->callAction('create', [
            'avatar_url' => ['image.png'],
            'name' => Str::random(256),
            'email' => Str::random(256),
            'password' => Str::random(256)
        ])
        ->assertHasActionErrors([
            'name' => 'max',
            'email' => 'max',
            'password' => 'max'
        ]);
});

test('create admin user resource : create email has validation error unique', function () {
    livewire(AdminUserResource\Pages\ManageAdminUsers::class)
        ->callAction('create', [
            'avatar_url' => ['image.png'],
            'name' => fake()->name(),
            'email' => 'admin@gmail.com',
            'password' => Str::random(10)
        ])
        ->assertHasActionErrors([
            'email' => 'unique'
        ]);
});

test('create admin user resource : create email has validation error valid email', function () {
    livewire(AdminUserResource\Pages\ManageAdminUsers::class)
        ->callAction('create', [
            'avatar_url' => ['image.png'],
            'name' => fake()->name(),
            'email' => 'admin',
            'password' => Str::random(10)
        ])
        ->assertHasActionErrors([
            'email' => 'email'
        ]);
});

test('create admin user resource : create password has validation error min', function () {
    livewire(AdminUserResource\Pages\ManageAdminUsers::class)
        ->callAction('create', [
            'avatar_url' => ['image.png'],
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => Str::random(4)
        ])
        ->assertHasActionErrors([
            'password' => 'min'
        ]);
});
