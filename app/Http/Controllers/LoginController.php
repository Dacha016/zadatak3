<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends RegisterController
{
    public function login(Request $request){

        $attributes = $request->validate([
            "email"=>["required","max:255","email",],
            "password"=>["required","min:6","string"]
        ]);
        $user = User::where("email",$attributes["email"])->first();
        $token= $user-> createToken("API Token")->plainTextToken;
        if(!$user ){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        }

        return response()->json([
            "status"=>200,
            "data"=>[
                "user"=>$user,
                "token"=>$token
            ]
        ]);
    }
}
