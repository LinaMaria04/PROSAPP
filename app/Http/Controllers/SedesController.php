<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sedes;

class SedesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedes = DB::table('sedes')
            ->where('DeleteSedes', 0)
            ->orderBy('Id_Sede', 'asc')
            ->paginate(10);

        return view('sedes.index', compact('sedes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $personas = DB::table('personas')
            ->where('DeletePersona', 0)
            ->orderBy('Id_Peronsa', 'asc')
            ->get();

        return view('sedes.create', compact('personas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Desgloce de dirección seleccionada en el mapa
        $direccionmapa = explode(',', $request->SedeMapAddressSearch);
        $direccion = $direccionmapa[0];
        $localidad = $direccionmapa[1];
        $ciudad = $direccionmapa[2];

        $sede = new Sedes();
        $sede->FK_Persona = $request->persencargada;
        $sede->NombreSede = $request->sedename;
        $sede->Direccion = $direccion;
        $sede->SedeMapAddressSearch = $request->SedeMapAddressSearch;
        $sede->SedeMapAddressResult = $request->SedeMapAddressSearch;
        $sede->SedeMapLat = $request->latitud;
        $sede->SedeMapLong = $request->longitud;
        $sede->SedeMapLocalidad = $localidad;
        $sede->SedeSlug = hash('sha256', rand() . time() . $direccion);
        $sede->Correo = $request->correo;
        $sede->telefono = $request->telefono;
        $sede->DeleteSedes = 0;
        $sede->save();

        return redirect()->route('sedes.index')->with('success', 'Sede creada correctamente.');

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
