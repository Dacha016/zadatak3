<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mentor;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    protected $guarded=[];
    public function register(Request $request){

        if($request["role_id"]==1){
           $user=Admin::create($request->all());
        }elseif($request["role_id"]==2){
            $user=Recruiter::create($request->all());
        }elseif($request["role_id"]==3){
            $user=Mentor::create($request->all());
        }

        User::create($request->all());

        return response()->json([
            "status"=>201,
            "user"=>$user,

        ],201);
    }




    public function loggedUser(Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Credentilans not match"
            ],401);
        }
       $r= $request->header('Authorization');
        $s= explode(" ",$r);
        $user=User::where("api_token",$s[1])->first();
        Auth::loginUsingId($user->id);

        if(Auth::user() ==null){

            return response()->json('You are not logged in');
        };
        return response()->json(['message'=>Auth::user()]);
    }
}
