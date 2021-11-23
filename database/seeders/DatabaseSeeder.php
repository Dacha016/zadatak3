<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(["name"=>"Admin"]);
        Role::create(["name"=>"Recruiter"]);
        Role::create(["name"=>"Mentor"]);
        Role::create(["name"=>"Intern"]);
        Admin::create([
            "name"=>"Admin",
            "surname"=>"Admin",
            "email"=>"admin@gmail.com",
            "password"=>Hash::make("123456"),
            "role_id"=>1
        ]);
    }
}
