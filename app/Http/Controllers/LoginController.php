<?php

namespace App\Http\Controllers;

use App\Models\RegisteredUsers;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $attributes = $request->validate([
            "email"=>["required","max:255","email",],
            "password"=>["required","min:6","string"]
        ]);
       $roles=Role::all()->toArray();
       foreach($roles as $role){
            $role= "App\Models\\".$role["name"];
            $user=collect( $role::where("email",$attributes["email"])->first())->toArray();
            if($user){
                $rUser=RegisteredUsers::where("email",$attributes["email"])->first();
                if($rUser){
                    return response()->json([
                        "status"=>403,
                        "message"=>"Already exists"
                    ],403);
                }
                RegisteredUsers::create(["name"=>$user["name"],"surname"=>$user["surname"],"email"=>$user["email"],"password"=>$user["password"],"role_id"=>$user["role_id"]]);
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
        return response()->json([
            "status"=>404,
            "message"=>"Not Found"
        ],404);
    }
}
