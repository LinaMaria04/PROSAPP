<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ServiciosRealizadosExport;
use App\Exports\PagosRealizadosExport;
use App\Exports\RegistroGeneradoresExport;


class ReportesController extends Controller
{

    public function serviciosrealizados(string $cliente){

        Log::info('Este es el cliente a consultar: ' . $cliente);

        return Excel::download(new ServiciosRealizadosExport($cliente), 'servicios_realizados.xlsx');
    }

    public function pagosrealizados(string $cliente){

        Log::info('Este es el cliente a consultar: ' . $cliente);

        return Excel::download(new PagosRealizadosExport($cliente), 'pagos_realizados.xlsx');

    }

    public function registroGeneradores(string $cliente){

        Log::info('Este es el cliente a consultar: ' . $cliente);

        return Excel::download(new RegistroGeneradoresExport($cliente), 'pregsitro_generador.xlsx');

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

    public function update(Request $request, string $id)
    {

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
