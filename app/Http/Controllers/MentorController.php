<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function index(){
        return response()->json(Mentor::get(),200);
    }
    public function show($id){
        return response()->json(Mentor::find($id),200);

    }
}
