<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        User::unsetEventDispatcher();

        $this->seed([RoleSeeder::class]);
    }
}
