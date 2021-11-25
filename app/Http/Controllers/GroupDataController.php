<?php

namespace App\Http\Controllers;
use App\Models\GroupData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GroupDataController extends Controller
{
    public function store(Request $request ){
        if (Gate::allows('admin-recruiter-mentor')) {

            $attributes = $request->validate([
                "intern_id"=>"exists:interns,interns.id",
                "assignment_id"=>"exists:assignments,assignments.id",
                "mentor_id"=>"exists:mentors,mentors.id",
                "group_id"=>"exists:groups,groups.id",
                "activated"=>["boolean"],
                "start_at"=>["date"],
                "end_at"=>["date"]
            ]);

            if($request["activated"]){
                $attributes["start_at"] = date('Y-m-d');
                $attributes["end_at"] = date('Y-m-d', strtotime("+15 days"));
            }

            $data= GroupData::create($attributes);
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
            $data=GroupData::find($id);
            if(!$data){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            $attributes = $request->validate([
                "intern_id"=>"exists:interns,interns.id",
                "assignment_id"=>"exists:assignments,assignments.id",
                "mentor_id"=>"exists:mentors,mentors.id",
                "group_id"=>"exists:groups,groups.id",
                "activated"=>["boolean"],
                "start_at"=>["date"],
                "end_at"=>["date"]
            ]);

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
            $data=GroupData::find($id);
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
