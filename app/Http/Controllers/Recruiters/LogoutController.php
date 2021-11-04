<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Models\Recruiter;
use App\Models\RegisteredUsers;
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

        $user=Recruiter::where("email",$request["email"])->first();
        if(!$user){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        };

        if(Auth::check()){
            $rUser=RegisteredUsers::where("email",Auth::user()->email)->first();
            $rUser->delete();
            Auth::user()->tokens->each(function($token, $key) {
                $token->delete();
            });
        }

        return response()->json(["You are logged out"]);
    }
}
