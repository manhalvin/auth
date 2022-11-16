<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call([
            BookTypeSeeder::class,
            BookSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PostSeeder::class,
            GroupPermissionSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class
        ]);
    }
}
