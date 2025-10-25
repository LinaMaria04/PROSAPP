<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Solser;
use App\Models\Solserrespel;
use App\Models\Liquidacion;
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
        $residuos = $request->input('residuos');

        if (!$residuos || !is_array($residuos) || count($residuos) === 0) {
            return response()->json(['error' => 'Debe enviar al menos un residuo'], 400);
        }

        $sede = $residuos[0]['sede'] ?? null;

        $cantidad = 0;

        foreach ($residuos as $residuo){
            $cantidad = $cantidad + $residuo['cantidad'];
        }

        if (!$sede) {
            return response()->json(['error' => 'No se ha especificado la sede'], 400);
        }

        $servicio = new Solser();
        $servicio->NumFactura =  Null;
        $servicio->FechaSolicitud = now();
        $servicio->FK_Sede = $sede;
        $servicio->FK_Cliente = 1;
        $servicio->Estado = "aprobado";
        $servicio->Observaciones = "";
        $servicio->save();

        foreach ($residuos as $residuo) {
            $this->createSolRes($residuo, $servicio->ID_SolSer);
        }

        $this->liquidacionservicio($cantidad, $servicio->ID_SolSer);
        $this->programacion($cantidad, $servicio->ID_SolSer, $sede);

        return response()->json([
            'message' => 'Servicio creado correctamente',
            'solicitud_id' => $servicio->ID_SolSer
        ], 201);
    }

    public function createSolRes($residuo, $solser){

        $solserresiduo =  new Solserrespel();
        $solserresiduo->FK_SolSer = $solser;
        $solserresiduo->SolResKgEnviado = $residuo['cantidad'];
        $solserresiduo->SolResKgRecibido = 0;
        $solserresiduo->SolResEmbalaje = $residuo['embalaje'];
        $solserresiduo->SolResSlug = hash('sha256', rand() . time() . $residuo['embalaje']);
        $solserresiduo->FK_Residuo = $residuo['id_residuo'];
        $solserresiduo->DeleteSolRes = 0;
        $solserresiduo->save();
    }

    public function liquidacionservicio($cantidad, $solser){

        $tarifa = DB::table('tarifas')
            ->where('Categoria', 'like', $this->getCategoria($cantidad))
            ->first();

        $valor = $tarifa ? $tarifa->Costo : 0;

        $liquidacion = new Liquidacion();
        $liquidacion->FK_SolSer = $solser;
        $liquidacion->TotalKg = $cantidad;
        $liquidacion-> FK_Tarifas = $tarifa->ID_Tarifa;
        $liquidacion->TotalKgAdicional = 0;
        $liquidacion->TotalPagar = $valor;
        $liquidacion->LiquiServSlug = hash('sha256', rand() . time() . $solser);
        $liquidacion->FK_TipoPago = 1;
        $liquidacion->DeleteLiquiServ = 0;
        $liquidacion->save();

    }

    private function getCategoria($cantidad)
    {
        if ($cantidad >= 0 && $cantidad <= 12) {
            return '0 a 12';
        } elseif ($cantidad > 12 && $cantidad <= 20) {
            return '12 A 20';
        } elseif ($cantidad > 20 && $cantidad <= 40) {
            return '20 a 40';
        } elseif ($cantidad > 40 && $cantidad <= 60) {
            return '40 a 60';
        } elseif ($cantidad > 60 && $cantidad <= 100) {
            return '60 a 100';
        } elseif ($cantidad > 100 && $cantidad <= 150) {
            return '100 a 150';
        } else {
            return 'Otro';
        }
    }

    public function resumen(int $id){

        Log::info('Información recibida para resumen de solicitud:'. $id);

        $solicitud = DB::table('solicitudes_servicio')
            ->join('sedes', 'sedes.Id_Sede', '=', 'solicitudes_servicio.FK_Sede')
            ->join('liquidacion_servicios', 'liquidacion_servicios.FK_SolSer', '=', 'solicitudes_servicio.ID_SolSer')
            ->where('solicitudes_servicio.ID_SolSer', $id)
            ->select('sedes.Direccion', 'liquidacion_servicios.TotalPagar')
            ->get();

        $residuos = DB::table('solicitud_residuos')
            ->join('residuos', 'residuos.ID_Respel', '=', 'solicitud_residuos.FK_Residuo')
            ->where('solicitud_residuos.FK_SolSer', $id)
            ->select('residuos.RespelName', 'solicitud_residuos.SolResKgEnviado', 'solicitud_residuos.SolResEmbalaje')
            ->get();

        $programacion = DB::table('progamacion_vehiculos')->where('FK_Servicio', $id)->select('ProgVehFecha')->first();

        Log::info('Estos son los datos para resumen de solicitud:'. $solicitud . 'Y estos son los residuos:'. $residuos);

        Log::info('Datos enviados al frontend:', [
            'solicitud' => $solicitud,
            'residuos' => $residuos,
            'programacion' => $programacion->ProgVehFecha,
        ]);
        
        return response()->json([
            'solicitud' => $solicitud,
            'residuos' => $residuos,
            'programacion' => $programacion->ProgVehFecha,
        ]);
    }

    public function programacion($cantidad, $SolSer, $sede){

        /*$lunes = 'Usaquen', 'Suba', 'Engativa';
        $martes = 'Fontibón', 'Kennedy', 'Bosa';
        $miercoles = 'Chapinero', 'Barrios Unidos', 'Teusaquillo';
        $jueves = 'Puente Aranda', 'Los Martires', 'Santa Fe', 'Candelaria';
        $viernes = 'San Cristobal', 'Antonio Nariño', 'Rafael Uribe Uribe';
        $sabado = 'Ciudad Bolivar', 'Usme', 'Tunjuelito';*/

        $diasLocalidades = [
            'Monday' => [1, 11, 10],
            'Tuesday' => [9, 8, 7],
            'Wednesday' => [2, 12, 13],
            'Thursday' => [16, 14, 3, 17],
            'Friday' => [4, 15, 18],
            'Saturday' => [19, 5, 6],
        ];

        $localidad = DB::table('sedes')->select('SedeMapLocalidad')->where('Id_sede', $sede)->first();

        $diaProgramado = 'No programado';

        foreach ($diasLocalidades as $dia => $localidades) {
            if (in_array($localidad->SedeMapLocalidad, $localidades)) {
                $diaProgramado = $dia;
                break;
            }
        }

        $cantidad = $cantidad ?? 0;

        // Día inicial de programación (por ejemplo 'Tuesday')
        $diaActual = $diaProgramado;
        $intentos = 0; // seguridad para evitar bucles infinitos

        do {
            $vehiculo = DB::table('vehiculos')
                ->leftJoin('progamacion_vehiculos', function($join) use ($diaActual) {
                    $join->on('vehiculos.ID_Vehiculo', '=', 'progamacion_vehiculos.FK_Vehiculo')
                        ->where('progamacion_vehiculos.ProgVehDia', '=', $diaActual);
                })
                ->select(
                    'vehiculos.ID_Vehiculo',
                    'vehiculos.VehiCapacidad',
                    DB::raw('COALESCE(SUM(progamacion_vehiculos.ProgVehKgAsignados), 0) as KgOcupados')
                )
                ->groupBy('vehiculos.ID_Vehiculo', 'vehiculos.VehiCapacidad')
                ->havingRaw('vehiculos.VehiCapacidad - COALESCE(SUM(progamacion_vehiculos.ProgVehKgAsignados), 0) >= ?', [$cantidad])
                ->orderBy('KgOcupados', 'asc')
                ->first();

            // Si encuentra vehículo disponible, lo asigna
            if ($vehiculo) {
                DB::table('progamacion_vehiculos')->insert([
                    'FK_Vehiculo' => $vehiculo->ID_Vehiculo,
                    'FK_Servicio' => $SolSer,
                    'ProgVehDia' => $diaActual,
                    'ProgVehKgAsignados' => $cantidad,
                    'ProgVehFecha' => now()->next($diaActual)->toDateString(),
                    'ProgVehDelete' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $mensaje = "Servicio programado para el día $diaActual con el vehículo #{$vehiculo->ID_Vehiculo}";
                break;
            }

            // Si no hay vehículo, pasar al siguiente día
            $diaActual = now()->next($diaActual)->addDay()->format('l'); // ejemplo: Tuesday -> Wednesday
            $intentos++;

        } while (!$vehiculo && $intentos < 7); // máximo 7 días adelante

        // Si después de una semana no hay vehículo disponible
        if (!$vehiculo) {
            $mensaje = "No hay vehículos disponibles durante la próxima semana con capacidad suficiente.";
        }

        Log::info($mensaje);
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

    public function generarPago(int $id)
    {
        Log::info('=== Generar Pago Wompi ===');
        Log::info('ID recibido: ' . $id);

        $liquidacion = DB::table('liquidacion_servicios')
            ->where('FK_SolSer', $id)
            ->first();

        if (!$liquidacion) {
            return response()->json(['error' => 'Liquidación no encontrada'], 404);
        }

        $publicKey = env('WOMPI_PUBLIC_KEY');
        $integritySecret = env('WOMPI_INTEGRITY_SECRET');

        // Limpieza del valor y conversión a centavos
        $valor = preg_replace('/[^\d.]/', '', $liquidacion->TotalPagar);
        $amountInCents = (int) round(floatval($valor) * 100);
        $currency = 'COP';
        $reference = (string) $liquidacion->ID_LiquiServ;

        // Generar firma exacta según documentación oficial
        $cadena = $reference . $amountInCents . $currency . $integritySecret;
        $signature = hash('sha256', $cadena);

        $redirectUrl = "prosapp://pago-exitoso";

        // Construir la URL correctamente
        $query = http_build_query([
            'public-key' => $publicKey,
            'currency' => $currency,
            'amount-in-cents' => $amountInCents,
            'reference' => $reference,
            //'redirect-url' => $redirectUrl,
        ]);

        $urlPago = "https://checkout.wompi.co/p/?{$query}&signature:integrity={$signature}";

        Log::info('URL WOMPI FINAL: ' . $urlPago);

        return response()->json(['url_pago' => $urlPago]);
    }
    
    /*
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
