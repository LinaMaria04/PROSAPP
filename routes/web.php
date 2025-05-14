<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SedesController;
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

//Rutas de roles
Route::post('/changerol', [rolescontroller::class, 'changeRol'])->name('changeRol');

// Grupo de rutas de autenticación
Route::middleware('guest')->group(function () {
    // Rutas de login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Rutas de registro
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Rutas de verificación de email
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');
});

// Rutas que requieren autenticación pero no verificación de email
Route::middleware(['auth'])->group(function () {
    // Completar perfil
    Route::get('/complete-profile', [AuthController::class, 'showCompleteProfileForm'])->name('complete-profile');
    Route::post('/complete-profile', [AuthController::class, 'completeProfile'])->name('complete-profile.submit');
});

// Rutas protegidas (requieren autenticación y verificación de email)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Recursos
    /* Rutas de personal movidas arriba sin protección temporalmente
    Route::resource('personal', PersonalController::class);
    Route::prefix('personal')->group(function () {
        Route::get('/search', [PersonalController::class, 'search'])->name('personal.search');
        Route::get('/export', [PersonalController::class, 'export'])->name('personal.export');
    });
    */
    
    Route::resource('roles', RoleController::class);

    // Rutas adicionales para roles
    Route::prefix('roles')->group(function () {
        Route::get('/permissions/{role}', [RoleController::class, 'permissions'])->name('roles.permissions');
        Route::post('/permissions/{role}', [RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
    });
});