<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Intern;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(){
        $data= Group::leftjoin("interns","groups.id","=","interns.group_id")
            ->leftjoin("mentors","groups.id","=","mentors.group_id")
            ->leftjoin("assignments","groups.id","=","assignments.group_id")
            ->get(["groups.id","groups.title","groups.activated","mentors.name as mentor_name","mentors.surname as mentor_surname","mentors.city as mentor_city","mentors.skype as mentor_skype","interns.name as intern_name","interns.surname as intern_surname","assignments.id as assignment_id","assignments.start_at","assignments.end_at"]);
        $group=$data-> toArray();
        if($group[0]["activated"]){
            $group[0]["start_at"] = date('Y-m-d');
            $group[0]["end_at"] = date('Y-m-d', strtotime("+15 days"));
        }
        $group= json_encode($group[0]);
        return response()->json([
            "status"=>200,
            "data"=>"$group"
        ],200);
    }
    public function show($id){
        $group=Group::find($id);
        if(!$group){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $data= Group::leftjoin("interns","groups.id","=","interns.group_id")
            ->leftjoin("mentors","groups.id","=","mentors.group_id")
            ->leftjoin("assignments","groups.id","=","assignments.group_id")
            ->where("groups.id",$id)
            ->get(["groups.id","groups.title","groups.activated","mentors.name as mentor_name","mentors.surname as mentor_surname","mentors.city as mentor_city","mentors.skype as mentor_skype","interns.name as intern_name","interns.surname as intern_surname","assignments.id as assignment_id","assignments.start_at","assignments.end_at"]);
        $group=$data-> toArray();
        if($group[0]["activated"]){
            $group[0]["start_at"] = date('Y-m-d');
            $group[0]["end_at"] = date('Y-m-d', strtotime("+15 days"));
        }
        $group= json_encode($group[0]);
        return response()->json([
            "status"=>200,
            "data"=>$group
        ],200);
    }
    public function store(Request $request ){
        $attributes = $request->validate([
            "title"=>["string","max:255"],
            "activated"=>["boolean"]
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
            "title"=>["string","max:255"],
            "activated"=>["numeric"]
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $group->update($attributes);
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
