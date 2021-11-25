<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\GroupData;
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
    public function show($id){
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

    public function groupInfo($id){
        $group=Group::find($id);
        if(!$group){
            return response()->json([
                "status"=>404,
                "message"=>"Not found"
            ],404);
        }
        $data=GroupData::leftjoin("groups","group_data.group_id","=","groups.id")
        ->where("groups.id",$id)
        ->select(["groups.title as group_title"])
        ->distinct()
        ->get();
        $group=collect($data)->toArray();
        if(!$group){
            return response()->json([
                "status"=>404,
                "message"=>"There are no users in the group"
            ],404);
        }
        $data=GroupData::leftjoin("mentors","group_data.mentor_id","=","mentors.id")
            ->leftjoin("groups","data.group_id","=","groups.id")
            ->where("groups.id",$id)
            ->select(["mentors.name as mentor_name","mentors.surname as mentor_surname","mentors.city as mentor_city","mentors.skype as mentor_skype","mentors.email as mentor_email","mentors.password as mentor_password"])
            ->distinct()
            ->get();
        $mentor=collect($data)->toArray();

        $data=GroupData::leftjoin("interns","group_data.intern_id","=","interns.id")
            ->leftjoin("groups","data.group_id","=","groups.id")
            ->where("groups.id",$id)
            ->select(["interns.name as intern_name","interns.surname as intern_surname"])
            ->distinct()
            ->get();
        $interns=collect($data)->toArray();

        $data=GroupData::join("assignments","group_data.assignment_id","=","assignments.id")
            ->leftjoin("groups","data.group_id","=","groups.id")
            ->where("groups.id",$id)
            ->select(["assignments.title as assignment_title","data.start_at","data.end_at"])
            ->distinct()
            ->get();
        $assignments=collect($data)->toArray();
        return response()->json([
            "status"=>200,
            "data"=>[
                "groups"=>$group,
                "mentors"=>$mentor,
                "interns"=>$interns,
                "assignments"=>$assignments
                ]
        ],200);
    }
    public function store(Request $request ){
        $attributes = $request->validate([
            "title"=>["string","max:255"]
        ]);
        $group= Group::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$group
        ],201);
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
