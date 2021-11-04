<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Group::truncate();
        Assignment::truncate();
        Role::truncate();

        Role::create(["name"=>"Admin"]);
        Role::create(["name"=>"Recruiter"]);
        Role::create(["name"=>"Mentor"]);
        User::create([
            "name"=>"Admin",
            "surname"=>"Admin",
            "email"=>"admin@gmail.com",
            "password"=>bcrypt("123456"),
            "role_id"=>1
        ]);


    }
}
