<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Group;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    public function index(){
        if (Gate::allows('admin-recruiter-mentor')) {
            $mentor=Mentor::all();
            return response()->json([
                "status"=>200,
                "data"=>$mentor
            ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function show($id){
        if (Gate::allows('admin-recruiter-mentor')) {
            $mentor=Mentor::find($id);
            if(!$mentor){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            return response()->json([
                "status"=>200,
                "data"=>$mentor
            ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function profile($id){
        if (Gate::allows('admin-recruiter-mentor')) {
            $data=Data::rightjoin("mentors","data.mentor_id","=","mentors.id")
            ->where("mentors.id",$id)
            ->select(["mentors.name as mentor_name","mentors.surname as mentor_surname","mentors.city as mentor_city","mentors.skype as mentor_skype","mentors.email as mentor_email","mentors.password as mentor_password"])
            ->distinct()
            ->get();
        $mentor=collect($data)->toArray();

        $data=Data::join("groups","data.group_id","=","groups.id")
            ->join("mentors","data.mentor_id","=","mentors.id")
            ->where("mentors.id",$id)
            ->select(["groups.title as group_title"])
            ->distinct()
            ->get();
        $groups=collect($data)->toArray();

        $data=Data::join("interns","data.intern_id","=","interns.id")
            ->join("mentors","data.mentor_id","=","mentors.id")
            ->where("mentors.id",$id)
            ->select(["interns.name as intern_name","interns.surname as intern_surname"])
            ->distinct()
            ->get();
        $interns=collect($data)->toArray();
        return response()->json([
            "status"=>200,
            "data"=>[
                "mentor"=>$mentor,
                "groups"=>$groups,
                "interns"=>$interns
                ]
        ],200);

        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function store(Request $request ){
        if (Gate::allows('admin-recruiter')) {
            $attributes = $request->validate([
                "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "surname"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "city"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "skype"=>["string","max:255"],
                "email"=>["required","max:255","email"],
                "password"=>["required","min:6","string"],
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
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function update(Request $request, $id){
        if (Gate::allows('admin-recruiter')) {
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
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function destroy($id){
        if (Gate::allows('admin-recruiter')) {
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
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
}
