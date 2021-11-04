<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request){
        if(Auth::check()){
            Auth::user()->tokens->each(function($token, $key) {
                $token->delete();
            });
        }
        return response()->json(["You are logged out"]);
    }
}
