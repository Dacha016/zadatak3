<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Mentor;
use App\Models\Recruiter;
use App\Models\RegisteredUsers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){


        $attributes = $request->validate([
            "email"=>["required","max:255","email",],
            "password"=>["required","min:6","string"],
            "role_id"=>["required"],
        ]);


         if($attributes["role_id"]==1){
            $user=Admin::where("email",$attributes["email"])->first();
         }
         if($attributes["role_id"]==2){
            $user=Recruiter::where("email",$attributes["email"])->first();
        }
        if($attributes["role_id"]==3){
            $user=Mentor::where("email",$attributes["email"])->first();
        }
        if(!$user ){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        }
        RegisteredUsers::create(["name"=>$user->name,"surname"=>$user->surname,"email"=>$user->email,"password"=>$user->password,"role_id"=>$user->role_id]);
         $user=RegisteredUsers::where("email",$attributes["email"])->first();
        Auth::loginUsingId($user->id);
         $token=$user->createToken("Api Token")->plainTextToken;



        return response()->json([
            "status"=>200,
            "data"=>[
                "user"=>Auth::user(),
                "token"=>$token
            ],

        ],200);
    }
}
