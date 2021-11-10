<?php

use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Assignments\AssignmentController;
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
Route::post("/login",[LoginController::class,"login"])->middleware("guest");
Route::get("interns/list",[InternController::class, "index"]);
Route::get("interns/{id}",[InternController::class, "show"]);
Route::get("evaluations/interns/{id}",[EvaluationController::class, "show"]);
Route::get("evaluations/list",[EvaluationController::class, "index"]);
//protected
Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::group(['prefix' => 'admins'],function(){
        Route::post("/create",[AdminController::class, "store"])->middleware("can:admin");
        Route::get("/list",[AdminController::class, "index"])->middleware("can:admin");
        Route::get("/{id}",[AdminController::class, "show"])->middleware("can:admin");
        Route::put("/{admin}",[AdminController::class, "update"])->middleware("can:admin");
        Route::delete("/{admin}",[AdminController::class, "destroy"])->middleware("can:admin");
        Route::post("/logout",[LogoutController::class, "logout"])->middleware("can:admin");

    });
    Route::group(['prefix' => 'recruiters'],function(){
        Route::post("/create",[RecruiterController::class, "store"])->middleware("can:admin");
        Route::get("/list",[RecruiterController::class, "index"])->middleware("can:admin-recruiter");
        Route::get("/{id}",[RecruiterController::class, "show"])->middleware("can:admin");
        Route::put("/{recruiter}",[RecruiterController::class, "update"])->middleware("can:admin");
        Route::delete("/{recruiter}",[RecruiterController::class, "destroy"])->middleware("can:admin");
        Route::post("/logout",[LogoutController::class, "logout"]);

    });
    Route::group(['prefix' => 'mentors'],function(){
        Route::post("/create",[MentorController::class, "store"])->middleware("can:admin-recruiter");
        Route::get("/list",[MentorController::class, "index"])->middleware("can:admin-recruiter-mentor");
        Route::get("/{id}",[MentorController::class, "show"])->middleware("can:admin-recruiter");  //  mozda bo trebalo profile
        Route::put("/{mentor}",[MentorController::class, "update"])->middleware("can:admin-recruiter");
        Route::delete("/{mentor}",[MentorController::class, "destroy"])->middleware("can:admin-recruiter");
        Route::post("/logout",[LogoutController::class, "logout"]);

    });
    Route::group(['prefix' => 'groups'],function(){
        Route::post("/create",[GroupController::class, "store"])->middleware("can:admin-recruiter-mentor");
        Route::get("/list",[GroupController::class, "index"])->middleware("can:admin-recruiter-mentor");
        Route::get("/{id}",[GroupController::class, "show"])->middleware("can:admin-recruiter-mentor");
        Route::put("/{group}",[GroupController::class, "update"])->middleware("can:admin-recruiter-mentor");
        Route::delete("/{group}",[GroupController::class, "destroy"])->middleware("can:admin-recruiter-mentor");
    });
    Route::group(['prefix' => 'assignments'],function(){
        Route::post("/create",[AssignmentController::class, "store"])->middleware("can:admin-recruiter-mentor");
        Route::get("/list",[AssignmentController::class, "index"])->middleware("can:admin-recruiter-mentor");
        Route::get("/{id}",[AssignmentController::class, "show"])->middleware("can:admin-recruiter-mentor");
        Route::put("/{assignment}",[AssignmentController::class, "update"])->middleware("can:admin-recruiter-mentor");
        Route::delete("/{assignment}",[AssignmentController::class, "destroy"])->middleware("can:admin-recruiter-mentor");
    });
    Route::group(['prefix' => 'interns'],function(){
        Route::post("/create",[InternController::class, "store"])->middleware("can:admin-recruiter-mentor");
        Route::put("/{intern}",[InternController::class, "update"])->middleware("can:admin-recruiter-mentor");
        Route::delete("/{intern}",[InternController::class, "destroy"])->middleware("can:admin-recruiter-mentor");
    });
    Route::group(['prefix' => 'evaluations'],function(){
        Route::post("/create",[EvaluationController::class, "store"])->middleware("can:admin-recruiter-mentor");
    });
});

