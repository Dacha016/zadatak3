<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(){
        $groups=Group::all();
        if(!$groups){
            return response()->json([
                "status"=>404,
                "message"=>"Not found any data "
            ],404);
        }
        return response()->json([
            "status"=>200,
            "data"=>[
                "groups"=>$groups
                ]
        ],200);
    }
    public function show($id,$assignmentId){
        $group=Group::find($id);
        if(!$group){
            return response()->json([
                "status"=>404,
                "message"=>"Not found"
            ],404);
        }
        return response()->json([
            "status"=>200,
            "data"=>[
                "groups"=>$group
                ]
        ],200);
    }
    public function indexInfo(){
        $data=Data::leftjoin("groups","data.group_id","=","groups.id")
            ->leftjoin("assignments","data.assignment_id","=","assignments.id")
            ->leftjoin("interns","data.intern_id","=","interns.id")
            ->leftjoin("mentors","data.mentor_id","=","mentors.id")
            ->select(["groups.id","groups.title as group_title","mentors.name as mentor_name","mentors.surname as mentor_surname","interns.name as intern_name","interns.surname as intern_surname","assignments.title as assignment_title","data.start_at","data.end_at"])
            ->get();
        $groups=collect($data)->toArray();
        if(!$groups){
            return response()->json([
                "status"=>404,
                "message"=>"Not found any data "
            ],404);
        }
        return response()->json([
            "status"=>200,
            "data"=>[
                "groups"=>$groups
                ]
        ],200);
    }
    public function showInfo($id){
        $data=Data::leftjoin("groups","data.group_id","=","groups.id")
            ->leftjoin("assignments","data.assignment_id","=","assignments.id")
            ->leftjoin("interns","data.intern_id","=","interns.id")
            ->leftjoin("mentors","data.mentor_id","=","mentors.id")
            ->where("groups.id",$id)
            ->select(["groups.id","groups.title as group_title","mentors.name as mentor_name","mentors.surname as mentor_surname","interns.name as intern_name","interns.surname as intern_surname","assignments.title as assignment_title","data.start_at","data.end_at"])
            ->get();
        $group=collect($data)->toArray();
        return response()->json([
            "status"=>200,
            "data"=>[
                "groups"=>$group
                ]
        ],200);
    }
    public function store(Request $request ){
        $attributes = $request->validate([
            "title"=>["string","max:255"]
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $group= Group::create($attributes);
        return response()->json([
            "status"=>200,
            "data"=>$group
        ],200);
    }
    public function update(Request $request, $id ){
        $group=Group::find($id);
        if(!$group){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $attributes = $request->validate([
            "title"=>["string","max:255"]
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }

        $group->create($attributes);
        return response()->json([
            "status"=>200,
            "data"=>$group
        ],200);
    }
    public function destroy($id){
        $group=Group::find($id);
        if(!$group){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $group->delete();
        return response()->json([
            "status"=>200,
            "message"=>"Group is deleted"
        ],200);
    }
}
