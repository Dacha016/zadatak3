<?php

use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Assignments\AssignmentController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\Evaluations\EvaluationController;
use App\Http\Controllers\Groups\GroupController;
use App\Http\Controllers\Interns\InternController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Mentors\MentorController;
use App\Http\Controllers\Recruiters\RecruiterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// public
Route::post("/login",[LoginController::class,"login"]);
Route::get("interns/list",[InternController::class, "index"]);
Route::get("interns/{id}",[InternController::class, "show"]);
Route::get("interns/profile/{id}",[InternController::class, "profile"]);
Route::get("evaluations/interns/{id}",[EvaluationController::class, "show"]);
Route::get("evaluations/list",[EvaluationController::class, "index"]);
//protected
Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::group(['prefix' => 'admins'],function(){
        Route::post("/create",[AdminController::class, "store"]);
        Route::get("/list",[AdminController::class, "index"]);
        Route::get("/{id}",[AdminController::class, "show"]);
        Route::put("/{admin}",[AdminController::class, "update"]);
        Route::delete("/{admin}",[AdminController::class, "destroy"]);
        Route::post("/logout",[LogoutController::class, "logout"]);

    });
    Route::group(['prefix' => 'recruiters'],function(){
        Route::post("/create",[RecruiterController::class, "store"]);
        Route::get("/list",[RecruiterController::class, "index"]);
        Route::get("/{id}",[RecruiterController::class, "show"]);
        Route::put("/{recruiter}",[RecruiterController::class, "update"]);
        Route::delete("/{recruiter}",[RecruiterController::class, "destroy"]);
        Route::post("/logout",[LogoutController::class, "logout"]);

    });
    Route::group(['prefix' => 'mentors'],function(){
        Route::post("/create",[MentorController::class, "store"]);
        Route::get("/list",[MentorController::class, "index"]);
        Route::get("/{id}",[MentorController::class, "show"]);
        Route::get("profile/{id}",[MentorController::class, "profile"]);
        Route::put("/{mentor}",[MentorController::class, "update"]);
        Route::delete("/{mentor}",[MentorController::class, "destroy"]);
        Route::post("/logout",[LogoutController::class, "logout"]);

    });
    Route::group(['prefix' => 'groups'],function(){
        Route::post("/create",[GroupController::class, "store"]);
        Route::get("/list",[GroupController::class, "index"]);
        Route::get("/{group}",[GroupController::class, "show"]);
        Route::get("info/{group}",[GroupController::class, "groupInfo"]);
        Route::put("/{group}",[GroupController::class, "update"]);
        Route::delete("/{group}",[GroupController::class, "destroy"]);
        Route::group(['prefix' => 'data'],function(){
            Route::post("/create",[DataController::class, "store"]);
            Route::put("/{intern}",[DataController::class, "update"]);
            Route::delete("/{intern}",[DataController::class, "destroy"]);
        });
    });
    Route::group(['prefix' => 'assignments'],function(){
        Route::post("/create",[AssignmentController::class, "store"]);
        Route::get("/list",[AssignmentController::class, "index"]);
        Route::get("/{id}",[AssignmentController::class, "show"]);
        Route::put("/{assignment}",[AssignmentController::class, "update"]);
        Route::delete("/{assignment}",[AssignmentController::class, "destroy"]);
    });
    Route::group(['prefix' => 'interns'],function(){
        Route::post("/create",[InternController::class, "store"]);
        Route::put("/{intern}",[InternController::class, "update"]);
        Route::delete("/{intern}",[InternController::class, "destroy"]);
    });
    Route::group(['prefix' => 'evaluations'],function(){
        Route::post("/create",[EvaluationController::class, "store"]);
        Route::delete("/{evaluation}",[EvaluationController::class, "destroy"]);
    });

});

