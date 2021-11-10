<?php

namespace App\Http\Controllers\Evaluations;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $evaluation=Evaluation::leftjoin("interns","evaluations.intern_id","=","evaluations.id")
            ->leftjoin("mentors","evaluations.mentor_id","=","mentors.id")
            ->leftjoin("assignments","evaluations.assignment_id","=","evaluations.id")
            ->get(["interns.name as intern_name","interns.surname as intern_surname","assignments.title as assignments_title","evaluations.pro","evaluations.con","evaluations.evaluation_day","mentors.name as mentor_name","mentors.surname as mentor_surname"]);
        return response()->json([
            "status"=>200,
            "data"=>$evaluation
            ],200);
    }
    public function show($id,Evaluation $evaluation,Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $evaluation=Evaluation::leftjoin("interns","evaluations.intern_id","=","evaluations.id")
        ->leftjoin("mentors","evaluations.mentor_id","=","mentors.id")
        ->leftjoin("assignments","evaluations.assignment_id","=","evaluations.id")
        ->where("evaluations.intern_id",$id)
        ->get(["interns.name as intern_name","interns.surname as intern_surname","assignments.title as assignments_title","evaluations.pro","evaluations.con","evaluations.evaluation_day","mentors.name as mentor_name","mentors.surname as mentor_surname"]);
        return response()->json([
            "status"=>200,
            "data"=>$evaluation
        ],200);
    }
    public function store(Request $request ){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $attributes = $request->validate([
            "intern_id"=>["required","numeric",],
            "assignment_id"=>["required","numeric"],
            "pro"=>["required","string"],
            "con"=>["required","string"],
            "evaluation_day"=>["required","date"],
            "mentor_id"=>["required","numeric"]
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $evaluation= Evaluation::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$evaluation
        ],201);
    }
}
