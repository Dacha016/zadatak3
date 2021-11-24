<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class RecruiterController extends Controller
{
    public function index(){
        if (Gate::allows('admin-recruiter')) {
            $recruiters=Recruiter::all();
            return response()->json([
                "status"=>200,
                "data"=>[
                    "recruiters"=>$recruiters
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
        if (Gate::allows('admin-recruiter')) {
            $recruiter=Recruiter::find($id);
            if(!$recruiter){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            return response()->json([
                "status"=>200,
                "data"=>[
                    "recruiter"=>$recruiter
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
        if (Gate::allows('admin')) {
            $attributes = $request->validate([
                "name"=>["required","string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "surname"=>["required","string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
                "city"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
                "email"=>["required","max:255","email"],
                "password"=>["required","min:6","string"]
            ]);
            $user=Recruiter::where("email",$attributes["email"])->first();
            if($user){
                return response()->json([
                    "status"=>403,
                    "message"=>"Email address already exists"
                ],403);
            }
            $attributes["password"]=Hash::make($attributes["password"]);
            $attributes["role_id"]=2;
            $recruiter= Recruiter::create($attributes);
            return response()->json([
                "status"=>201,
                "data"=>[
                    "recruiter"=>[
                        "name"=>$recruiter["name"],
                        "surname"=>$recruiter["surname"],
                        "email"=>$recruiter["email"]
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
    public function update(Request $request, $id ){
        if (Gate::allows('admin')) {
            $recruiter=Recruiter::find($id);
            if(!$recruiter){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            $attributes = $request->validate([
                "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "surname"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
                "city"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
                "email"=>["max:255","email"],
                "password"=>["min:6","string"]
            ]);
            if(!$recruiter){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            if(!$request->exists('password')){
                $recruiter->update($attributes);
                return response()->json([
                    "status"=>200,
                    "data"=>[
                        "recruiter"=>[
                            "name"=>$recruiter["name"],
                            "surname"=>$recruiter["surname"],
                            "email"=>$recruiter["email"]
                        ]
                    ]
                ],200);
            }
            $attributes["password"]=Hash::make($attributes["password"]);
            $recruiter->update($attributes);
            return response()->json([
                "status"=>201,
                "data"=>[
                    "recruiter"=>[
                        "name"=>$recruiter["name"],
                        "surname"=>$recruiter["surname"],
                        "email"=>$recruiter["email"]
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
    public function destroy($id){
        if (Gate::allows('admin')) {
            $recruiter=Recruiter::find($id);
            if(!$recruiter){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            if(!$recruiter){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            $recruiter->delete();
            return response()->json([
                "status"=>200,
                "message"=>"Recruiter is deleted"
            ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
        $recruiter=Recruiter::find($id);
        if(!$recruiter){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        if(!$recruiter){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $recruiter->delete();
        return response()->json([
            "status"=>200,
            "message"=>"Recruiter is deleted"
        ],200);
    }
}
