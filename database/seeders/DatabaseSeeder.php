<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
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

        $intern = Intern::factory()->create();
        $mentor = Mentor::factory(2)->create();
        // $php = Group::create([
        //     "title"=>"PHP"
        // ]);
        // $js = Group::create([
        //     "title"=>"JAVASCRIPT"
        // ]);
        // $java = Group::create([
        //     "title"=>"JAVA"
        // ]);
        $assignment = Assignment::factory()->create();
    }
}
