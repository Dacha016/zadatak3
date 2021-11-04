<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){

        if(!Auth::check()){
            $attributes = $request->validate([
                "email"=>["required","max:255","email",],
                "password"=>["required","min:6","string"]
            ]);
             $user=User::where("email",$attributes["email"])->first();

            Auth::attempt(['email' => $attributes["email"], 'password' => $attributes["password"]]);

            if(!$user ){
                return response()->json([
                    "status"=>401,
                    "message"=>"Credentilans not match"
                ],401);
            }
            $token=$user->createToken("Api Token")->plainTextToken;
            return response()->json([
                "status"=>200,
                "data"=>[
                    "user"=>  Auth::user(),
                    "token"=>$token
                ]
            ]);
        }
        return response()->json([
            "status"=>403,
            "message"=>"Forbidden"

        ],403);
    }
}
