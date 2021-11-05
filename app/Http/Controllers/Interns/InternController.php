<?php

namespace App\Http\Controllers\Interns;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;

class InternController extends Controller
{

    public function index(){
        return response()->json(Intern::get(),200);
}
public function show($id,Intern $intern){
        return response()->json(Intern::find($id),200);
}
public function store(Request $request ){
    $attributes = $request->validate([
        "name"=>["string","max:255"],
        "surname"=>["string","max:255"],
        "city"=>["string","max:255"],
        "adderss"=>["string","max:255"],
        "email"=>["required","max:255","email"],
        "phone"=>["string","max:50"],
        "CV"=>["string"],
        "gitHub"=>["url"],
        "role_id"=>["required","numeric"],
        "mentor_id"=>["numeric"],
        "group_id"=>["numeric"],
        "assignment_id"=>["numeric"],
    ]);
    if(!$attributes){
        return response()->json([
            "status"=>422,
            "message"=>"Unprocessable Entity"

        ],422);
    }

        $intern= Intern::create($attributes);
        return response()->json($intern,200);
}
public function update(Request $request, Intern $intern ){
    $attributes = $request->validate([
        "name"=>["string","max:255"],
        "surname"=>["string","max:255"],
        "city"=>["string","max:255"],
        "adderss"=>["string","max:255"],
        "email"=>["required","max:255","email"],
        "phone"=>["string","max:50"],
        "CV"=>["string"],
        "gitHub"=>["url"],
        "role_id"=>["required","numeric"],
        "mentor_id"=>["numeric"],
        "group_id"=>["numeric"],
        "assignment_id"=>["numeric"],
    ]);
    if(!$attributes){
        return response()->json([
            "status"=>422,
            "message"=>"Unprocessable Entity"

        ],422);
    }

    $intern->update($attributes);
    return response()->json($intern,200);
}
public function destroy( Intern $intern){
    $intern->delete();
    return response()->json(null, 204);
}
}
