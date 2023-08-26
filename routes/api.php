<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\EmailVerificationController;
use App\Http\Controllers\API\NewPasswordController;

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

//API route for register new user
Route::post('/register', [AuthController::class, 'register'])->middleware(['cors']);
//API route for login user
Route::post('/login', [AuthController::class, 'login'])->middleware(['cors']);

//API route for verification notification
Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
//API route for verify email
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

//API route for forgot password user
Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword'])->middleware(['cors']);
//API route for reset password user
Route::post('reset-password', [NewPasswordController::class, 'reset'])->middleware(['cors']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    })->middleware(['cors']);


    // Attendance
    Route::prefix('attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->middleware(['cors']);
        Route::get('/show/{id}', [AttendanceController::class, 'show'])->middleware(['cors']);
        Route::get('/show-user', [AttendanceController::class, 'showByUser'])->middleware(['cors']);
        Route::post('/store', [AttendanceController::class, 'store'])->middleware(['cors']);
        Route::post('/update/{id}', [AttendanceController::class, 'update'])->middleware(['cors']);
        Route::delete('/delete/{id}', [AttendanceController::class, 'destroy'])->middleware(['cors']);
    });
    // Users
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware(['cors']);
        Route::get('/show/{id}', [UserController::class, 'show'])->middleware(['cors']);
        Route::post('/store', [UserController::class, 'store'])->middleware(['cors']);
        Route::post('/update/{id}', [UserController::class, 'update'])->middleware(['cors']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->middleware(['cors']);
    });


    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['cors']);
});
