<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    protected $guarded=[];
    public function register(Request $request){

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
    }
}
