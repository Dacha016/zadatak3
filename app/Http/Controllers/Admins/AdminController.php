<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $admin=Admin::all();
        return response()->json([
            "status"=>200,
            "data"=>$admin
        ],200);
    }
    public function show($id,Request $request){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $admin=Admin::find($id);
        if(!$admin){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        return response()->json([
            "status"=>200,
            "data"=>$admin
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
            "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "surname"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "email"=>["required","max:255","email","string"],
            "password"=>["required","min:6","string"]
        ]);
        $admin=Admin::where("email",$attributes["email"])->first();
        if($admin){
            return response()->json([
                "status"=>403,
                "message"=>"Already exists"
            ],403);
        }
        $attributes["password"]=Hash::make($attributes["password"]);
        $attributes["role_id"]=1;
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        $admin= Admin::create($attributes);
        return response()->json([
            "status"=>201,
            "data"=>$admin
        ],201);
    }
    public function update( Request $request, $id ){

        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $admin=Admin::find($id);
        if(!$admin){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $attributes = $request->validate([
            "name"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "surname"=>["string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "email"=>["max:255","email"],
            "password"=>["min:6","string"]
        ]);
        if(!$attributes){
            return response()->json([
                "status"=>422,
                "message"=>"Unprocessable Entity"
            ],422);
        }
        if(!$request->exists('password')){
            $admin->update($attributes);
            return response()->json([
                "status"=>200,
                "data"=>$admin
            ],200);
        }

        $attributes["password"]=Hash::make($attributes["password"]);
        $attributes["role_id"]=1;
        $admin->update($attributes);
        return response()->json([
            "status"=>200,
            "data"=>$admin
        ],200);

    }
    public function destroy( Request $request, $id){
        if(!$request->header('Authorization')){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }
        $admin=Admin::find($id);
        if(!$admin){
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ],404);
        }
        $admin->delete();
        return response()->json([
            "status"=>200,
            "message"=>"Admin is deleted"
        ],200);
    }
}
