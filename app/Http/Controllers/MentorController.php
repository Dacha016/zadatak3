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
    public function store(Request $request ){
        $mentor= Mentor::create($request->all());
        return response()->json($mentor,200);
    }
    public function update(Request $request, Mentor $mentor ){
        $mentor->update($request->all());
        return response()->json($mentor,200);
    }
    public function destroy( Mentor $mentor){
        $mentor->delete();
        return response()->json(null, 204);
    }
}
