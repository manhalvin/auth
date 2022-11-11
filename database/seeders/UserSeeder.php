<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        for ($i = 1; $i < 25; $i++) {
//            User::create(
//                [
//                'name' => 'dem ' . $i,
//                'email' => 'demo' . $i . '@gmail.com',
//                'password' => bcrypt(123456789),
//                'status' => rand(0, 1),
//                'created_at' => now(),
//                'updated_at' => now(),
//                'email_verified_at' => now()
//            ]);
//        }

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
