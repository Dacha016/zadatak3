<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Models\Recruiter;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    public function index(){
        return response()->json(Recruiter::get(),200);
}
public function show($id,Recruiter $recruiter){
        return response()->json(Recruiter::find($id),200);
}
public function store(Request $request ){
    $attributes = $request->validate([
        "name"=>["string","max:255","alpha"],
        "surname"=>["string","max:255","alpha"],
        "city"=>["string","max:255","alpha"],
        "skype"=>["string","max:255","alpha_num"],
        "email"=>["required","max:255","email"],
        "password"=>["required","min:6","string"],
        "role_id"=>["required","numeric"]

    ]);
    if(!$attributes){
        return response()->json([
            "status"=>422,
            "message"=>"Unprocessable Entity"

        ],422);
    }

        $recruiter= Recruiter::create($attributes);
        return response()->json($recruiter,200);
}
public function update(Request $request, Recruiter $recruiter ){
    $attributes = $request->validate([
        "name"=>["string","max:255","alpha"],
        "surname"=>["string","max:255","alpha"],
        "city"=>["string","max:255","alpha"],
        "skype"=>["string","max:255","alpha_num"],
        "email"=>["max:255","email"],
        "password"=>["min:6","string"],
        "role_id"=>["numeric"]

    ]);
    if(!$attributes){
        return response()->json([
            "status"=>422,
            "message"=>"Unprocessable Entity"

        ],422);
    }

    $recruiter->update($attributes);
    return response()->json($recruiter,200);
}
public function destroy( Recruiter $recruiter){
    $recruiter->delete();
    return response()->json(null, 204);
}
}
