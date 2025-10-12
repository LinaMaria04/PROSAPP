<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Mostrar el perfil del usuario autenticado
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load('cliente'); // Cargar la relación cliente
        return view('users.profile', compact('user'));

    }

    /**
     * Mostrar el formulario para editar el usuario
     */
    public function edit()
    {
        $user = Auth::user();
        $user->load('cliente'); // Cargar la relación cliente
        return view('perfil.edit', compact('user'));
    }

    /**
     * Actualizar la información del usuario
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->load('cliente'); // Cargar la relación cliente
        
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->Id_User.',Id_User',
            'ClientDocType' => 'nullable|string|max:50',
            'ClientDocumento' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048|mimes:jpeg,jpg,png,gif,webp',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar la contraseña actual si se está cambiando
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'La contraseña actual no es correcta'])
                    ->withInput();
            }
        }

        // Actualizar usuario
        $user->Nombre = $request->Nombre;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        //imagen de avatar
        if($request->hasfile('avatar')){
			if($user->avatar <> null && file_exists(public_path().'/img/ImagesProfile/'.$user->avatar)){
				unlink(public_path().'/img/ImagesProfile/'.$user->avatar);
			}
			$file = $request->file('avatar');
			$name = time().$file->getClientOriginalName();
			$file->move(public_path().'/img/ImagesProfile/',$name);
			$user->avatar = $name;
		}
        
        $user->save();

        // Actualizar datos del cliente si existe
        if ($user->cliente) {
            $cliente = $user->cliente;
            
            // Actualizamos los campos en la tabla clientes
            if ($request->filled('ClientDocType')) {
                $cliente->ClientDocType = $request->ClientDocType;
            }
            if ($request->filled('ClientDocumento')) {
                $cliente->ClientDocumento = $request->ClientDocumento;
            }
            if ($request->filled('telefono')) {
                $cliente->telefono = $request->telefono;
            }
            
            $cliente->save();
        }
        
        return redirect()->route('profile.show')->with('success', 'Información actualizada correctamente');
    }

    public static function IDUsuariologueado(){
        $user = Auth::user();
        if ($user) {
            return $user->UsRol;
        } else {
            return null;
        }
    }

    public function changeRol(Request $request, $usuarios){
        $user = User::where('Id_User', $usuarios)->first();
        if(!$user){
            abort(404);
        }
        $user->UsRol = $request->usrol;
        $user->save();
        return back();
    }
} 