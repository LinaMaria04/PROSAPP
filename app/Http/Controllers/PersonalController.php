<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $persona = Personal::all();
        return view('personal.index', compact('persona'));
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
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:personal',
            'telefono' => 'required'
        ]);

        Personal::create($request->all());
        return redirect()->route('personal.index')
            ->with('success', 'Personal creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Personal $personal)
    {
        $persona = $personal;
        return view('personal.show', compact('persona'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personal $personal)
    {
        $persona = $personal;
        return view('personal.edit', compact('persona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personal $personal)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:personal,email,' . $personal->id,
            'telefono' => 'required'
        ]);

        $personal->update($request->all());
        return redirect()->route('personal.index')
            ->with('success', 'Personal actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personal $personal)
    {
        $personal->delete();
        return redirect()->route('personal.index')
            ->with('success', 'Personal eliminado exitosamente.');
    }
}
