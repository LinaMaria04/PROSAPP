<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class rolescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public static function IDUsuariologueado(){

        $user = Auth::user();
        if ($user) {
            return $user->UsRol;
        } else {
            return null; // O maneja el caso de usuario no autenticado según tu lógica
        }

    }

    public function changeRol(Request $request){

        return $request;
		/*$user = User::where('UsSlug', $slug)->first();
		if (!$user) {
			abort(404);
		}
		$user->UsRol = $request->input('UsRol1');
		$user->UsRol2 = $request->input('UsRol2');
		$user->save();
		return back();*/
	}
}
