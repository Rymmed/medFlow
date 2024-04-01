<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            "role_id" => "1",
            "name" => "Admin",
            "email" => "admin@softui.com",
            "password" => bcrypt("pass@admin"),
        ]);

        DB::table("users")->insert([
            "role_id" => "2",
            "name" => "Patient",
            "email" => "patient@gmail.com",
            "password" => bcrypt("pass@patient"),
        ]);

        DB::table("users")->insert([
            "role_id" => "3",
            "name" => "Doctor",
            "email" => "doctor@gmail.com",
            "password" => bcrypt("pass@doctor"),
        ]);
        DB::table("users")->insert([
            "role_id" => "4",
            "name" => "Assistant",
            "email" => "assistant@gmail.com",
            "password" => bcrypt("pass@assistant"),
        ]);
    }
}
