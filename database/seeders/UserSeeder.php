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
            [
                'name' => 'User1',
                'level' => 'User',
                'no_hp' => '089966851111',
                'email' => 'u1@u1',
                'email_verified_at' => now(),
                'password' => bcrypt('qawsedrf'),
            ],
            [
                'name' => 'User2',
                'level' => 'User',
                'no_hp' => '089966851111',
                'email' => 'u2@u2',
                'email_verified_at' => now(),
                'password' => bcrypt('qawsedrf'),
            ],
        ]);
    }
}
