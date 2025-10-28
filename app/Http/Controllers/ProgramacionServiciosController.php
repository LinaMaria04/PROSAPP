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

    public function detallesolicitud(int $id){
        Log::info('Este es el Id del la solicitud: '. $id);

        $solicitud = DB::table('solicitudes_servicio')
            ->join('sedes', 'sedes.Id_Sede', '=', 'solicitudes_servicio.FK_Sede')
            ->join('liquidacion_servicios', 'liquidacion_servicios.FK_SolSer', '=', 'solicitudes_servicio.ID_SolSer')
            ->where('solicitudes_servicio.ID_SolSer', $id)
            ->select('sedes.Direccion', 'liquidacion_servicios.TotalPagar', 'solicitudes_servicio.ID_SolSer')
            ->get();

        $residuos = DB::table('solicitud_residuos')
            ->join('residuos', 'residuos.ID_Respel', '=', 'solicitud_residuos.FK_Residuo')
            ->where('solicitud_residuos.FK_SolSer', $id)
            ->select('residuos.RespelName', 'solicitud_residuos.SolResKgEnviado', 'solicitud_residuos.SolResEmbalaje')
            ->get();

        Log::info('Estos son los datos para resumen de solicitud:'. $solicitud . 'Y estos son los residuos:'. $residuos);

        Log::info('Datos enviados al frontend:', [
            'solicitud' => $solicitud,
            'residuos' => $residuos,
        ]);
        
        return response()->json([
            'solicitud' => $solicitud->first(),
            'residuos' => $residuos->toArray(),
        ]);

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
