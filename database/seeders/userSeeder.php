<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            ['name' => 'Quốc Mạnh','email' => 'quocmanh1998s@gmail.com','password' => Hash::make(123456789),'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['name' => 'Quốc Việt','email' => 'vietquoc2001s@gmail.com','password' => Hash::make(123456789),'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
        ]);
    }
}
