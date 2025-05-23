<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FacturacionController extends Controller
{
    /**
     * Mostrar información de facturación
     */
    public function show()
    {
        $user = Auth::user();
        $user->load('cliente');
        // Si el usuario no tiene rol Cliente, redirigir al perfil
        if (strtolower(trim($user->UsRol)) != 'cliente' && strtolower(trim($user->UsRol)) != 'clientes') {
            return redirect()->route('profile.show')
                ->with('error', 'Esta sección es solo para usuarios con rol Cliente');
        }        
        return view('facturacion.show', compact('user'));
    }    
    /**
     * Mostrar formulario para editar información de facturación
     */
    public function edit()
    {
        $user = Auth::user();
        $user->load('cliente');
       // Si el usuario no tiene rol Cliente, redirigir al perfil
        if (strtolower(trim($user->UsRol)) != 'cliente' && strtolower(trim($user->UsRol)) != 'clientes') {
            return redirect()->route('profile.show')
                ->with('error', 'Esta sección es solo para usuarios con rol Cliente');
        }
        return view('facturacion.edit', compact('user'));
    }
    /**
     * Actualizar información de facturación
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->load('cliente');
     
        // Si el usuario no tiene rol Cliente, redirigir al perfil
        if (strtolower(trim($user->UsRol)) != 'cliente' && strtolower(trim($user->UsRol)) != 'clientes') {
            return redirect()->route('profile.show')
                ->with('error', 'Esta sección es solo para usuarios con rol Cliente');
        }
        
        $rules = [
            'TipoFacturacion' => 'nullable|string|in:Natural,Jurídica',
            'razon_social' => 'nullable|string|max:255',
            'CorreoFE' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255'
        ];
        
        // Si el tipo de facturación es Jurídica, validar el RUT
        if ($request->input('TipoFacturacion') === 'Jurídica') {
            $rules['ClientRut_file'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Crear cliente si no existe
        if (!$user->cliente) {
            $cliente = new Cliente();
            $cliente->FK_ClienteUser = $user->Id_User;
        } else {
            $cliente = $user->cliente;
        }
        
        // Actualizar datos del cliente
        if ($request->filled('TipoFacturacion')) {
            $cliente->TipoFacturacion = $request->TipoFacturacion;
        }
        if ($request->filled('razon_social')) {
            $cliente->razon_social = $request->razon_social;
        }
        if ($request->filled('CorreoFE')) {
            $cliente->CorreoFE = $request->CorreoFE;
        }
        if ($request->filled('direccion')) {
            $cliente->direccion = $request->direccion;
        }
        
        // Guardar archivo RUT si fue proporcionado
        if ($request->hasFile('ClientRut_file')) {
            if ($cliente->ClientRut && file_exists(public_path().'/documentos/rut/'.$cliente->ClientRut)) {
                unlink(public_path().'/documentos/rut/'.$cliente->ClientRut);
            }
            
            $file = $request->file('ClientRut_file');
            $name = 'RUT_'.$user->Id_User.'_'.time().'.'.$file->getClientOriginalExtension();
            
            // Crear directorio si no existe
            if (!file_exists(public_path().'/documentos/rut/')) {
                mkdir(public_path().'/documentos/rut/', 0777, true);
            }
            
            $file->move(public_path().'/documentos/rut/', $name);
            $cliente->ClientRut = $name;
        }
        
        $cliente->save();
        
        return redirect()->route('facturacion.show')
            ->with('success', 'Información de facturación actualizada correctamente');
    }
} 