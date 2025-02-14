<?php

use App\Models\User;

it('can login as admin', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    $response = $this->get('/admin');

    $response->assertStatus(200);
});

it('can login as management', function () {
    $user = User::factory()->management()->create();
    $this->actingAs($user);

    $response = $this->get('/admin');

    $response->assertStatus(200);
});

it('can login as customer', function () {
    $user = User::factory()->customer()->create();
    $this->actingAs($user);

    $response = $this->get('/');

    $response->assertStatus(200);
});
