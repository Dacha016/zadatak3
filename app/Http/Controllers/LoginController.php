<?php

namespace App\Http\Controllers;

use App\Models\LoggedInUser;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                     if(!Hash::check($attributes["password"], $user["password"])){
                        return response()->json([
                            "status"=>422,
                            "message"=>"Wrong password"
                        ],422);
                     }
                    $rUser=LoggedInUser::where("email",$attributes["email"])->first();
                    if($rUser){
                        return response()->json([
                            "status"=>403,
                            "message"=>"Already exists"
                        ],403);
                    }
                    LoggedInUser::create(["name"=>$user["name"],"surname"=>$user["surname"],"email"=>$user["email"],"password"=>$user["password"],"role_id"=>$user["role_id"]]);
                    $user=LoggedInUser::where("email",$attributes["email"])->first();
                   $loggedUser= Auth::loginUsingId($user->id);
                    $token=$user->createToken("Api Token")->plainTextToken;
                    return response()->json([
                        "status"=>200,
                        "data"=>[
                            "logged_user"=>[
                            "name"=>$loggedUser["name"],
                            "surname"=>$loggedUser["surname"],
                            "email"=>$loggedUser["email"]
                        ],
                            "token"=>$token
                        ],
                    ],200);
                }
            }
            return response()->json([
                "status"=>404,
                "message"=>"Wrong email address"
            ],404);
        }

}
