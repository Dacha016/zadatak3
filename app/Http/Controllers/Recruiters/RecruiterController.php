<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Models\Recruiter;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    public function index(Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $recruiter=Recruiter::all();
        return response()->json([
            "status"=>200,
            "data"=>$recruiter
        ],200);
    }
    public function show($id,Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $recruiter=Recruiter::find($id);
        return response()->json([
            "status"=>200,
            "data"=>$recruiter
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
            "name"=>["string","max:255"],
            "surname"=>["string","max:255"],
            "city"=>["string","max:255"],
            "skype"=>["string","max:255"],
            "email"=>["required","max:255","email"],
            "password"=>["required","min:6","string"]
        ]);
        $user=Recruiter::where("email",$attributes["email"])->first();
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
        $attributes["password"]=bcrypt($attributes["password"]);
        $attributes["role_id"]=2;
        $recruiter= Recruiter::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$recruiter
        ],201);
    }
    public function update(Request $request, Recruiter $recruiter ){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $attributes = $request->validate([
            "name"=>["string","max:255",],
            "surname"=>["string","max:255",],
            "city"=>["string","max:255",],
            "skype"=>["string","max:255"],
            "email"=>["max:255","email"],
            "password"=>["min:6","string"]
        ]);
        $user=Recruiter::where("email",$attributes["email"])->first();
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
        if(!$request->exists('password')){
            $recruiter->update($attributes);
            return response()->json([
                "status"=>200,
                "data"=>$recruiter
            ],200);
        }
        $attributes["password"]=bcrypt($attributes["password"]);
        $attributes["role_id"]=2;
        $recruiter->update($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$recruiter
        ],201);
    }
    public function destroy( Recruiter $recruiter, Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $recruiter->delete();
        return response()->json([
            "status"=>200,
            "message"=>"Recruiter is deleted"
        ],200);
    }
}
