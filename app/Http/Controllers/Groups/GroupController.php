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
        if($group[0]["avtivated"]){
            $group[0]["start_at"] = date('Y-m-d');
            $group[0]["end_at"] = date('Y-m-d', strtotime("+15 days"));
        }
    $group= json_encode($group[0]);

        return response()->json([
            "status"=>200,
            "data"=>"$group"
            ],200);
    }
    public function show($id,Group $group){


        $data= Group::leftjoin("interns","groups.id","=","interns.group_id")
            ->leftjoin("mentors","groups.id","=","mentors.group_id")
            ->leftjoin("assignments","groups.id","=","assignments.group_id")
            ->where("groups.id",$id)
            ->get(["groups.title","groups.activated","mentors.id as mentor_id","interns.id as intern_id","assignments.id as assignment_id","assignments.start_at","assignments.end_at"]);

        $group=$data-> toArray();
        if($group[0]["avtivated"]){
            $group[0]["start_at"] = date('Y-m-d');
            $group[0]["end_at"] = date('Y-m-d', strtotime("+15 days"));
        }
    $group= json_encode($group[0]);

        return response()->json([
            "status"=>200,
            "data"=>"$group"
            ],200);
    }

    public function store(Request $request ){
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
            $group= Group::create($attributes);
            return response()->json([
                "status"=>200,
                "data"=>"$group"
            ],200);
    }
    public function update(Request $request, Group $group ){
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
            "data"=>"$group"
        ],200);
    }
    public function destroy( Group $group){
        $group->delete();
        return response()->json(null, 204);
    }
}
