<?php

namespace App\Http\Controllers;

use App\Models\RegisteredUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    protected $guarded=[];
    public function logout(Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        if(Auth::check()){
            $user=RegisteredUsers::where("email",Auth::user()->email)->first();
            $user->delete();
            Auth::user()->tokens->each(function($token, $key) {
                $token->delete();
            });
        }
        return response()->json([
            "status"=>200,
            "message"=>"You are logged out"
        ],200);
    }
}
