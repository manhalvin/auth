<?php

namespace Database\Seeders;

use App\Models\Modules;
use App\Models\Posts;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class postSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Posts::insert([
            ['title' => 'Title 1','content' => 'Content 1','status' => 0,'book_id' => 1,'user_id' => 4,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 2','content' => 'Content 2','status' => 1,'book_id' => 1,'user_id' => 4,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 3','content' => 'Content 3','status' => 1,'book_id' => 2,'user_id' => 5,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 4','content' => 'Content 4','status' => 1,'book_id' => 2,'user_id' => 4,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 5','content' => 'Content 5','status' => 1,'book_id' => 3,'user_id' => 4,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 6','content' => 'Content 6','status' => 1,'book_id' => 4,'user_id' => 4,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Title 7','content' => 'Content 7','status' => 1,'book_id' => 5,'user_id' => 5,'created_at' => Carbon::now(),'updated_at' => Carbon::now()]
        ]);
    }
}
