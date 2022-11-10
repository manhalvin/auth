<?php

namespace Database\Seeders;

use App\Models\Modules;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class moduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modules::insert([
            ['name' => 'users', 'title' => 'Quản lý người dùng', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'groups', 'title' => 'Quản lý nhóm', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'posts', 'title' => 'Quản lý bài viết', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'books', 'title' => 'Quản lý người sách', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
