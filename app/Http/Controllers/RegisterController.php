<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Database\Schema\ForeignKeyDefinition;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    protected $guarded=[];
    public function register(Request $request){




         $user= "App\\Models\\". $request["role"];
         $user= new $user;
         $user=$user::create($request->all());
        //  $token= $user->createToken("API Token")->plainTextToken;


        return response()->json([
            "status"=>201,
            "data"=>$user
        ]);
    }

}
