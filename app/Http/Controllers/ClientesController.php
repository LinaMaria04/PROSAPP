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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
