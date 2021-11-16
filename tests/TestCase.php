<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Admin;
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
              Recruiter::create(["name"=>"Sanja","surname"=>"Savic","email"=>"saki@gmail.com","password"=>Hash::make("123456"),"role_id"=>2]);
        }
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
              Mentor::create(["name"=>"Aleksandra","surname"=>"Ceranic","email"=>"alex@gmail.com","password"=>Hash::make("123456"),"role_id"=>3]);
        }
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
}

