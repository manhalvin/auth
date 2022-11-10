<?php

namespace Database\Seeders;

use App\Models\Books;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Books::insert([
            ['title' => 'Title 1','content' => 'Content 1','type_id' => 1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 2','content' => 'Content 2','type_id' => 1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 3','content' => 'Content 3','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 4','content' => 'Content 4','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 5','content' => 'Content 5','type_id' => 3,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 6','content' => 'Content 6','type_id' => 4,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 7','content' => 'Content 7','type_id' => 5,'created_at' => Carbon::now(),'updated_at' => Carbon::now()]
        ]);
    }
}
