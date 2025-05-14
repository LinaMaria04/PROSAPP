<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SedesController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\rolescontroller;
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

//Rutas de sedes
Route::resource('sedes', SedesController::class);


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

    Route::get('/verify-email/{id}/{token}', [VerifyEmailController::class, 'verify'])
        ->name('verification.verify');

    // Rutas de recuperación de contraseña
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// Rutas que requieren autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    // Completar perfil
    Route::get('/complete-profile', [AuthController::class, 'showCompleteProfileForm'])->name('complete-profile');
    Route::post('/complete-profile', [AuthController::class, 'completeProfile'])->name('complete-profile.submit');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Perfil de usuario
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('users.update');

    // Recursos
    // Comentado temporalmente hasta que se implemente el RoleController
    /*
    Route::resource('roles', RoleController::class);
    Route::prefix('roles')->group(function () {
        Route::get('/permissions/{role}', [RoleController::class, 'permissions'])->name('roles.permissions');
        Route::post('/permissions/{role}', [RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
    });
    */
    
    // Administración de usuarios
    Route::resource('users', UsersController::class);   
    Route::post('/changerol/{id}', [UserController::class, 'changeRol'])->name('changeRol');
});