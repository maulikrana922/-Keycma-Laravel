<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Home Routes
 */
Route::get('/', function () {
    if (Auth::check()) {
        // return view('welcome');
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->name('home');



Route::group(['middleware' => ['guest']], function() {
    /**
     * Register Routes
     */
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');

    /**
     * Login Routes
     */
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');

    /**
     * Forgot Password Routes
     */
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password.post');

    /**
     * Reset Password Routes
     */
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password.post');

    // Verify email
    Route::get('/email/verify/{id}/{hash}', [ForgotPasswordController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Resend link to verify email
    Route::post('/email/verify/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');
});

Route::group(['middleware' => ['auth']], function() {

    /**
     * Home Routes
     */
    Route::get('/', [HomeController::class, 'index'])->name('home');

    /**
     * Logout Routes
     */
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
