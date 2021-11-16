<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Admin;
use App\Models\Assignment;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Recruiter;
use App\Models\RegisteredUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public function admin_login()
    {
        $admin=collect( Admin::find(1))->toArray();
        $user=RegisteredUsers::where(["email"=>$admin["email"]])->first();
        if(!$user){
            $user=RegisteredUsers::create(["name"=>$admin["name"],"surname"=>$admin["surname"],"email"=>$admin["email"],"password"=>Hash::make($admin["password"]),"role_id"=>$admin["role_id"]]);
        }
        $this->post("api/login",[
        "email"=>$user["email"],
        "password"=>$user["password"]
        ]);
        Auth::loginUsingId($user->id);
        $token=$user->createToken("api-token")->plainTextToken;
        return["Authorization"=>$token, "Accept"=>"application/json"];
    }

    public function create_recruiter(){
        $this->admin_login();
        $recruiter= Recruiter::find(1);
        if(!$recruiter){
             $recruiter= Recruiter::create(["name"=>"Sanja","surname"=>"Savic","email"=>"saki@gmail.com","password"=>Hash::make("123456"),"role_id"=>2]);
        }
        return $recruiter->toArray();
    }

    public function recruiter_login()
    {
        $this->create_recruiter();
        $recruiter=collect( Recruiter::find(1))->toArray();
        $user=RegisteredUsers::where(["email"=>$recruiter["email"]])->first();
        if(!$user){
            $user=RegisteredUsers::create(["name"=>$recruiter["name"],"surname"=>$recruiter["surname"],"email"=>$recruiter["email"],"password"=>$recruiter["password"],"role_id"=>$recruiter["role_id"]]);
        }
        $this->post("api/login",[
        "email"=>$user["email"],
        "password"=>$user["password"]
        ]);
        Auth::loginUsingId($user->id);
        $token=$user->createToken("api-token")->plainTextToken;
        return["Authorization"=>$token, "Accept"=>"application/json"];
    }

    public function create_mentor(){
        $this->admin_login();
        $mentor= Mentor::find(1);
        if(!$mentor){
            $mentor=  Mentor::create(["name"=>"Aleksandra","surname"=>"Ceranic","email"=>"alex@gmail.com","password"=>Hash::make("123456"),"role_id"=>3]);
        }
        return $mentor->toArray();
    }

    public function mentor_login()
    {
        $this->create_mentor();
        $mentor=collect( Mentor::find(1))->toArray();
        $user=RegisteredUsers::where(["email"=>$mentor["email"]])->first();
        if(!$user){
            $user=RegisteredUsers::create(["name"=>$mentor["name"],"surname"=>$mentor["surname"],"email"=>$mentor["email"],"password"=>$mentor["password"],"role_id"=>$mentor["role_id"]]);
        }
        $this->post("api/login",[
        "email"=>$user["email"],
        "password"=>$user["password"]
        ]);
        Auth::loginUsingId($user->id);
        $token=$user->createToken("api-token")->plainTextToken;
        return["Authorization"=>$token, "Accept"=>"application/json"];
    }
    public function create_intern(){
        $this->admin_login();
        $intern= Intern::find(1);
        if(!$intern){
            $intern=  Intern::create(["name"=>"Ivana","surname"=>"Orlovic","email"=>"ika@gmail.com","role_id"=>4]);
        }
        return $intern->toArray();
    }
    public function create_assignment(){
        $this->admin_login();
        $assignment= Assignment::find(1);
        if(!$assignment){
             $assignment= Assignment::create(["title"=>"Learning Laravel","description"=>"Implement OOP in Laravel"]);
        }

        return $assignment=$assignment->toArray();
    }
}

