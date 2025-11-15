<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Personal;
use Illuminate\Support\Facades\Log;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Log::info('Si esta entrando a editar cliente ' . $id);

        $cliente = DB::table('clientes')
            ->where('razon_social', $id)
            ->first();

        Log::info('Estos son los resultados: ' . json_encode($cliente));

        return response()->json([
            'cliente' => $cliente,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info('Si esta entrando a actualizar cliente ' . $id . ' Estos son los datos: ' . json_encode($request->all()));

        DB::table('clientes')
            ->where('razon_social', $id)
            ->update([
                'ClientDocType' => $request->tipo_documento,
                'ClientDocumento' => $request->numero_documento,
                'razon_social' => $request->razon_social,
                'CorreoFE' => $request->correo,
                'telefono' => $request->telefono,
            ]);

        Log::info('Cliente actualizado: ' . $id);

        return response()->json([
            'message' => 'Cliente actualizado correctamente.',
        ]);
    
        
    }

    public function estadisticas(string $id)
    {
        Log::info('Obteniendo estadisticas para el cliente: ' . $id);

        $totalServicios = DB::table('solicitudes_servicio')
            ->join('clientes','clientes.Id_Cliente', '=', 'solicitudes_servicio.FK_Cliente')
            ->where('razon_social', $id)
            ->select('solicitudes_servicio.*')
            ->count();

        $totalCertificados = DB::table('certificados')
            ->join('clientes','clientes.Id_Cliente', '=', 'certificados.FK_CertCliente')
            ->where('razon_social', $id)
            ->select('certificados.*')
            ->count();

        $totalPagos = DB::table('liquidacion_servicios')
            ->join('solicitudes_servicio','solicitudes_servicio.ID_SolSer', '=', 'liquidacion_servicios.FK_SolSer')
            ->join('clientes','clientes.Id_Cliente', '=', 'solicitudes_servicio.FK_Cliente')
            ->where('razon_social', $id)
            ->select('liquidacion_servicios.*')
            ->count();

        Log::info('Estadisticas obtenidas para el cliente: ' . $id);

        return response()->json([
            'total_servicios' => $totalServicios,
            'servicios_certificados' => $totalCertificados,
            'servicios_pagos' => $totalPagos,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
