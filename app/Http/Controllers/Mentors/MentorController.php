<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    public function index(Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $mentor=Mentor::all();
        return response()->json([
            "status"=>200,
            "data"=>$mentor
        ],200);
    }
    public function show($id,Mentor $mentor, Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $mentor=Mentor::find($id);
        if(!$mentor){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $mentor=Mentor::leftjoin("groups","groups.id","=","mentors.group_id")
        ->leftjoin("interns","interns.mentor_id","=","mentors.id")
        ->where("mentors.id","$id")
        ->get(["mentors.name","mentors.surname","mentors.city","mentors.skype","interns.name as intern_name","interns.surname as intern_surname","groups.title as group_title"]);

        return response()->json([
            "status"=>200,
            "data"=>$mentor
        ],200);
    }
    public function store(Request $request ){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $attributes = $request->validate([
            "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "surname"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "city"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "skype"=>["string","max:255"],
            "email"=>["required","max:255","email"],
            "password"=>["required","min:6","string"],
            "group_id"=>["numeric"],
        ]);
        $user=Mentor::where("email",$attributes["email"])->first();
        if($user){
            return response()->json([
                "status"=>403,
                "message"=>"Already exists"
            ],403);
        }
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $attributes["password"]=Hash::make($attributes["password"]);
        $attributes["role_id"]=3;
        $mentor= Mentor::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$mentor
        ],201);
    }
    public function update(Request $request, $id){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $mentor=Mentor::find($id);
        if(!$mentor){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $attributes = $request->validate([
            "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "surname"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "city"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "skype"=>["string","max:255"],
            "email"=>["max:255","email"],
            "password"=>["min:6","string"],
            "group_id"=>["numeric"],
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        if(!$request->exists('password')){
            $mentor->update($attributes);
            return response()->json([
                "status"=>200,
                "data"=>$mentor
            ],200);
        }
        $attributes["password"]=Hash::make($attributes["password"]);
        $attributes["role_id"]=3;
        $mentor->update($attributes);
        return response()->json([
            "status"=>200,
            "data"=>$mentor
        ],200);
    }
    public function destroy( Request $request,$id){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $mentor=Mentor::find($id);
        if(!$mentor){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $mentor->delete();
        return response()->json([
            "status"=>200,
            "message"=>"Mentor is deleted"
        ],200);
    }
}
