<?php

namespace Database\Seeders;

use App\Models\Groups;
use App\Models\Modules;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class groupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Groups::insert([
            ['name' => 'Administrator','permissions' => '{"users":["view","add","edit","delete","detail"],"groups":["view","add","edit","delete","detail","permission"],"posts":["view","add","edit","delete","detail"]}','user_id'=> 4,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['name' => 'Super Administrator','permissions' => '{"users":["view","add","edit","delete"],"groups":["view","add","edit","delete","detail","permission"],"posts":["view","add","detail"]}','user_id'=>5,'created_at' => Carbon::now(),'updated_at' => Carbon::now()]
        ]);
    }
}
