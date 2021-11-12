<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $assignment=Assignment::all();
        return response()->json([
            "status"=>200,
            "data"=>$assignment
        ],200);
    }
    public function show($id,Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $assignment=Assignment::find($id);
        if(!$assignment){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        return response()->json([
            "status"=>200,
            "data"=>$assignment
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
            "title"=>["string","max:255"],
            "description"=>["string"],
            "group_id"=>["numeric"],
            "start_at"=>["date"],
            "end_at"=>["date"]
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $assignment= Assignment::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$assignment
        ],201);
    }
    public function update(Request $request, $id ){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $assignment=Assignment::find($id);
        if(!$assignment){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $attributes = $request->validate([
            "title"=>["string","max:255"],
            "description"=>["string"],
            "group_id"=>["numeric"],
            "start_at"=>["date"],
            "end_at"=>["date"]
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $assignment->update($attributes);
        return response()->json([
            "status"=>200,
            "data"=>$assignment
        ],200);
    }
    public function destroy( Request $request,$id){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $assignment=Assignment::find($id);
        if(!$assignment){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $assignment->delete();
        return response()->json([
            "status"=>200,
            "message"=>"Assignment is deleted"
        ],200);
    }
}
