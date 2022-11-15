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
        DB::table('role_permissions')->insert([
            ['permission_id' => 17, 'role_id' => 1 ,'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 18, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 19, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 20, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()]
        ]);
    }
}
