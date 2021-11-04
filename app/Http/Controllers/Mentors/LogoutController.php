<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use App\Models\RegisteredUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $guarded=[];


    public function logout(Request $request){

        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        }elseif($request->header('Authorization')===null){
            return response()->json('Bad token');
        }

        if(Auth::check()){
            return response()->json(["You are already logged in"]);
        }

        $user=Mentor::where("email",$request["email"])->first();
        if(!$user){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        };

        if(Auth::check()){
            Auth::user()->tokens->each(function($token, $key) {
                $rUser=RegisteredUsers::where("email",Auth::user()->email)->first();
                $rUser->delete();
                $token->delete();
            });
        }
        return response()->json(["You are logged out"]);
    }
}
