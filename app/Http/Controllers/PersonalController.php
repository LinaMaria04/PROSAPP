<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Personal; 

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){

        $personal = DB::table('personas')
            ->where('DeletePersona', 0)
            ->orderBy('PrimerNombre', 'asc')
            ->paginate(10);

        return view('personal.index', compact('personal'));

    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('personal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        $persona = new Personal();
        $persona->PersDocType = $request->tipdoc;
        $persona->PersDocNumber = $request->numdoc;
        $persona->PrimerNombre = $request->primernombre;
        $persona->SegundoNombre = $request->segundonombre;
        $persona->Apellidos = $request->apellido;
        $persona->Telefono = $request->telefono;
        $persona->FK_PersCliente = 1;
        $persona->PersSlug = hash('sha256', rand().time().$request->apellido);
        $persona->DeletePersona = 0;
        $persona->save();

        return redirect()->route('personal.index')->with('success', 'Persona creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $persona = DB::table('personas')
            ->where('PersSlug', $id)
            ->first();

        //return $persona;    
        return view('personal.show', compact('persona'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $persona = DB::table('personas')
        ->where('PersSlug', $id)
        ->first();

        return view('personal.edit', compact('persona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
        DB::table('personas')
            ->where('PersSlug', $id)
            ->update([
                'PersDocType' => $request->tipdoc,
                'PersDocNumber' => $request->numdoc,
                'PrimerNombre' => $request->primernombre,
                'SegundoNombre' => $request->segundonombre,
                'Apellidos' => $request->apellido,
                'Telefono' => $request->telefono
            ]);
        return redirect()->route('personal.index')->with('success', 'Persona actualizada correctamente.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $persona = Personal::where('PersSlug', $id)->first();
       $persona->DeletePersona = 1;
       $persona->save();

       return redirect()->route('personal.index')->with('success', 'Persona eliminada correctamente.');
    }
}
