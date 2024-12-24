<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'level' => 'Admin',
                'no_hp' => '089966851111',
                'email' => 's@s',
                'email_verified_at' => now(),
                'password' => bcrypt('qawsedrf'),
            ],
            // [
            //     'name' => 'User 1',
            //     'level' => 'User',
            //     'no_hp' => '089966851111',
            //     'email' => 'pu1@pu',
            //     'email_verified_at' => now(),
            //     'password' => bcrypt('p@upp'),
            // ],
            // [
            //     'name' => 'User 2',
            //     'level' => 'User',
            //     'no_hp' => '089966851111',
            //     'email' => 'uss@uss',
            //     'email_verified_at' => now(),
            //     'password' => bcrypt('p@uss'),
            // ],
            // [
            //     'name' => 'User 3',
            //     'level' => 'User',
            //     'no_hp' => '089966851111',
            //     'email' => 'pu3@pu',
            //     'email_verified_at' => now(),
            //     'password' => bcrypt('p3@upp'),
            // ],
        ]);
        // Create Users from User1 to User10
        $users = [];
        for ($i = 1; $i <= 3; $i++) {
            $users[] = [
                'name' => 'User ' . $i,
                'level' => 'User',
                'no_hp' => '08996685000' . $i,
                'email' => 'u' . $i . '@u' . $i,
                'email_verified_at' => now(),
                'password' => bcrypt('qawsedrf'),
            ];
        }

        // Insert all users at once
        DB::table('users')->insert($users);
    }
}
