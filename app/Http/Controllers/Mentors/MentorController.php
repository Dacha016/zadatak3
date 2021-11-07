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
        $mentor=Mentor::leftjoin("groups","groups.id","=","mentors.group_id")
        ->rightjoin("interns","interns.mentor_id","=","mentors.id")
        ->where("mentors.id","$id")
        ->get(["mentors.name","mentors.surname","mentors.city","mentors.skype","interns.name as intern_name","interns.surname as intern_surname","groups.title as group_title"]);
        return response()->json([
            "status"=>200,
            "data"=>"$mentor"
        ],200);
    }
    public function store(Request $request ){
        $attributes = $request->validate([
            "name"=>["string","max:255"],
            "surname"=>["string","max:255"],
            "city"=>["string","max:255"],
            "skype"=>["string","max:255"],
            "email"=>["required","max:255","email"],
            "password"=>["required","min:6","string"],
            "role_id"=>["required","numeric"],
            "group_id"=>["numeric"],
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
            "role_id"=>["numeric"],
            "group_id"=>["numeric"],
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"

            ],422);
        }

        $mentor->update($attributes);
        return response()->json([
            "status"=>200,
            "data"=>"$mentor"
        ],200);
    }
    public function destroy( Mentor $mentor){
        $mentor->delete();
        return response()->json(null, 204);
    }
}
