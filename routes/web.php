<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseDocumentController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Add AJAX-only routes for role form modals
Route::get('/roles/create-form', [RoleController::class, 'createForm'])->name('roles.create-form');
Route::get('/roles/{role}/edit-form', [RoleController::class, 'editForm'])->name('roles.edit-form');

// Admin routes
Route::resource('users', UserController::class);
Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
Route::resource('roles', RoleController::class);
Route::resource('groups', GroupController::class);
Route::resource('departments', DepartmentController::class);

// Teacher routes
Route::prefix('teachers')->name('teachers.')->group(function () {
    Route::get('/', [TeacherController::class, 'index'])->name('index');
    Route::post('/', [TeacherController::class, 'store'])->name('store');
    Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
    Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
    
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [TeacherController::class, 'myCourses'])->name('courses.index');
    Route::get('/courses/create', [TeacherController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [TeacherController::class, 'storeCourse'])->name('courses.store');
    Route::get('/groups', [TeacherController::class, 'myGroups'])->name('groups.index');
    Route::get('/groups/{group}', [TeacherController::class, 'showGroup'])->name('groups.show');
    Route::get('/profile', [TeacherController::class, 'profile'])->name('profile');
    Route::put('/profile', [TeacherController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [TeacherController::class, 'updatePassword'])->name('profile.password');
});

// Student routes
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

// Course routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');

// Course document routes
Route::post('/courses/{courseId}/documents', [CourseDocumentController::class, 'store'])->name('course.documents.store');
Route::delete('/course-documents/{id}', [CourseDocumentController::class, 'destroy'])->name('course.documents.destroy');

Route::get('/courses/{courseId}/documents', function ($courseId) {
    $course = \App\Models\Course::findOrFail($courseId);
    $documents = $course->documents()
        ->where('is_deleted', false)
        ->get()
        ->map(function ($doc) {
            $doc->formatted_file_size = $doc->formatted_file_size;
            return $doc;
        });
    
    return response()->json([
        'documents' => $documents
    ]);
});

// AJAX modal routes for user CRUD
Route::get('users/create-form', [App\Http\Controllers\UserController::class, 'createForm'])->name('users.create-form');
Route::get('users/{user}/edit-form', [App\Http\Controllers\UserController::class, 'editForm'])->name('users.edit-form');
Route::get('users/{user}/delete-modal', [App\Http\Controllers\UserController::class, 'deleteModal'])->name('users.delete-modal');
Route::get('users/{user}/reset-password-modal', [App\Http\Controllers\UserController::class, 'resetPasswordModal'])->name('users.reset-password-modal');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
