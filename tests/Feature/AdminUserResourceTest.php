<?php

use App\Filament\Clusters\Users\Resources\AdminUserResource;
use App\Models\User;
use function Pest\Livewire\livewire;

test('create admin user resource : create has no errors', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

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
