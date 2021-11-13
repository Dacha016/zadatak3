<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        if (Gate::allows('admin')) {
            $admins=Admin::all();
            return response()->json([
                "status"=>200,
                "data"=>[
                    "admins"=>$admins
                ]
            ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function show($id){
        if (Gate::allows('admin')) {
            $admin=Admin::find($id);
            if(!$admin){
                return response()->json([
                    "status"=>404,
                    "message"=>"Not Found"
                ],404);
            }
            return response()->json([
                "status"=>200,
                "data"=>[
                    "admin"=>$admin
                ]
            ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function store(Request $request ){
        if (Gate::allows('admin')) {
            $attributes = $request->validate([
                "name"=>["required","string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "surname"=>["required","string","max:255","regex:/^[a-zA-Z\s]*$/"],
                "email"=>["required","max:255","email","string"],
                "password"=>["required","min:6","string"]
            ]);
            $admin=Admin::where("email",$attributes["email"])->first();
            if($admin){
                return response()->json([
                    "status"=>403,
                    "message"=>"Email address already exists"
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
                "data"=>[
                    "admin"=>$admin
                ]
            ],201);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function update( Request $request, $id ){
        if (Gate::allows('admin')) {
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
                "data"=>[
                    "admin"=>$admin
                ]
            ],200);
        }

        $attributes["password"]=Hash::make($attributes["password"]);
        $attributes["role_id"]=1;
        $admin->update($attributes);
        return response()->json([
            "status"=>200,
            "data"=>$admin
        ],200);
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
    public function destroy( $id){
        if (Gate::allows('admin')) {
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
        } else {
            return response()->json([
                "status"=>403,
                "message"=>"Forbidden"
            ],403);
        }
    }
}
