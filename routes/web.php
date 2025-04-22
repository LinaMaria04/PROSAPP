<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RoleController;

/*Route::get('/', function () {
    return ['Laravel' => app()->version()];
});*/

// Ruta principal - Redirige al login
Route::get('/', function () {
    return view('auth.login');
});

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas de Personal
    Route::resource('personal', PersonalController::class);
    
    // Rutas de Roles
    Route::resource('roles', RoleController::class);
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
