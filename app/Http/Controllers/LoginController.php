<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends RegisterController
{
    public function login(Request $request){
        // if(!$request->header('Authorization')){
        //     return response()->json([
        //         "status"=>401,
        //         "message"=>"Credentilans not match"
        //     ],401);
        // }
        $attributes = $request->validate([
            "email"=>["required","max:255","email",],
            "password"=>["required","min:6","string"]
        ]);
        $user=User::where("email",$attributes["email"])->first();

        Auth::loginUsingId($user->id);
        if(!$user ){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        }
         $token=$user->createToken("Api Token")->plainTextToken;
        // $request["api_token"]=$token;


        return response()->json([
            "status"=>200,
            "data"=>[
                "user"=>  Auth::user(),
                "token"=>$token
            ]
        ]);
    }
}
