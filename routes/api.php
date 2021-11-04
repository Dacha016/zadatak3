<?php

use App\Http\Controllers\Admins\LogoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Mentors\LogoutController as MentorsLogoutController;
use App\Http\Controllers\Mentors\MentorController;
use App\Http\Controllers\Recruiters\LogoutController as RecruitersLogoutController;
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

Route::post("/login",[LoginController::class,"login"])->middleware("guest");

Route::group(['prefix' => 'recruiters','middleware' => 'auth:sanctum',],function(){
    Route::post("/create",[RecruiterController::class, "store"])->middleware("can:create, recruiter");
    Route::post("/{id}",[RecruiterController::class, "show"])->middleware("can:show, recruiter");
    Route::post("/{mentor}",[RecruiterController::class, "update"])->middleware("can:update, recruiter");
    Route::post("/{mentor}",[RecruiterController::class, "delete"])->middleware("can:delete, recruiter");
    Route::post("/logout",[RecruitersLogoutController::class, "logout"]);

});

Route::group(['prefix' => 'mentors','middleware' => 'auth:sanctum',],function(){
    Route::post("/create",[MentorController::class, "store"])->middleware("can:create-mentor, mentor");
    Route::get("/{id}",[MentorController::class, "show"])->middleware("can:show-mentor, mentor");  //  mozda bo trebalo profile
    Route::put("/{mentor}",[MentorController::class, "update"])->middleware("can:update-mentor, mentor");
    Route::delete("/{mentor}",[MentorController::class, "destroy"])->middleware("can:delete-mentor, mentor");
    Route::post("/logout",[ MentorsLogoutController::class, "logout"]);

});
