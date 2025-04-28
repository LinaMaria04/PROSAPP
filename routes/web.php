<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;

// Rutas públicas
Route::get('/', function () {
    return view('auth.login');
})->name('home');

// Rutas de Personal (sin protección temporalmente)
Route::resource('personal', PersonalController::class);
Route::prefix('personal')->group(function () {
    Route::get('/search', [PersonalController::class, 'search'])->name('personal.search');
    Route::get('/export', [PersonalController::class, 'export'])->name('personal.export');
});

// Grupo de rutas de autenticación
Route::middleware('guest')->group(function () {
    // Rutas de login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Rutas de registro
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Rutas de verificación de email
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
       ->middleware(['auth', 'throttle:6,1'])
       ->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');
});

// Rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    // Completar perfil
    Route::get('/complete-profile', [AuthController::class, 'showCompleteProfileForm'])->name('complete-profile');
    Route::post('/complete-profile', [AuthController::class, 'completeProfile'])->name('complete-profile.submit');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Recursos
    Route::resource('roles', RoleController::class);
    Route::prefix('roles')->group(function () {
        Route::get('/permissions/{role}', [RoleController::class, 'permissions'])->name('roles.permissions');
        Route::post('/permissions/{role}', [RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
    });
});