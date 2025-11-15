<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sedes;
use Illuminate\Support\Facades\Log;

class SedesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $id)
    {
    Log::info('Si esta entrando a index sedes ' . $id);

        $user = DB::table('users')
            ->join('personas', 'personas.Id_Peronsa', '=', 'users.FK_UserPersona')
            ->where('users.Id_User', $id)
            ->select('personas.Id_Peronsa', 'users.Id_User')
            ->first();

        log::info('Usuario autenticado: ' . json_encode($user));

        $sedes = DB::table('sedes')
            ->join('personas', 'personas.Id_Peronsa', '=', 'sedes.FK_Persona')
            ->join('clientes', 'clientes.Id_Cliente', '=', 'personas.FK_PersCliente')
            ->where('DeleteSedes', 0)
            ->where('sedes.FK_Persona', $user->Id_Peronsa)
            ->orderBy('Id_Sede', 'asc')
            ->get();

        $cliente = DB::table('clientes')
            ->where('FK_ClienteUser', $user->Id_User)
            ->select('ClientDocType', 'ClientDocumento', 'razon_social', 'CorreoFE', 'telefono')
            ->first();

        Log::info('Estos son los resultados: ' . $sedes);
        
        Log::info('Este es el cliente: ' . json_encode($cliente));

        return response()->json([
            'sedes' => $sedes,
            'cliente' => $cliente,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('Si esta entrando a la creación de sedes');

        $user = auth()->user();

        $personas = DB::table('personas')
            ->join('clientes', 'personas.FK_PersCliente', '=', 'clientes.Id_Cliente')
            ->where('clientes.FK_ClienteUser', $user->Id_User)
            ->get();  

       /* $sedes = DB::table('sedes')
            ->where('DeleteSedes', 0)
            ->orderBy('Id_Sede', 'asc')
            ->get();
            
        $jsonSedes = json_encode($sedes); //Conivierte los datos de la consulta sedes a JSON para utilizarlos en el javascript del mapa    

       //return view('sedes.create', compact('personas', 'sedes'));*/

       return response()->json([
        'personas' => $personas,
       ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function personas()
    {
        Log::info('Si esta entrando a la creación de sedes');

        $user = auth()->user();

        $personas = DB::table('personas')
            ->join('clientes', 'personas.FK_PersCliente', '=', 'clientes.Id_Cliente')
            //->where('clientes.FK_ClienteUser', $user->Id_User)
            ->select('*')
            ->get();  

        Log::info('Estos son los resultados: ' . $personas);
       return response()->json([
        'personas' => $personas,
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Información recibida para creación de sede');
        //Desgloce de dirección seleccionada en el mapa
        $direccionmapa = $request->Direccion;

        $direccion = $request->Direccion;
        $localidad = $request->Localidad;
        $ciudad = "";

        $sede = new Sedes();
        $sede->FK_Persona = $request->Persona;
        $sede->NombreSede = $request->NombreSede;
        $sede->Direccion = $direccion;
        $sede->SedeMapAddressSearch = $request->Direccion;
        $sede->SedeMapAddressResult = $request->Direccion;
        $sede->SedeMapLat = $request->Latitud;
        $sede->SedeMapLong = $request->Longitud;
        $sede->SedeMapLocalidad = $localidad;
        $sede->SedeSlug = hash('sha256', rand() . time() . $direccion);
        $sede->Correo = $request->Correo;
        $sede->telefono = $request->Telefono;
        $sede->DeleteSedes = 0;
        $sede->save();

        Log::info('Sede Creada');

        return response()->json([
            'message' => 'Sede Creada',
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sede = DB::table('sedes')
            ->where('SedeSlug', $id)
            ->select('*')
            ->first();  

        $persona = DB::table('personas')    
            ->where('Id_Peronsa', $sede->FK_Persona)
            ->select('PrimerNombre', 'SegundoNombre', 'Apellidos')
            ->first();

        $jsonSede = json_encode($sede); //Conivierte los datos de la consulta sede a JSON para utilizarlos en el javascript del mapa

        return view('sedes.show', compact('sede', 'persona'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sede = DB::table('sedes')
            ->join('personas', 'personas.Id_Peronsa', '=', 'sedes.FK_Persona')
            ->where('Id_Sede', $id)
            ->select('*')
            ->first();

        Log::info('Estos son los datos de la sede seleccionada: ' . json_encode($sede));

        return response()->json([
            'sede' => $sede,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info('Información recibida' .$request . ' para Editar la sede'. $id);

        DB::table('sedes')
            ->where('Id_Sede', $id)
            ->update([
                'FK_Persona' => $request->Persona,
                'NombreSede' => $request->NombreSede,
                'Direccion' => $request->Direccion,
                'SedeMapAddressSearch' => $request->Direccion,
                'SedeMapAddressResult' => $request->Direccion,
                'SedeMapLat'=> $request->Latitud,
                'SedeMapLong' => $request->Longitud,
                'SedeMapLocalidad' => $request->Localidad,
                'Correo' => $request->Correo,
                'telefono' => $request->Telefono,
            ]);

        Log::info('Sede Actualizada');

        return response()->json([
            'message' => 'Sede Actualizada',
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $sede = Sedes::where('SedeSlug', $id)->first();
       $sede->DeleteSedes = 1;
       $sede->save();

       return redirect()->route('sedes.index')->with('success', 'Persona eliminada correctamente.');
    }
}
