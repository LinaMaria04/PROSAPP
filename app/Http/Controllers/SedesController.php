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
    public function index()
    {
        $user = auth()->user();

        if($user->UsRol == 'Administrador'){
            $sedes = DB::table('sedes')
            ->where('DeleteSedes', 0)
            ->orderBy('Id_Sede', 'asc')
            ->paginate(10);

        return view('sedes.index', compact('sedes'));

        } else {

        $sedes = DB::table('sedes')
            ->join('personas', 'personas.Id_Peronsa', '=', 'sedes.FK_Persona')
            ->join('clientes', 'clientes.Id_Cliente', '=', 'personas.FK_PersCliente')
            ->where('DeleteSedes', 0)
            ->where('clientes.FK_ClienteUser', $user->Id_User)
            ->orderBy('Id_Sede', 'asc')
            ->paginate(10);

        return view('sedes.index', compact('sedes'));
        }
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
            ->where('SedeSlug', $id)
            ->select('*')
            ->first();

        $personas = DB::table('personas')
            ->where('DeletePersona', 0)
            ->orderBy('Id_Peronsa', 'asc')
            ->get();
    
        $jsonSede = json_encode($sede); //Conivierte los datos de la consulta sede a JSON para utilizarlos en el javascript del mapa

        return view('sedes.edit', compact('sede', 'personas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        //Desgloce de dirección seleccionada en el mapa
        $direccionmapa = explode(',', $request->SedeMapAddressSearch);
        $direccion = $direccionmapa[0];
        $localidad = $direccionmapa[1];
        $ciudad = $direccionmapa[2];

        DB::table('sedes')
            ->where('SedeSlug', $id)
            ->update([
                'FK_Persona' => $request->persencargada,
                'NombreSede' => $request->sedename,
                'Direccion' => $direccion,
                'SedeMapAddressSearch' => $request->SedeMapAddressSearch,
                'SedeMapAddressResult' => $request->SedeMapAddressSearch,
                'SedeMapLat'=> $request->latitud,
                'SedeMapLong' => $request->longitud,
                'SedeMapLocalidad' => $localidad,
                'Correo' => $request->correo,
                'telefono' => $request->telefono,
            ]);

            return redirect()->route('sedes.index')->with('success', 'Persona actualizada correctamente.');
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
