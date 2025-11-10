<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Permisos;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = auth()->user();
        
        // Si es administrador, mostrar todos los usuarios
        if ($currentUser->UsRol === 'Administrador' || Permisos::check(Permisos::ADMINISTRADORES)) {
            $users = DB::table('users')
                ->where('DeleteUser', 0)
                ->orderBy('Id_User', 'asc')
                ->paginate(10);
        } 
        // Si es cliente, mostrar solo los usuarios asociados al cliente
        elseif (strtolower(trim($currentUser->UsRol)) === 'cliente') {
            // Buscar usuarios relacionados con el cliente actual
            // Por ahora, solo se muestra el usuario actual
            $users = DB::table('users')
                ->where('DeleteUser', 0)
                ->where(function($query) use ($currentUser) {
                    $query->where('Id_User', $currentUser->Id_User);
                })
                ->orderBy('Id_User', 'asc')
                ->paginate(10);
        } 
        // Para otros roles, solo mostrar su propio usuario
        else {
            $users = DB::table('users')
                ->where('DeleteUser', 0)
                ->where('Id_User', $currentUser->Id_User)
                ->orderBy('Id_User', 'asc')
                ->paginate(10);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = null;
        if (auth()->user()->UsRol === 'Administrador') {
            $roles = DB::table('roles')->pluck('Rol');
        }
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'Nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];

        if (Permisos::check(Permisos::ADMINISTRADORES)) {
            $rules['UsRol'] = 'required';
        }

        $request->validate($rules);

        $user = new User();
        $user->Nombre = $request->Nombre;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->UsRol = auth()->user()->UsRol === 'Administrador' ? $request->UsRol : 'cliente';
        $apellido = $request->Apellidos;
        $user->UserSlug = hash('sha256', rand().time().$apellido);
        $user->is_active = 1;
        $user->DeleteUser = 0;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('UserSlug', $id)->firstOrFail();
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Verificar si el usuario tiene permisos de administrador
        if (!Permisos::check(Permisos::ADMINISTRADORES)) {
            return redirect()->route('users.index')
                ->with('error', 'No tienes permiso para editar usuarios');
        }
        
        $user = User::where('UserSlug', $id)->firstOrFail();
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Verificar si el usuario tiene permisos de administrador
        if (!Permisos::check(Permisos::ADMINISTRADORES)) {
            return redirect()->route('users.index')
                ->with('error', 'No tienes permiso para actualizar usuarios');
        }
        
        $user = User::where('UserSlug', $id)->firstOrFail();
        
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->Id_User.',Id_User',
            'UsRol' => 'required',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->Nombre = $request->Nombre;
        $user->email = $request->email;
        $user->UsRol = $request->UsRol;
        $user->is_active = $request->is_active;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('UserSlug', $id)->firstOrFail();
        $user->DeleteUser = 1;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
    }

    public function createuser(Request $request)
    {
        Log::info('Información recibida para creación de usuario:', $request->all());


        $persona = new Personas();
        $persona->PrimerNombre = $request->nombres;
        $persona->Apellidos = $request->apellidos;
        $persona->PersDocType = $request->tipo_documento;
        $persona->PersDocNumber = $request->numero_documento;
        $persona->Telefono = $request->telefono;
        $persona->FK_PersCliente = 1;
        $persona->PersSlug = hash('sha256', rand().time().$request->apellidos);
        $persona->DeletePersona = 0;
        $persona->save();
        
        $user = new User();
        $user->Nombre = $request->nombres . ' ' . $request->apellidos;
        $user->email = $request->correo;
        $user->password = Hash::make('12345678');
        $user->UsRol = 'cliente';
        $user->UserSlug = hash('sha256', rand().time().$request->apellidos);
        $user->FK_UserPersona = $persona->Id_Peronsa;
        $user->is_active = 1;
        $user->DeleteUser = 0;
        $user->save();

        return response()->json(['message' => 'Usuario creado correctamente'], 201);
    }
}
