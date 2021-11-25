<?php

namespace App\Http\Controllers\Evaluations;

use App\Http\Controllers\Controller;
use App\Models\GroupData;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EvaluationController extends Controller
{
    public function index(){
        $evaluations=Evaluation::join("interns","evaluations.intern_id","=","interns.id")
            ->join("mentors","evaluations.mentor_id","=","mentors.id")
            ->join("assignments","evaluations.assignment_id","=","assignments.id")
            ->get(["interns.name as intern_name","interns.surname as intern_surname","assignments.title as assignments_title","evaluations.pro","evaluations.con","evaluations.evaluation_day","mentors.name as mentor_name","mentors.surname as mentor_surname"]);
        return response()->json([
            "status"=>200,
            "data"=>[
                "evluations"=>$evaluations
            ]
        ],200);
    }
    public function show($id){
        $evaluation=Evaluation::join("interns","evaluations.intern_id","=","interns.id")
        ->join("mentors","evaluations.mentor_id","=","mentors.id")
        ->join("assignments","evaluations.assignment_id","=","assignments.id")
        ->where("evaluations.intern_id",$id)
        ->get(["interns.name as intern_name","interns.surname as intern_surname","assignments.title as assignments_title","evaluations.pro","evaluations.con","evaluations.evaluation_day","mentors.name as mentor_name","mentors.surname as mentor_surname"]);

        if(count($evaluation)==0){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        return response()->json([
            "status"=>200,
            "data"=>[
                "evluations"=>$evaluation
            ]
        ],200);
    }
    public function store(Request $request ){
        if (Gate::allows('mentor')) {
            $attributes = $request->validate([
                "intern_id"=>"exists:data,data.intern_id",
                "assignment_id"=>"exists:data,data.assignment_id",
                "mentor_id"=>"exists:data,data.mentor_id",
                "pro"=>["required","string"],
                "con"=>["required","string"],
                "evaluation_day"=>["required","date"]
            ]);
            $data=GroupData::leftjoin("interns","group_data.intern_id","=","interns.id")
                ->leftjoin("groups","group_data.group_id","=","groups.id")
                ->where("data.intern_id",$request["intern_id"])
                ->select(["groups.id"])
                ->distinct()
                ->get();
            $group=collect($data)->toArray();
            $data=GroupData::leftjoin("mentors","group_data.mentor_id","=","mentors.id")
                ->leftjoin("groups","group_data.group_id","=","groups.id")
                ->where("groups.id",$group[0]["id"])
                ->select(["mentors.id"])
                ->distinct()
                ->get();
            $mentors=collect($data)->toArray();

            for($i=0;$i<count($mentors);$i++){
                if($mentors[$i]["id"]==$attributes["mentor_id"]){
                    $evaluation= Evaluation::create($attributes);
                    return response()->json([
                        "status"=>201,
                        "data"=>[
                            "evluations"=>$evaluation
                        ]
                    ],201);
                }
            }
            return response()->json([
                "status"=>422,
                "message"=>"Wrong mentor"
            ],422);
        }
        return response()->json([
            "status"=>403,
            "message"=>"Forbidden"
        ],403);
    }
    public function destroy($id){
        if (Gate::allows('admin')) {
            $evaluation=Evaluation::find($id);
            if(!$evaluation){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            $evaluation->delete();
            return response()->json([
                "status"=>200,
                "message"=>"Mentor is deleted"
            ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
}
