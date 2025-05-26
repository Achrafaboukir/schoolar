<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TeacherController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\FeedbackController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Students routes
    Route::apiResource('students', StudentController::class);

    // Teachers routes
    Route::apiResource('teachers', TeacherController::class);

    // Courses routes
    Route::apiResource('courses', CourseController::class);
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollStudent']);
    Route::post('/courses/{course}/unenroll', [CourseController::class, 'unenrollStudent']);
    Route::get('/courses/{course}/students', [CourseController::class, 'getEnrolledStudents']);

    // Feedback routes
    Route::apiResource('feedback', FeedbackController::class);
    Route::get('/courses/{course}/feedback/stats', [FeedbackController::class, 'getStats']);
}); 