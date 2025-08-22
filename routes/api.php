<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SedesController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'apiLogin']);
//Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//Rutas de SEDES
Route::get('/sedespersonas', [SedesController::class, 'personas']);
Route::post('/sedes/create', [SedesController::class, 'store']);
Route::get('/empresasedes', [sedesController::class, 'index']);

Route::get('/ping', function () {
    return response()->json(['message' => 'API activa']);
});

// Rutas de registro
Route::prefix('auth')->middleware(['web'])->group(function () {
    // Paso 1: Datos del cliente
    Route::post('/register/step1', [RegisterController::class, 'storeStep1']);
    // Obtener tipos de documento
    Route::get('/register/tipos-documento', [RegisterController::class, 'getTiposDocumento']);
    // Obtener tipos de comercio
    Route::get('/register/tipos-comercio', [RegisterController::class, 'getTiposComercio']);
    // Paso 2: Datos de acceso
    Route::post('/register/step2', [RegisterController::class, 'storeStep2']);
});
