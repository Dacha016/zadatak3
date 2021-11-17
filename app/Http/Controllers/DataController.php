<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Data;
use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DataController extends Controller
{
    public function store(Request $request ){
        if (Gate::allows('admin-recruiter-mentor')) {
            if($request->exists("mentor_id")){
                $mentor= Mentor::find($request["mentor_id"]);
                if(!$mentor){
                    return response()->json([
                        "status"=>422,
                        "message"=>"Undefined mentor"
                    ],422);
                }
            }
            if($request->exists("intern_id")){
                $intern= Intern::find($request["intern_id"]);
                if(!$intern){
                    return response()->json([
                        "status"=>422,
                        "message"=>"Undefined intern"
                    ],422);
                }
            }
            if($request->exists("group_id")){
                $group= Group::find($request["group_id"]);
                if(!$group){
                    return response()->json([
                        "status"=>422,
                        "message"=>"Undefined group"
                    ],422);
                }
            }
            if($request->exists("assignment_id")){
                $assignment= Assignment::find($request["assignment_id"]);
                if(!$assignment){
                    return response()->json([
                        "status"=>422,
                        "message"=>"Undefined assignment"
                    ],422);
                }
            }
            $attributes = $request->validate([
                "intern_id"=>["numeric"],
                "mentor_id"=>["numeric"],
                "group_id"=>["numeric"],
                "activated"=>["boolean"],
                "assignment_id"=>["numeric"],
                "start_at"=>["date"],
                "end_at"=>["date"]
            ]);
            if(!$attributes){
                return response()->json([
                    "status"=>422,
                    "message"=>"Unprocessable Entity"
                ],422);
            }
            if($request["activated"]){
                $attributes["start_at"] = date('Y-m-d');
                $attributes["end_at"] = date('Y-m-d', strtotime("+15 days"));
            }

            $data= Data::create($attributes);
            return response()->json([
                "status"=>201,
                "data"=>$data
            ],201);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function update(Request $request, $id ){
        if (Gate::allows('admin-recruiter-mentor')) {
            $data=Data::find($id);
            if(!$data){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            if($request->exists("mentor_id")){
                $mentor= Mentor::find($request["mentor_id"]);
                $attributes = $request->validate([
                    "mentor_id"=>["numeric"]
                ]);
                if(!$mentor){
                    return response()->json([
                        "status"=>422,
                        "message"=>"Undefined mentor"
                    ],422);
                }
            }
            if($request->exists("intern_id")){
                $intern= Intern::find($request["intern_id"]);
                $attributes = $request->validate([
                    "intern_id"=>["numeric"]
                ]);
                if(!$intern){
                    return response()->json([
                        "status"=>422,
                        "message"=>"Undefined intern"
                    ],422);
                }
            }
            if($request->exists("group_id")){
                $group= Group::find($request["group_id"]);
                $attributes = $request->validate([
                    "group_id"=>["numeric"]
                ]);
                if(!$group){
                    return response()->json([
                        "status"=>422,
                        "message"=>"Undefined group"
                    ],422);
                }
            }
            if($request->exists("assignment_id")){
                $assignment= Assignment::find($request["assignment_id"]);
                $attributes = $request->validate([
                    "assignment_id"=>["numeric"]
                ]);
                if(!$assignment){
                    return response()->json([
                        "status"=>422,
                        "message"=>"Undefined assignment"
                    ],422);
                }
            }
            $attributes = $request->validate([
                "activated"=>["boolean"],
                "start_at"=>["date"],
                "end_at"=>["date"]
            ]);
            if(!$attributes){
                return response()->json([
                    "status"=>422,
                    "message"=>"Unprocessable Entity"
                ],422);
            }
            if($request["activated"]){
                $attributes["start_at"] = date('Y-m-d');
                $attributes["end_at"] = date('Y-m-d', strtotime("+15 days"));
            }
            $data->update($attributes);
            return response()->json([
                "status"=>200,
                "data"=>$data
            ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function destroy($id){
        if (Gate::allows('admin-recruiter-mentor')) {
            $data=Data::find($id);
            if(!$data){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            $data->delete();
            return response()->json([
                "status"=>200,
                "message"=>"Group is deleted"
            ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
}
