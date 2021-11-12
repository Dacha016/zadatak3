<?php

namespace App\Http\Controllers\Interns;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;

class InternController extends Controller
{
    public function index(Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $intern=Intern::all();
        return response()->json([
            "status"=>200,
            "data"=>$intern
        ],200);
    }
    public function show($id,Intern $intern, Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $intern=Intern::find($id);
        if(!$intern){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $intern=Intern::leftjoin("groups","groups.id","=","interns.group_id")
        ->leftjoin("assignments","assignments.id","=","interns.assignment_id")
        ->where("interns.id","$id")
        ->get(["interns.name","interns.surname","interns.city","interns.address","interns.email","interns.phone","interns.CV","interns.gitHub","groups.title as group_title","assignments.title as assignment_title"]);
        return response()->json([
            "status"=>200,
            "data"=>$intern
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
            "adderss"=>["string","max:255"],
            "email"=>["required","max:255","email"],
            "phone"=>["string","max:50"],
            "CV"=>["string"],
            "gitHub"=>["url"],
            "mentor_id"=>["numeric"],
            "group_id"=>["numeric"],
            "assignment_id"=>["numeric"],
        ]);
        $user=Intern::where("email",$attributes["email"])->first();
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
        $attributes["role_id"]=4;
        $intern= Intern::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$intern
        ],201);
    }
    public function update(Request $request, $id ){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $intern=Intern::find($id);
        if(!$intern){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $attributes = $request->validate([
            "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "surname"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "city"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "adderss"=>["string","max:255"],
            "email"=>["max:255","email"],
            "phone"=>["string","max:50"],
            "CV"=>["string"],
            "gitHub"=>["string"],
            "mentor_id"=>["numeric"],
            "group_id"=>["numeric"],
            "assignment_id"=>["numeric"],
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $attributes["role_id"]=4;
        $intern->update($attributes);
        return response()->json([
            "status"=>200,
            "data"=>"$intern"
        ],200);
    }
    public function destroy( Request $request,$id){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $intern=Intern::find($id);
        if(!$intern){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $intern->delete();
        return response()->json([
            "status"=>200,
            "message"=>"Intern is deleted"
        ],200);
    }
}
