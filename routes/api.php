<?php

use App\Http\Controllers\Admins\LogoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Mentors\MentorController;
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

Route::group(['prefix' => 'admin','middleware' => 'auth:sanctum'],function(){
    Route::post("/mentors/create",[MentorController::class, "store"])->middleware("can:create-mentor, mentor");
    Route::get("mentors/{id}",[MentorController::class, "show"])->middleware("can:show-mentor, mentor");  //  mozda bo trebalo profile
    Route::put("mentors/{mentor}",[MentorController::class, "update"])->middleware("can:update-mentor, mentor");
    Route::delete("mentors/{mentor}",[MentorController::class, "destroy"])->middleware("can:delete-mentor, mentor");
    Route::post("logout",[ LogoutController::class, "logout"]);

});
