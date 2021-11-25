<?php

namespace App\Http\Controllers\Mentors;

use App\Http\Controllers\Controller;
use App\Models\GroupData;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    public function index(){
        if (Gate::allows('admin-recruiter-mentor')) {
            $mentors=Mentor::all();
            return response()->json([
                "status"=>200,
                "data"=>[
                    "mentors"=>$mentors
                ]
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
                "data"=>[
                    "mentor"=>$mentor
                ]
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
            $data=GroupData::rightjoin("mentors","group_data.mentor_id","=","mentors.id")
                ->where("mentors.id",$id)
                ->select(["mentors.name as mentor_name","mentors.surname as mentor_surname","mentors.city as mentor_city","mentors.skype as mentor_skype","mentors.email as mentor_email","mentors.password as mentor_password"])
                ->distinct()
                ->get();
            $mentor=collect($data)->toArray();
            if(!$mentor){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            $data=GroupData::join("groups","group_data.group_id","=","groups.id")
                ->join("mentors","group_data.mentor_id","=","mentors.id")
                ->where("mentors.id",$id)
                ->select(["groups.title as group_title"])
                ->distinct()
                ->get();
            $groups=collect($data)->toArray();

            $data=GroupData::join("interns","group_data.intern_id","=","interns.id")
                ->join("mentors","group_data.mentor_id","=","mentors.id")
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
                "name"=>["required","string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "surname"=>["required","string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
                "city"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
                "skype"=>["string","max:255"],
                "email"=>["required","max:255","email"],
                "password"=>["required","min:6","string"]
            ]);
            $user=Mentor::where("email",$attributes["email"])->first();
            if($user){
                return response()->json([
                    "status"=>403,
                    "message"=>"Email address already exists"
                ],403);
            }
            $attributes["password"]=Hash::make($attributes["password"]);
            $attributes["role_id"]=3;
            $mentor= Mentor::create($attributes);
            return response()->json([
                "status"=>201,
                "data"=>[
                    "mentor"=>[
                        "name"=>$mentor["name"],
                        "surname"=>$mentor["surname"],
                        "email"=>$mentor["email"],
                        "skype"=>$mentor["skype"],
                        "city"=>$mentor["city"]
                    ]
                ]
            ],201);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function update(Request $request, $id){
        if (Gate::allows('update-mentor',$id)) {
            $mentor=Mentor::find($id);
            if(!$mentor){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            $attributes = $request->validate([
                "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "surname"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
                "city"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
                "skype"=>["string","max:255"],
                "email"=>["max:255","email"],
                "password"=>["min:6","string"],
                "group_id"=>["numeric"],
            ]);
            if(!$request->exists('password')){
                $mentor->update($attributes);
                return response()->json([
                    "status"=>200,
                    "data"=>[
                        "mentor"=>[
                            "name"=>$mentor["name"],
                            "surname"=>$mentor["surname"],
                            "email"=>$mentor["email"],
                            "skype"=>$mentor["skype"],
                            "city"=>$mentor["city"]
                        ]
                    ]
                ],200);
            }
            $attributes["password"]=Hash::make($attributes["password"]);
            $mentor->update($attributes);
            return response()->json([
                "status"=>200,
                "data"=>[
                    "mentor"=>[
                        "name"=>$mentor["name"],
                        "surname"=>$mentor["surname"],
                        "email"=>$mentor["email"],
                        "skype"=>$mentor["skype"],
                        "city"=>$mentor["city"]
                    ]
                ]
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
