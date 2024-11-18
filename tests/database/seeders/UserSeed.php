<?php

namespace TomatoPHP\FilamentAlerts\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use TomatoPHP\FilamentAlerts\Tests\Models\User;

class UserSeed extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Fady Mondy',
            'email' => 'info@3x1.io',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
}
