<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SedesController;
use App\Http\Controllers\SolicitudServicioController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\WompiController;
use App\Http\Controllers\ProgramacionServiciosController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClientesController;


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
Route::get('/empresasedes/{id}', [sedesController::class, 'index']);
Route::get('/sede/edit/{id}', [sedesController::class, 'edit']);
Route::post('/sede/updated/{id}', [sedesController::class, 'update']);

//Rutas de Servicios
Route::get('/servicios/sedes/{id}', [SolicitudServicioController::class, 'sedescliente']);
Route::get('/servicios/residuos', [SolicitudServicioController::class, 'residuos']);
Route::post('/servicios/create', [SolicitudServicioController::class, 'store']);
Route::get('/servicios/resumen/{id}', [SolicitudServicioController::class, 'resumen']);
Route::get('/servicios/pago/{id}', [SolicitudServicioController::class, 'generarPago']);
Route::get('/servicios/index/{id}', [SolicitudServicioController::class, 'index']);
Route::get('/servicios/certificados/{id}', [SolicitudServicioController::class, 'certificados']);
Route::get('/servicios/certificados/view/{id}', [SolicitudServicioController::class, 'viewcertificado']);

//Rutas de Pagos
Route::post('/wompi/create-payment-link', [WompiController::class, 'createPaymentLink']);
Route::post('/wompi/webhook', [WompiController::class, 'webhook']);
Route::get('/wompi/callback', [WompiController::class, 'callback'])->name('wompi.callback');

//Ruta de servicios - Conductores
Route::get('/servicios/programacion/{id}', [ProgramacionServiciosController::class, 'programacionservicios']);
Route::get('/servicios/detalles/{id}', [ProgramacionServiciosController::class, 'detallesolicitud']);
Route::post('/servicios/anadirResiduo/{id}', [ProgramacionServiciosController::class, 'anadirresiduo']);
Route::post('/servicios/guardarFirma', [ProgramacionServiciosController::class, 'conciliar']);

//Rutas de usuarios
Route::post('/usuarios/create', [UsersController::class, 'createuser']);
Route::post('/users/registro', [UsersController::class, 'registroUsuario']);
Route::post('/users/confirmarcorreo', [UsersController::class, 'confirmarcorreo']);
Route::post('/users/actualizarpassword', [UsersController::class, 'actualizarpassword']);

//Rutas de Clientes
Route::get('/cliente/editar/{id}', [ClientesController::class, 'edit']);
Route::post('/cliente/update/{id}', [ClientesController::class, 'update']);
Route::get('/cliente/estadisticas/{id}', [ClientesController::class, 'estadisticas']);
Route::post('/cliente/personacreate/{id}/{clientname}', [ClientesController::class, 'createPerson']);


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
