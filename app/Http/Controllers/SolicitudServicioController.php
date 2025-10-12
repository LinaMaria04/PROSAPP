<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Solser;
use App\Models\Solserrespel;
use Illuminate\Support\Facades\Log;


class SolicitudServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $servicios = DB::table('solicitudes_servicio')
            ->join('solicitud_residuos', 'solicitud_residuos.FK_SolSer', '=', 'solicitudes_servicio.ID_SolSer')
            ->select('*')
            ->get();

            return view('solicitudservicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = Auth::user()->Id_User;
        
        $sedes = DB::table('sedes')
            ->join('personas', 'personas.Id_Peronsa', '=', 'sedes.FK_Persona')
            ->join('clientes', 'clientes.Id_Cliente', '=', 'personas.FK_PersCliente')
            ->select('sedes.*')
            ->where('FK_Persona', $usuario)
            ->get();

        $residuos = DB::table('residuos')
            ->select('*')
            ->get();    

            //dd($usuario);
        return view('solicitudservicios.create', compact('sedes', 'residuos'));
    }

    public function sedescliente(){
        //$usuario = Auth::user()->Id_User;
        $sedes = DB::table('sedes')
            ->join('personas', 'personas.Id_Peronsa', '=', 'sedes.FK_Persona')
            ->join('clientes', 'clientes.Id_Cliente', '=', 'personas.FK_PersCliente')
            ->select('sedes.*')
            //->where('FK_Persona', $usuario)
            ->get();

        return response()->json([
            'sedes' => $sedes,
        ]);
    }

    public function residuos(){

        $residuos = DB::table('residuos')
            ->select('*')
            ->get();

        return response()->json([
            'residuos' => $residuos,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Información recibida para creación de servicio:', $request->all());

        //return $request;

        $servicio = new Solser();
        $servicio->NumFactura =  Null;
        $servicio->FechaSolicitud = now();
        $servicio->Estado = "aprobado";
        $servicio->Observaciones = "";
        $servicio->save();

        $this->createSolRes($request, $servicio->ID_SolSer);
    }

    public function createSolRes($request, $solser){

        $solserresiduo =  new Solserrespel();
        $solserresiduo->FK_SolSer = $solser;
        $solserresiduo->SolResKgEnviado = $request->cantidad;
        $solserresiduo->SolResKgRecibido = 0;
        $solserresiduo->SolResEmbalaje = $request->embalaje;
        $solserresiduo->SolResSlug = hash('sha256', rand() . time() . $request->frecserv);
        $solserresiduo->FK_Residuo = $request->id_residuo;
        $solserresiduo->DeleteSolRes = 0;
        $solserresiduo->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $servicio = DB::table('solicitudes_servicio')
            ->join('solicitud_residuos', 'solicitud_residuos.FK_SolSer', '=', 'solicitudes_servicio.ID_SolSer')
            ->join('residuos', 'residuos.ID_Respel', '=', 'solicitud_residuos.FK_Residuo')
            ->where('solicitudes_servicio.ID_SolSer', $id)
            ->select('*')
            ->first();  

        return view('solicitudservicios.show', compact('servicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $usuario = Auth::user()->Id_User;
        
        $sedes = DB::table('sedes')
            ->join('personas', 'personas.Id_Peronsa', '=', 'sedes.FK_Persona')
            ->join('clientes', 'clientes.Id_Cliente', '=', 'personas.FK_PersCliente')
            ->select('sedes.*')
            ->where('FK_Persona', $usuario)
            ->get();

            $servicio = DB::table('solicitudes_servicio')
            ->join('solicitud_residuos', 'solicitud_residuos.FK_SolSer', '=', 'solicitudes_servicio.ID_SolSer')
            ->join('residuos', 'residuos.ID_Respel', '=', 'solicitud_residuos.FK_Residuo')
            ->where('solicitudes_servicio.ID_SolSer', $id)
            ->select('*')
            ->first();

            $residuos = DB::table('residuos')
            ->select('*')
            ->get();

        return view('solicitudservicios.edit', compact('servicio', 'sedes', 'residuos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $request;
        $servicio = Solser::where('ID_SolSer', $id)->first();


        DB::table('solicitudes_servicio')
            ->where('ID_SolSer', $id)
            -update([
                'FechaSolicitud' =>$request->FechaSolicitud,
                'Estado' => $request->Estado,
            ]);

        DB::table('residuos')
            ->where('RespelSlug', $id)
            ->update([
                'RespelName' => $request->respelname,
                'RespelDescrip' => $request->respeldescripcion,
                'YRespelClasf4741' => $request->ClasificacionY,
                'ARespelClasf4741' => $request->ClasificacionA,
                'RespelIgrosidad' => $request->peligrosidad,
                'RespelEstado' => $request->estadofisico,
                'Cedula' => null,
                'RespelHojaSeguridad' => $hoja,
                'RespelTarj' => $tarj,
                'RespelFoto' => $foto,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
