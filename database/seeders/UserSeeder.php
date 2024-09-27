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
            ]
        ]);
        // Create Users from User1 to User10
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
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
