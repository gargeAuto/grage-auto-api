<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class); //id 1
        $this->call(EngineerSeeder::class);// id 2
        $this->call(UserSeeder::class);// id 3
        $this->call(AdminUserSeeder::class);

        User::factory(50)->create();
    }
}
