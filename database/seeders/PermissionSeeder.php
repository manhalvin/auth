<?php

namespace Database\Seeders;

use App\Models\Permissions;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permissions::insert([
            ['title' => 'review_post', 'created_at' => now(),
                'updated_at' => now()],
            ['title' => 'update_post', 'created_at' => now(),
                'updated_at' => now()],
            ['title' => 'delete_post', 'created_at' => now(),
                'updated_at' => now()],
            ['title' => 'restore_post', 'created_at' => now(),
                'updated_at' => now()],
            ['title' => 'force_delete_post', 'created_at' => now(),
                'updated_at' => now()],
        ]);
    }
}
