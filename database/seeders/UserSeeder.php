<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'username' => 'Admin',
                'password' => Hash::make('admin123'),
                'level' => 'super',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Editor',
                'password' => Hash::make('editor123'),
                'level' => 'editor',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
