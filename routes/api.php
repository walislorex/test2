<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\API\ClassController;
use App\Http\Controllers\API\TeacherController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::apiResource('assignments', AssignmentController::class);
//     // Add other routes for exams, announcements, etc.
// });




// Authentification
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');



// Authentification

// old Routes
// Route::post('/register', [AuthController::class, 'register']);
// // Route::post('/login/admin', [AuthController::class, 'login']);
// Route::post('/login/admin', [AuthController::class, 'adminLogin']);

// Route::post('/login/teacher', [AuthController::class, 'login']);

// Route::get('/admin/stats', [AdminController::class, 'stats'])->middleware('auth:sanctum');
// Route::get('/userse', [UserController::class, 'index'])->middleware('auth:sanctum');


// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', [AuthController::class, 'user']);
//     Route::post('/logout', [AuthController::class, 'logout']);

//     Route::get('/users', [UserController::class, 'user']);
//     Route::post('/users', [UserController::class, 'store']);
//     Route::delete('/users/{user}', [UserController::class, 'destroy']);


// });

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     // All admin-only routes here
//     Route::get('/admin/stats', [AdminController::class, 'stats']);
//     Route::get('/users', [UserController::class, 'index']);
//     Route::post('/users', [UserController::class, 'store']);
//     Route::delete('/users/{user}', [UserController::class, 'destroy']);
    
//     // Add other admin routes...
// });



// Route::middleware('auth:sanctum')->group(function () {
    
//     Route::get('/classes', [ClassController::class, 'index']);
//     Route::post('/classes', [ClassController::class, 'store']);
//     Route::delete('/classes/{class}', [ClassController::class, 'destroy']);

//     Route::get('/teachers', [TeacherController::class, 'index']);

// });














// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login/admin', [AuthController::class, 'adminLogin']);

// /* Authenticated Routes (All logged-in users) */
// Route::middleware('auth:sanctum')->group(function () {
//     // Common authenticated endpoints
//     Route::get('/user', [AuthController::class, 'user']);
//     Route::post('/logout', [AuthController::class, 'logout']);
    
//     // Teacher-specific routes
//     Route::middleware('teacher')->group(function () {
//         Route::get('/classes', [ClassController::class, 'index']);
//         Route::get('/teachers', [TeacherController::class, 'index']);
//     });

//     // Assignment routes for all authenticated users
//     Route::apiResource('assignments', AssignmentController::class);
// });

// /* Admin-Only Routes */
// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     // Admin dashboard
//     Route::get('/admin/stats', [AdminController::class, 'stats']);
    
//     // User management
//     Route::apiResource('users', UserController::class)->only([
//         'index', 'store', 'destroy'
//     ]);
    
//     // Class management
//     Route::apiResource('classes', ClassController::class)->only([
//         'store', 'destroy'
//     ]);

//     // Teacher management
//     Route::apiResource('teachers', TeacherController::class);
// });

// /* Special Admin Login/Logout */
// Route::post('/logout/admin', [AuthController::class, 'adminLogout'])
//     ->middleware(['auth:sanctum', 'admin']);







// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login/admin', [AuthController::class, 'adminLogin']);
Route::post('/login/teacher', [AuthController::class, 'teacherLogin']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Protected admin routes
    Route::get('/admin/stats', [AdminController::class, 'stats']);
    Route::get('/users', [UserController::class, 'index']);
    Route::apiResource('users', UserController::class);
    Route::get('/classes', [ClassController::class, 'index']);
    Route::get('/teachers', [TeacherController::class, 'index']);
    Route::post('/classes', [ClassController::class, 'store']);
    Route::delete('/classes/{class}', [ClassController::class, 'destroy']);    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::middleware(['auth:sanctum', 'teacher'])->group(function () {
//     Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard']);
//     // Other teacher routes...

//     Route::post('/logout', [AuthController::class, 'logout']);

// });
// Teacher routes
Route::middleware(['auth:sanctum', 'teacher'])->group(function () {
    Route::get('/teacher/stats', [TeacherController::class, 'stats']);
    Route::get('/teacher/classes', [TeacherController::class, 'classes']);
});