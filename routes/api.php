<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Route::get("mentors",[MentorController::class, "index"]);
Route::get("mentors/{id}",[MentorController::class, "show"]);
Route::post("mentors",[MentorController::class, "store"])->middleware("can");
Route::put("mentors/{mentor}",[MentorController::class, "update"]);
Route::delete("mentors/{mentor}",[MentorController::class, "destroy"]);
Route::post("admin/register",[MentorController::class, "store"]);
Route::post("register",[RegisterController::class, "register"]);
Route::post("login",[LoginController::class,"login"]);
Route::post("logout",[LogoutController::class,"logout"]);
Route::get("logged",[RegisterController::class, "loggedUser"]);

Route::group(['prefix' => 'admin','middleware' => 'auth:api'],function(){
    Route::post("logout",[LogoutController::class,"logout"]);
    // Route::post("register",[RegisterController::class, "register"]);
    Route::get("mentors/{id}",[MentorController::class, "show"]);
    Route::post("/mentors",[MentorController::class, "store"]);
    Route::put("mentors/{mentor}",[MentorController::class, "update"]);
    Route::delete("mentors/{mentor}",[MentorController::class, "destroy"]);
    Route::get("logged",[RegisterController::class, "loggedUser"]);
});
