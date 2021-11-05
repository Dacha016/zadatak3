<?php

use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Admins\LogoutController;
use App\Http\Controllers\Assignments\AssignmentController;
use App\Http\Controllers\Groups\GroupController;
use App\Http\Controllers\Interns\InternController;
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



// Route::group(['prefix' => 'admins','middleware' => 'auth:sanctum',],function(){
//     Route::post("/create",[AdminController::class, "store"])->middleware("can:create, recruiter");
//     Route::post("/{id}",[AdminController::class, "show"])->middleware("can:show, recruiter");
//     Route::post("/{admin}",[AdminController::class, "update"])->middleware("can:update, recruiter");
//     Route::post("/{admin}",[AdminController::class, "delete"])->middleware("can:delete, recruiter");
//     Route::post("/logout",[LogoutController::class, "logout"]);

// });

// Route::group(['prefix' => 'recruiters','middleware' => 'auth:sanctum',],function(){
//     Route::post("/create",[RecruiterController::class, "store"])->middleware("can:create, recruiter");
//     Route::post("/{id}",[RecruiterController::class, "show"])->middleware("can:show, recruiter");
//     Route::post("/{recruiter}",[RecruiterController::class, "update"])->middleware("can:update, recruiter");
//     Route::post("/{recruiter}",[RecruiterController::class, "delete"])->middleware("can:delete, recruiter");
//     Route::post("/logout",[RecruitersLogoutController::class, "logout"]);

// });

// Route::group(['prefix' => 'mentors','middleware' => 'auth:sanctum',],function(){
//     Route::post("/create",[MentorController::class, "store"])->middleware("can:create-mentor, mentor");
//     Route::get("/{id}",[MentorController::class, "show"])->middleware("can:show-mentor, mentor");  //  mozda bo trebalo profile
//     Route::put("/{mentor}",[MentorController::class, "update"])->middleware("can:update-mentor, mentor");
//     Route::delete("/{mentor}",[MentorController::class, "destroy"])->middleware("can:delete-mentor, mentor");
//     Route::post("/logout",[ MentorsLogoutController::class, "logout"]);

// });


// public
Route::post("/login",[LoginController::class,"login"])->middleware("guest");
Route::get("interns/{id}",[InternController::class, "show"]);
//protected
Route::group(['middleware' => 'auth:sanctum',],function(){
    Route::group(['prefix' => 'admins'],function(){
        Route::post("/create",[AdminController::class, "store"])->middleware("can:create-admin, admin");
        Route::post("/{id}",[AdminController::class, "show"])->middleware("can:show-admin, admin");
        Route::post("/{admin}",[AdminController::class, "update"])->middleware("can:update-admin, admin");
        Route::post("/{admin}",[AdminController::class, "delete"])->middleware("can:delete-admin, admin");
        Route::post("/logout",[LogoutController::class, "logout"]);

    });
    Route::group(['prefix' => 'recruiters'],function(){
        Route::post("/create",[RecruiterController::class, "store"])->middleware("can:create-admin, recruiter");
        Route::post("/{id}",[RecruiterController::class, "show"])->middleware("can:show-admin, recruiter");
        Route::post("/{recruiter}",[RecruiterController::class, "update"])->middleware("can:update-admin, recruiter");
        Route::post("/{recruiter}",[RecruiterController::class, "delete"])->middleware("can:delete-admin, recruiter");
        Route::post("/logout",[RecruitersLogoutController::class, "logout"]);

    });
    Route::group(['prefix' => 'mentors'],function(){
        Route::post("/create",[MentorController::class, "store"])->middleware("can:create, mentor");
        Route::get("/{id}",[MentorController::class, "show"])->middleware("can:show, mentor");  //  mozda bo trebalo profile
        Route::put("/{mentor}",[MentorController::class, "update"])->middleware("can:update, mentor");
        Route::delete("/{mentor}",[MentorController::class, "destroy"])->middleware("can:delete, mentor");
        Route::post("/logout",[ MentorsLogoutController::class, "logout"]);

    });
    Route::group(['prefix' => 'groups'],function(){
        Route::post("/create",[GroupController::class, "store"])->middleware("can:create-all, group");
        Route::get("/{id}",[GroupController::class, "show"])->middleware("can:show-all, group");
        Route::put("/{mentor}",[GroupController::class, "update"])->middleware("can:update-all, group");
        Route::delete("/{mentor}",[GroupController::class, "destroy"])->middleware("can:delete-all, group");
    });
    Route::group(['prefix' => 'assignments'],function(){
        Route::post("/create",[AssignmentController::class, "store"])->middleware("can:create-all, assignment");
        Route::get("/{id}",[AssignmentController::class, "show"])->middleware("can:show-all, assignment");
        Route::put("/{assignment}",[AssignmentController::class, "update"])->middleware("can:update-all, assignment");
        Route::delete("/{assignment}",[AssignmentController::class, "destroy"])->middleware("can:delete-all, assignment");
    });
    Route::group(['prefix' => 'interns'],function(){
        Route::post("/create",[InternController::class, "store"])->middleware("can:create-all, intern");
        Route::put("/{assignment}",[InternController::class, "update"])->middleware("can:update-all, intern");
        Route::delete("/{assignment}",[InternController::class, "destroy"])->middleware("can:delete-all, intern");
    });

});
