<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;


class MentorController extends Controller
{

    public function index(){
            return response()->json(Mentor::get(),200);
    }
    public function show($id,Mentor $mentor){
            return response()->json(Mentor::find($id),200);
    }
    public function store(Request $request ){
        $attributes = $request->validate([
            "name"=>["string","max:255","alpha"],
            "surname"=>["string","max:255","alpha"],
            "city"=>["string","max:255","alpha"],
            "skype"=>["string","max:255","alpha_num"],
            "email"=>["required","max:255","email"],
            "password"=>["required","min:6","string"],
            "role_id"=>["required","numeric"]

        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"

            ],422);
        }

            $mentor= Mentor::create($attributes);
            return response()->json($mentor,200);
    }
    public function update(Request $request, Mentor $mentor ){
        $attributes = $request->validate([
            "name"=>["string","max:255","alpha"],
            "surname"=>["string","max:255","alpha"],
            "city"=>["string","max:255","alpha"],
            "skype"=>["string","max:255","alpha_num"],
            "email"=>["max:255","email"],
            "password"=>["min:6","string"],
            "role_id"=>["numeric"]

        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"

            ],422);
        }

        $mentor->update($attributes);
        return response()->json($mentor,200);
    }
    public function destroy( Mentor $mentor){
        $mentor->delete();
        return response()->json(null, 204);
    }
}
