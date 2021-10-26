<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    protected $guarded=[];
    public function register(Request $request){
        if($request["role"]!=="Admin"){
            $user= "App\\Models\\". $request["role"];
        $userClass= new $user;
        $user=$userClass::create($request->all());
        User::create($request->all());
        $token= $user->createToken("Api Token")->plainTextToken;
        return response()->json([
            "status"=>201,
            "user"=>$user,
            "data"=>$token
        ]);
        }else{
            $user= "App\\Models\\". $request["role"];
            $userClass= new $user;
            $user=$userClass::create($request->all());
            return response()->json([
                "status"=>201,
                "user"=>$user
            ]);
        }

    }


}
