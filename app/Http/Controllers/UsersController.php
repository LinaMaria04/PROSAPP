<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')
            ->where('DeleteUser', 0)
            ->orderBy('Id_User', 'asc')
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'UsRol' => 'required',
        ]);

        $user = new User();
        $user->Nombre = $request->Nombre;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->UsRol = $request->UsRol;
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
        $user = User::where('UserSlug', $id)->firstOrFail();
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('UserSlug', $id)->firstOrFail();
        
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->Id_User.',Id_User',
            'UsRol' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->Nombre = $request->Nombre;
        $user->email = $request->email;
        $user->UsRol = $request->UsRol;
        
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
}
