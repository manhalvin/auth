<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for ($i = 3; $i < 300; $i++) {
        //     User::create([
        //         'name' => 'idName ' . $i,
        //         'email' => 'demo'. $i.'@gmail.com',
        //         'password' => bcrypt(123456789),
        //         'group_id' => rand(1, 3),
        //         'status' => rand(0,1)
        //     ]);
        // }

        User::insert([
            [
                'name' => 'Quốc Mạnh',
                'email' => 'quocmanh1998s@gmail.com',
                'password' => bcrypt('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Quốc Việt',
                'email' => 'quocviet2001s@gmail.com',
                'password' => bcrypt('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
        ]);
    }
}
