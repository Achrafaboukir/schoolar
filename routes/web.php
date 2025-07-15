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
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StudentAuthController;

// Language switching route
Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

// Public routes (no authentication required)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Temporary debug route - remove this in production
Route::get('/debug-user/{email}', function ($email) {
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        return response()->json([
            'user_id' => $user->id,
            'email' => $user->email,
            'status' => $user->status,
            'status_type' => gettype($user->status),
            'is_active' => $user->isActive(),
            'password_length' => strlen($user->password),
            'password_starts_with' => substr($user->password, 0, 7),
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);
    }
    return response()->json(['error' => 'User not found'], 404);
});

// Temporary password test route - remove this in production
Route::get('/test-password/{email}/{password}', function ($email, $password) {
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        $isValid = \Illuminate\Support\Facades\Hash::check($password, $user->password);
        return response()->json([
            'email' => $email,
            'password_provided' => $password,
            'password_hash_in_db' => $user->password,
            'is_valid' => $isValid,
            'status' => $user->status,
            'is_active' => $user->isActive()
        ]);
    }
    return response()->json(['error' => 'User not found'], 404);
});

// Temporary route to list all users - remove this in production
Route::get('/list-users', function () {
    $users = \App\Models\User::select('id', 'firstname', 'lastname', 'email', 'status')->get();
    return response()->json($users);
});

// Temporary route to hash a user's password - remove this in production
Route::get('/hash-password/{email}/{password}', function ($email, $password) {
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        $oldPassword = $user->password;
        $user->password = $password;
        $user->save();
        
        return response()->json([
            'email' => $email,
            'old_password' => $oldPassword,
            'new_password_hash' => $user->password,
            'is_hashed' => str_starts_with($user->password, '$2y$'),
            'test_login' => \Illuminate\Support\Facades\Hash::check($password, $user->password)
        ]);
    }
    return response()->json(['error' => 'User not found'], 404);
});

// Authentication routes
Auth::routes();

// Student authentication routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StudentAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
    
    // Student routes (no middleware - simple session check)
    Route::get('/dashboard', [StudentAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentAuthController::class, 'courses'])->name('courses');
    Route::get('/courses/{courseId}', [StudentAuthController::class, 'courseDetails'])->name('course.details');
    Route::get('/courses/{courseId}/feedback', [StudentAuthController::class, 'showFeedbackForm'])->name('course.feedback');
    Route::post('/courses/{courseId}/feedback', [StudentAuthController::class, 'submitFeedback'])->name('course.feedback.submit');
    Route::get('/profile', [StudentAuthController::class, 'profile'])->name('profile');
    
    // Course document download route for students
    Route::get('/courses/{course}/documents/{document}/download', [CourseDocumentController::class, 'download'])->name('course.documents.download');
});

// Protected routes (authentication required)
Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');

    // Add AJAX-only routes for role form modals
    Route::get('/roles/create-form', [RoleController::class, 'createForm'])->name('roles.create-form');
    Route::get('/roles/{role}/edit-form', [RoleController::class, 'editForm'])->name('roles.edit-form');

    // Admin routes
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('roles', RoleController::class);
    
    // Groups routes with AJAX form routes
    Route::get('/groups/create-form', [GroupController::class, 'createForm'])->name('groups.create-form');
    Route::get('/groups/{group}/edit-form', [GroupController::class, 'editForm'])->name('groups.edit-form');
    Route::resource('groups', GroupController::class);
    
    // Departments routes with AJAX form routes
    Route::get('/departments/create-form', [DepartmentController::class, 'createForm'])->name('departments.create-form');
    Route::get('/departments/{department}/edit-form', [DepartmentController::class, 'editForm'])->name('departments.edit-form');
    Route::resource('departments', DepartmentController::class);

    // Teacher routes with AJAX form routes
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::post('/', [TeacherController::class, 'store'])->name('store');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
        
        // AJAX form routes
        Route::get('/create-form', [TeacherController::class, 'createForm'])->name('create-form');
        Route::get('/{teacher}/edit-form', [TeacherController::class, 'editForm'])->name('edit-form');
        
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [TeacherController::class, 'myCourses'])->name('courses.index');
        Route::get('/courses/create', [TeacherController::class, 'createCourse'])->name('courses.create');
        Route::post('/courses', [TeacherController::class, 'storeCourse'])->name('courses.store');
        Route::get('/groups', [TeacherController::class, 'myGroups'])->name('groups.index');
        Route::get('/groups/{group}', [TeacherController::class, 'showGroup'])->name('groups.show');
    });

    // Student routes with AJAX form routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    
    // AJAX form routes for students
    Route::get('/students/create-form', [StudentController::class, 'createForm'])->name('students.create-form');
    Route::get('/students/{student}/edit-form', [StudentController::class, 'editForm'])->name('students.edit-form');

    // Course routes with AJAX form routes
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
    
    // AJAX form routes for courses
    Route::get('/courses/create-form', [CourseController::class, 'createForm'])->name('courses.create-form');
    Route::get('/courses/{course}/edit-form', [CourseController::class, 'editForm'])->name('courses.edit-form');

    // Course document routes
    Route::prefix('courses/{course}')->name('courses.documents.')->group(function () {
        Route::get('/documents', [CourseDocumentController::class, 'index'])->name('index');
        Route::get('/documents/create-form', [CourseDocumentController::class, 'createForm'])->name('create-form');
        Route::post('/documents', [CourseDocumentController::class, 'store'])->name('store');
        Route::get('/documents/{document}/edit-form', [CourseDocumentController::class, 'editForm'])->name('edit-form');
        Route::put('/documents/{document}', [CourseDocumentController::class, 'update'])->name('update');
        Route::delete('/documents/{document}', [CourseDocumentController::class, 'destroy'])->name('destroy');
        Route::get('/documents/{document}/download', [CourseDocumentController::class, 'download'])->name('download');
    });

    // AJAX modal routes for user CRUD
    Route::get('users/create-form', [App\Http\Controllers\UserController::class, 'createForm'])->name('users.create-form');
    Route::get('users/{user}/edit-form', [App\Http\Controllers\UserController::class, 'editForm'])->name('users.edit-form');
    Route::get('users/{user}/delete-modal', [App\Http\Controllers\UserController::class, 'deleteModal'])->name('users.delete-modal');
    Route::get('users/{user}/reset-password-modal', [App\Http\Controllers\UserController::class, 'resetPasswordModal'])->name('users.reset-password-modal');
    Route::resource('users', UserController::class);

    // Feedback management routes
    Route::get('/feedback', [App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback.index');
    Route::delete('/feedback/{id}', [App\Http\Controllers\FeedbackController::class, 'destroy'])->name('feedback.destroy');
});

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
