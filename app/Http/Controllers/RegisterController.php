<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $guarded=[];
    public function register(Request $request){
        $attributes = $request->validate([
            "name"=>["string","max:255","alpha"],
            "surname"=>["string","max:255","alpha"],
            "city"=>["string","max:255","alpha"],
            "address"=>["string","max:255","alpha_num"],
            "skype"=>["string","max:255","alpha_num"],
            "email"=>["required","max:255","email"],
            "password"=>["required","min:6","string"],
            "phone"=>["string","max:50"],
            "CV"=>"string",
            "gitHub"=>["string","alpha_num"],
            "role_id"=>["required","numeric"],
            "mentor_id"=>["required","numeric"],
            "intern_id"=>["required","numeric"],
            "group_id"=>["required","numeric"],
            "assignment_id"=>["required","numeric"],
        ]);
            $user=User::create($attributes);

        return response()->json([
            "status"=>201,
            "user"=>$user,

        ],201);
    }


}
