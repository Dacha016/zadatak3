<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(){
        return response()->json(Group::get(),200);
    }
    public function show($id,Group $group){
            return response()->json(Group::find($id),200);
    }
    public function store(Request $request ){
        $attributes = $request->validate([
            "title"=>["string","max:255","alpha",],
            "mentor_id"=>["numeric"],
            "intern_id"=>["numeric"],
            "assignment_id"=>["numeric"]

        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }

            $group= Group::create($attributes);
            return response()->json($group,200);
    }
    public function update(Request $request, Group $group ){
        $attributes = $request->validate([
            "title"=>["string","max:255","alpha",],
            "mentor_id"=>["numeric"],
            "intern_id"=>["numeric"],
            "assignment_id"=>["numeric"]

        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $group->update($attributes);
        return response()->json($group,200);
    }
    public function destroy( Group $group){
        $group->delete();
        return response()->json(null, 204);
    }
}
