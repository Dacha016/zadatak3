<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;




class LoginController extends RegisterController
{
    public function login(Request $request){

        $attributes = $request->validate([
            "email"=>["required","max:255","email",],
            "password"=>["required","min:6","string"]
        ]);
        if($user = User::where("email",$attributes["email"])->first()){
            return response()->json([
                "status"=>200,
                "data"=>[
                    "user"=>$user
                ]
            ]);
        }
        if($user = Admin::where("email",$attributes["email"])->first()){
            return response()->json([
                "status"=>200,
                "data"=>[
                    "user"=>$user
                ]
            ]);
        }
        if(!$user ){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        }
    }
}
