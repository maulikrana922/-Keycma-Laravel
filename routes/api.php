<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\ImageController;

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

/**
 * Register/login Routes
 */
Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register')->name('api.register');
    Route::post('login', 'login')->name('api.login');
});

/**
 * Forgot/Reset Password Routes
 */
Route::controller(ForgotPasswordController::class)->group(function() {
    Route::post('forgot-password',  'forgotPassword')->name('api.forgot-password');
    Route::post('reset-password', 'resetPassword')->name('api.reset-password');
});

Route::middleware('auth:sanctum')->group(function() {
    // --
    // Logout API
    Route::get('logout',   [AuthController::class, 'logout'])->name('api.logout');

    // --
    // Upload images
    Route::get('images/{csv_id}', [ImageController::class, 'show']);
    Route::post('images', [ImageController::class, 'store'])->name('images.store');
});