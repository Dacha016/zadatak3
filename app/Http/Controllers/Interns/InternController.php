<?php

namespace App\Http\Controllers\Interns;

use App\Http\Controllers\Controller;
use App\Models\GroupData;
use App\Models\Intern;
use Illuminate\Http\Request;

class InternController extends Controller
{
    public function index(){
        $interns=Intern::all();
        return response()->json([
            "status"=>200,
            "data"=>[
                "interns"=>$interns
            ]
        ],200);
    }
    public function show($id){
        $intern=Intern::find($id);
        if(!$intern){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        return response()->json([
            "status"=>200,
            "data"=>[
                "intern"=>$intern
            ]
        ],200);
    }
    public function profile($id){
        $data=GroupData::rightjoin("interns","group_data.intern_id","=","interns.id")
            ->where("interns.id",$id)
            ->select(["interns.name as intern_name","interns.surname as intern_surname","interns.city as intern_city","interns.address as intern_address","interns.email as intern_email","interns.phone as intern_phone","interns.CV as intern_CV","interns.gitHub as intern_gitHub"])
            ->distinct()
            ->get();
        $intern=collect($data)->toArray();
        if(!$intern){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }

        $data=GroupData::join("groups","group_data.group_id","=","groups.id")
            ->join("interns","group_data.intern_id","=","interns.id")
            ->where("interns.id",$id)
            ->select(["groups.title as group_title"])
            ->distinct()
            ->get();
        $groups=collect($data)->toArray();

        $data=GroupData::join("assignments","group_data.assignment_id","=","assignments.id")
            ->join("interns","group_data.intern_id","=","interns.id")
            ->where("interns.id",$id)
            ->select(["assignments.title as assignment_title","group_data.start_at","group_data.end_at"])
            ->distinct()
            ->get();
        $assignments=collect($data)->toArray();
        return response()->json([
            "status"=>200,
            "data"=>[
                "intern"=>$intern,
                "groups"=>$groups,
                "assignments"=>$assignments
                ]
        ],200);
    }
    public function store(Request $request ){
        $attributes = $request->validate([
            "name"=>["required","string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "surname"=>["required","string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
            "city"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
            "adderss"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
            "email"=>["required","max:255","email"],
            "phone"=>["string","max:50"],
            "CV"=>["string"],
            "gitHub"=>["url"],
        ]);
        $user=Intern::where("email",$attributes["email"])->first();
        if($user){
            return response()->json([
                "status"=>403,
                "message"=>"Already exists"
            ],403);
        }
        $attributes["role_id"]=4;
        $intern= Intern::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>[
                "intern"=>$intern
            ]
        ],201);
    }
    public function update(Request $request, $id ){
        $intern=Intern::find($id);
        if(!$intern){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $attributes = $request->validate([
            "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "surname"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
            "city"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
            "adderss"=>["string","max:255","regex:/^[a-zA-Z]+('[a-zA-Z])?[a-zA-Z\s]*$/"],
            "email"=>["max:255","email"],
            "phone"=>["string","max:50"],
            "CV"=>["string"],
            "gitHub"=>["string"]
        ]);
        $intern->update($attributes);
        return response()->json([
            "status"=>200,
            "data"=>[
                "intern"=>$intern
            ]
        ],200);
    }
    public function destroy( Request $request,$id){
        $intern=Intern::find($id);
        if(!$intern){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $intern->delete();
        return response()->json([
            "status"=>200,
            "message"=>"Intern is deleted"
        ],200);
    }
}
