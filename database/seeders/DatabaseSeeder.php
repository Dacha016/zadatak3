<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Assignment;
use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Role;
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
        Intern::truncate();
        Mentor::truncate();
        Group::truncate();
        Assignment::truncate();
        Role::truncate();
        Admin::truncate();

        Role::create(["name"=>"Admin"]);
        Role::create(["name"=>"Recruiter"]);
        Role::create(["name"=>"Mentor"]);
        Admin::create([
            "name"=>"Admin",
            "surname"=>"Admin",
            "email"=>"admin@gmail.com",
            "password"=>bcrypt("123456"),
            "role_id"=>1
        ]);

    }
}
