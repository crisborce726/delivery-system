<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\ProfileController;

// Public Routes - Show Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public Authentication Routes (accessible only to guests)
Route::middleware(['guest'])->group(function () {
    // ✅ USER AUTHENTICATION ROUTES - FIXED NAMES
    Route::get('/register', [AuthController::class, 'showUserRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'userRegister'])->name('register.submit');

    Route::get('/login', [AuthController::class, 'showUserLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'userLogin'])->name('login.submit');

    // ✅ ADMIN AUTHENTICATION ROUTES - FIXED NAMES
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Logout Routes (accessible to authenticated users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// OTP Verification Routes (Protected by auth)
Route::get('/otp/verify', [OTPVerificationController::class, 'showVerificationForm'])->name('otp.verify.show');
Route::post('/otp/verify', [OTPVerificationController::class, 'verifyOTP'])->name('otp.verify.submit');
Route::post('/otp/resend', [OTPVerificationController::class, 'resendOTP'])->name('otp.resend');

// Development only route
if (app()->environment('local')) {
    Route::post('/otp/skip', [OTPVerificationController::class, 'skipVerification'])->name('otp.skip');
}

// ✅ PROTECTED USER ROUTES (with UserMiddleware)
Route::middleware(['auth', 'user', 'verified'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Protected routes for authenticated users
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
});

// ✅ PROTECTED ADMIN ROUTES (with AdminMiddleware)
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/stats', [DashboardController::class, 'getStats'])->name('admin.stats');
});


Route::middleware(['auth:admin', 'admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class)
        ->names('admin.users');
});

Route::middleware(['auth:admin', 'admin'])->prefix('admin')->group(function () {
    Route::resource('drivers', DriverController::class)->names('admin.drivers');
});


Route::middleware(['auth:admin', 'admin'])->prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class)->names('admin.categories');
});
