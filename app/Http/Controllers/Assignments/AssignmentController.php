<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(){
        return response()->json(Assignment::get(),200);
    }
    public function show($id,Assignment $assignment){
            return response()->json(Assignment::find($id),200);
    }
    public function store(Request $request ){
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
            return response()->json($assignment,200);
    }
    public function update(Request $request, Assignment $assignment ){
        $attributes = $request->validate([
            "title"=>["string","max:255","alpha",],
            "description"=>["string","alpha_num"],
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
        return response()->json($assignment,200);
    }
    public function destroy( Assignment $assignment){
        $assignment->delete();
        return response()->json(null, 204);
    }
}
