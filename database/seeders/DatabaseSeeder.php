<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //create admin
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'password' => "12345678",
            'email' => 'admin@example.com',
            'role'  => UserRoleEnum::ADMIN
        ]);

        \App\Models\User::factory()->create([
            'name' => 'waiter',
            'password' => "12345678",
            'email' => 'waiter@example.com',
            'role'  => UserRoleEnum::WAITER
        ]);

        \App\Models\User::factory()->create([
            'name' => 'customer',
            'password' => "12345678",
            'email' => 'customer@example.com',
            'role'  => UserRoleEnum::CUSTOMER
        ]);

        $this->call(MealsTableSeeder::class);
    }
}
