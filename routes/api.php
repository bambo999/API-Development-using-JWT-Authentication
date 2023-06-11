<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);


Route::group([
    'middleware' => ['auth:api'],

], function () {
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('logout', [UserController::class, 'logout']);

    //Course API Route
    Route::post('course-enrol', [CourseController::class, 'courseEnrollment']);
    Route::post('total-courses', [CourseController::class, 'totalCourses']);
    Route::get('delete-course/{id}', [CourseController::class, 'deleteCourse']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
