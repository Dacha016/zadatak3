<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return response()->json(Admin::get(),200);
}
public function show($id,Admin $admin){
        return response()->json(Admin::find($id),200);
}
public function store(Request $request ){
    $attributes = $request->validate([
        "name"=>["string","max:255","alpha"],
        "surname"=>["string","max:255","alpha"],
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

        $admin= Admin::create($attributes);
        return response()->json($admin,200);
}
public function update(Request $request, Admin $admin ){
    $attributes = $request->validate([
        "name"=>["string","max:255","alpha"],
        "surname"=>["string","max:255","alpha"],
        "email"=>["required","max:255","email"],
        "password"=>["min:6","string"],
        "role_id"=>["numeric"]
    ]);
    if(!$attributes){
        return response()->json([
            "status"=>422,
            "message"=>"Unprocessable Entity"
        ],422);
    }
    $admin->update($attributes);
    return response()->json($admin,200);
}
public function destroy( Admin $admin){
    $admin->delete();
    return response()->json(null, 204);
}
}
