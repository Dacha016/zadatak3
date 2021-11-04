<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(){
        $this->authorizeResource(User::class,"user");
    }

    public function index(){
            return response()->json(User::get(),200);
    }
    public function show($id,User $User){
            return response()->json(User::find($id),200);
    }
    public function store(Request $request ){
        $attributes = $request->validate([
            "name"=>["required","string","max:255","alpha"],
            "surname"=>["string","max:255","alpha"],
            "city"=>["string","max:255","alpha"],
            "address"=>["string","max:255","alpha_num"],
            "skype"=>["string","max:255","alpha_num"],
            "email"=>["required","max:255","email"],
            "password"=>["required","min:6","string"],
            "phone"=>["string","max:50"],
            "CV"=>["string"],
            "gitHub"=>["string","alpha_num"],
            "role_id"=>["required","numeric"],
            "mentor_id"=>["numeric"],
            "intern_id"=>["numeric"],
            "group_id"=>["numeric"],
            "assignment_id"=>["numeric"],
        ]);

            $user= User::create($attributes);
            return response()->json($user,200);
    }
    public function update(Request $request, User $user ){
        $user->update($request->all());
        return response()->json($user,200);
    }
    public function destroy( User $user){
        $user->delete();
        return response()->json(null, 204);
    }
}
