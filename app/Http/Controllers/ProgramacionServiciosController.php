<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramacionServicios;
use Illuminate\Support\Facades\Log;


class ProgramacionServiciosController extends Controller
{

    public function programacionservicios(int $id){

        Log::info('Este es el Id del conductor: '. $id);

        $programacion = DB::table('programacion_servicios')
            ->join('solicitudes_servicio', 'solicitudes_servicio.ID_SolSer', '=', 'programacion_servicios.FK_Servicio')
            ->join('sedes', 'sedes.Id_Sede', '=', 'solicitudes_servicio.FK_Sede')
            ->join('clientes', 'clientes.Id_Cliente', '=', 'solicitudes_servicio.FK_Cliente')
            ->where('programacion_servicios.FK_Conductor', $id)
            ->where('programacion_servicios.ProVehFecha', '2025-10-27')
            ->select('programacion_servicios.ProVehFecha', 'programacion_servicios.FK_Servicio', 'sedes.NombreSede', 'sedes.Direccion', 'clientes.razon_social', 'programacion_servicios.Orden', 'programacion_servicios.Distancia', 'programacion_servicios.Duracion')
            ->get();

        return response()->json([
            'servicio' => $programacion,
        ]);

        Log::info('Esta es la lista de servicios: ' . json_encode($programacion));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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

    public function createSolRes($residuo, $solser){

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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
    }
    
    /*
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
