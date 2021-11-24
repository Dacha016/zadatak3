<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(){
        $assignment=Assignment::all();
        return response()->json([
            "status"=>200,
            "data"=>$assignment
        ],200);
    }
    public function show($id){
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
        $attributes = $request->validate([
            "title"=>["string","max:255"],
            "description"=>["string"]
        ]);
        $assignment= Assignment::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$assignment
        ],201);
    }
    public function update(Request $request, $id ){
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

        ]);
        $assignment->update($attributes);
        return response()->json([
            "status"=>200,
            "data"=>$assignment
        ],200);
    }
    public function destroy($id){
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
