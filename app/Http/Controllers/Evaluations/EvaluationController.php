<?php

namespace App\Http\Controllers\Evaluations;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Evaluation;
use App\Models\Intern;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EvaluationController extends Controller
{
    public function index(){
        $evaluation=Evaluation::leftjoin("interns","evaluations.intern_id","=","evaluations.id")
            ->leftjoin("mentors","evaluations.mentor_id","=","mentors.id")
            ->leftjoin("assignments","evaluations.assignment_id","=","evaluations.id")
            ->get(["interns.name as intern_name","interns.surname as intern_surname","assignments.title as assignments_title","evaluations.pro","evaluations.con","evaluations.evaluation_day","mentors.name as mentor_name","mentors.surname as mentor_surname"]);
        return response()->json([
            "status"=>200,
            "data"=>$evaluation
            ],200);
    }
    public function show($id){
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
        if($request->exists("intern_id")){
            $intern= Intern::find($request["intern_id"]);
            if(!$intern){
                return response()->json([
                    "status"=>422,
                    "message"=>"Undefined intern"
                ],422);
            }
        }
        if($request->exists("mentor_id")){
            $mentor= Mentor::find($request["mentor_id"]);
            if(!$mentor){
                return response()->json([
                    "status"=>422,
                    "message"=>"Undefined mentor"
                ],422);
            }
        }
        if($request->exists("assignment_id")){
            $assignment= Assignment::find($request["assignment_id"]);
            if(!$assignment){
                return response()->json([
                    "status"=>422,
                    "message"=>"Undefined assignment"
                ],422);
            }
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
