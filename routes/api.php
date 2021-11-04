<?php


use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
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



    Route::post("/login",[LoginController::class,"login"]);

Route::group(['prefix' => 'admin','middleware' => 'auth:sanctum'],function(){
    Route::post("/mentors/create",[UserController::class, "store"]);
    Route::get("mentors/{id}",[UserController::class, "show"]);
    Route::put("mentors/{mentor}",[UserController::class, "update"]);
    Route::delete("mentors/{mentor}",[UserController::class, "destroy"]);
    Route::post("logout",[LogoutController::class,"logout"]);
});
