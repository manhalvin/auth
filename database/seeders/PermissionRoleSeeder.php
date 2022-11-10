<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->insert([
            ['permission_id' => 6, 'role_id' => 1 ,'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 7, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 8, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 9, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 10, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()],
        ]);
    }
}
