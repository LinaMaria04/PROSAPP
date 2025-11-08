<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramacionServicios;
use App\Models\Certificados;
use App\Models\Solserrespel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Color\Color;
use PDF;


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
            ->select('residuos.RespelName', 'solicitud_residuos.SolResKgEnviado', 'solicitud_residuos.SolResEmbalaje', 'residuos.ID_Respel')
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

    public function anadirresiduo(Request $request, int $id){

        Log::info('Este es el Id de la solicitud para añadir residuo: '. $id);
        Log::info('Datos recibidos para añadir residuo: ', $request->all());

        $solicitudresiduo = DB::table('solicitud_residuos')
            ->where('FK_SolSer', $id)
            ->first();

        $residuo = DB::table('residuos')
            ->where('RespelName', $request['residuo'])
            ->first();

        Log::info('Este es el ID del residuo: '. $residuo->ID_Respel);

        $solserresiduo =  new Solserrespel();
        $solserresiduo->FK_SolSer = $id;
        $solserresiduo->SolResKgEnviado = $request['cantidad'];
        $solserresiduo->SolResKgRecibido = $request['cantidad'];
        $solserresiduo->SolResEmbalaje = $request['embalaje'];
        $solserresiduo->SolResSlug = hash('sha256', rand() . time() . $request['embalaje']);
        $solserresiduo->FK_Residuo = $residuo->ID_Respel;
        $solserresiduo->DeleteSolRes = 0;
        $solserresiduo->save();
    }

    public function conciliar (Request $request){
        Log::info('Datos recibidos para guardar firma: ', $request->all());

        $solicitud = DB::table('solicitudes_servicio')
            ->join('clientes', 'clientes.Id_Cliente', '=', 'solicitudes_servicio.FK_Cliente')
            ->join('sedes', 'sedes.Id_Sede', '=', 'solicitudes_servicio.FK_Sede')
            ->where('ID_SolSer', $request->id_solicitud)
            ->select('solicitudes_servicio.*', 'clientes.razon_social', 'clientes.Id_Cliente', 'sedes.NombreSede', 'sedes.Id_Sede')
            ->first();

        foreach ($request->residuos as $residuo) {
            DB::table('solicitud_residuos')
                ->where('FK_SolSer', $request->id_solicitud)
                ->where('FK_Residuo', $residuo['ID_Respel'])
                ->update(['SolResKgRecibido' => $residuo['SolResKgRecibido']]);
        }

        DB::table('solicitudes_servicio')
            ->where('ID_SolSer', $request->id_solicitud)
            ->update([
                'Estado' => 'conciliado',
            ]);

        $firmaPath = null;

        if (!empty($request->firma)) {
            // Quitar encabezado base64 si lo tiene
            $imageData = $request->firma;
            if (str_contains($imageData, ',')) {
                $imageData = explode(',', $imageData)[1];
            }

            $image = base64_decode($imageData);
            $fileName = 'FirmaCliente_' . time() . '.png';
            $path = 'FirmasClientes/' . $fileName;

            Storage::disk('public')->put($path, $image);

            $firmaPath = $path;
        }

        $Certificados = new Certificados();
        $Certificados->CertType = 1;
        $Certificados->CertiEspName = 'Certificado de Conciliación';
        $Certificados->CertiEspValue = 'Conciliado';
        $Certificados->CertObservacion = 'Certificado generado automáticamente tras la conciliación del servicio.';
        $Certificados->CertSlug = $firmaPath;
        $Certificados->FK_CertSolser = $request->id_solicitud;
        $Certificados->CertNumRm = null;
        $Certificados->CertSrc = null;
        $Certificados->CertAuthHseq = 1;
        $Certificados->CertAuthJl = 1;
        $Certificados->CertAuthDp = 1;
        $Certificados->CertAnexo = null;
        $Certificados->CertManifNumero = null;
        $Certificados->CertNumeroExt = null;
        $Certificados->CertManifPrepend = null;
        $Certificados->CertSrcManif = null;
        $Certificados->CertSrcExt = null;
        $Certificados->FK_CertSolser = $request->id_solicitud;
        $Certificados->FK_CertCliente = $solicitud->Id_Cliente;
        $Certificados->FK_CertGenerSede = $solicitud->Id_Sede;
        $Certificados->FK_CertGestor = null;
        $Certificados->FK_CertTrat = null;
        $Certificados->FK_CertTransp = NULL;
        $Certificados->save();

        $registroId = $Certificados->ID_Cert;

        $Certificados->CertNumero = $registroId;
        $Certificados->save();

        $this->certificadopdf($Certificados);

        return response()->json(['success' => true, 'message' => 'Conciliación completada y certificado generado.']);

    }

    public function certificadopdf($certificado)
    {
        $idsolser = $certificado->FK_CertSolser;

        $residuos = DB::table('solicitud_residuos')
            ->join('residuos', 'residuos.ID_Respel', '=', 'solicitud_residuos.FK_Residuo')
            ->where('solicitud_residuos.FK_SolSer', $idsolser)
            ->select(
                'residuos.RespelName',
                'residuos.YRespelClasf4741',
                'residuos.RespelEstado',
                'solicitud_residuos.SolResKgRecibido'
            )
            ->get();

        $datos = DB::table('solicitudes_servicio')
            ->join('clientes', 'clientes.Id_Cliente', '=', 'solicitudes_servicio.FK_Cliente')
            ->join('sedes', 'sedes.Id_Sede', '=', 'solicitudes_servicio.FK_Sede')
            ->join('programacion_servicios', 'programacion_servicios.FK_Servicio', '=', 'solicitudes_servicio.ID_SolSer')
            ->where('solicitudes_servicio.ID_SolSer', $idsolser)
            ->select(
                'clientes.razon_social',
                'clientes.ClientDocumento',
                'sedes.NombreSede',
                'sedes.Correo',
                'sedes.telefono',
                'sedes.Direccion',
                'programacion_servicios.ProVehFecha'
            )
            ->first();

        $firmaCliente = $certificado->CertSlug;

        Log::info('Esta es la ruta de la firma: '. $firmaCliente);

        $pdf = PDF::setPaper('letter', 'portrait')
            ->loadView('certificadosExpress.topdf', [
                'certificado' => $certificado,
                'datos' => $datos,
                'residuos' => $residuos,
                'firmaCliente' => $firmaCliente,
            ]);

        Storage::disk('public')->put(
            'certificadosExpress/E-' . sprintf('%07s', $certificado->ID_Cert) . '.pdf',
            $pdf->output()
        );
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
