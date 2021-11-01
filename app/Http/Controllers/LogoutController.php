<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LogoutController extends Controller
{
    public function logout(Request $request){

        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        }elseif($request->header('Authorization')===null){
            return response()->json('Bad token');
        }

        $attributes = $request->validate([
            "email"=>["required","max:255","email",],
            "password"=>["required","min:6","string"]
        ]);
        $user=User::where("email",$attributes["email"])->first();
        if(!$user){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        };
        Auth::loginUsingId($user->id);
        // $token=explode(" ",$request->header('Authorization'));
        dd(Auth::user()->tokens->fin);
        // if($token[1]!== Auth::user()->tokens ){
        //     return response()->json('Bad token!');
        // }



        Auth::user()->tokens->each(function($token, $key) {
            $token->delete();
        });


        return response()->json(["You are logput"]);
    }
}
