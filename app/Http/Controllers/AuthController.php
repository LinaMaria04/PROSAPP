<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Permisos;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $apellido = $request->Apellidos;
        $userSlug = hash('sha256', rand().time().$apellido);
        \Log::info('Slug final asignado: ' . $userSlug);

        $user = User::create([
            'Nombre' => $request->Nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'UserSlug' => $userSlug,
            'UsRol' => 'cliente',
            'is_active' => false,
        ]);

        // Generar token de verificación
        $verificationToken = Str::random(60);
        $user->verification_token = $verificationToken;
        $user->save();

        // Enviar correo de verificación
        try {
            Mail::send('emails.verify', ['user' => $user], function($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verifica tu correo electrónico');
            });
        } catch (\Exception $e) {
            // Si falla el envío del correo, continuamos pero registramos el error
            \Log::error('Error enviando correo de verificación: ' . $e->getMessage());
        }

        Auth::login($user);

        return redirect()->route('complete-profile')
            ->with('success', 'Por favor completa tu perfil y verifica tu correo electrónico.');
    }

    public function showCompleteProfileForm()
    {
        return view('auth.complete-profile');
    }

    public function completeProfile(Request $request)
    {
        $request->validate([
            'Nombre_Empresa' => 'required|string|max:255',
            'Nit' => 'required|string|max:20|unique:clientes',
            'Direccion' => 'required|string|max:255',
            'Telefono' => 'required|string|max:20',
            'Ciudad' => 'required|string|max:100',
            'Departamento' => 'required|string|max:100',
            'Representante_Legal' => 'required|string|max:255',
            'Email_Contacto' => 'required|email|max:255',
            'Telefono_Contacto' => 'required|string|max:20',
        ]);

        $cliente = Cliente::create([
            'Nombre_Empresa' => $request->Nombre_Empresa,
            'Nit' => $request->Nit,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'Ciudad' => $request->Ciudad,
            'Departamento' => $request->Departamento,
            'Representante_Legal' => $request->Representante_Legal,
            'Email_Contacto' => $request->Email_Contacto,
            'Telefono_Contacto' => $request->Telefono_Contacto,
            'FK_ClienteUser' => Auth::id(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Perfil completado exitosamente. Por favor verifica tu correo electrónico para activar tu cuenta.');
    }

    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Token de verificación inválido.');
        }

        $user->email_verified_at = now();
        $user->is_active = true;
        $user->verification_token = null;
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', 'Correo electrónico verificado exitosamente.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function apiLogin(Request $request)
{
    Log::info('Se llamó a apiLogin');
    Log::info('Intento de inicio de sesión API para: ' . $request->email);

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        Log::info('Usuario no encontrado: ' . $request->email);
        return response()->json([
            'message' => 'Credenciales inválidas.', // Respuesta genérica para seguridad
        ], 401);
    }

    if (!Hash::check($credentials['password'], $user->password)) {
        Log::info('Contraseña incorrecta para: ' . $request->email);
        return response()->json([
            'message' => 'Credenciales inválidas.', // Respuesta genérica para seguridad
        ], 401);
    }

    if (!$user->email_verified_at) {
        Log::info('Correo no verificado para: ' . $request->email);
        return response()->json([
            'message' => 'Por favor verifica tu correo electrónico.',
        ], 403);
    }
    
    if (property_exists($user, 'is_active') && !$user->is_active) {
        Log::info('Cuenta inactiva para: ' . $request->email);
        return response()->json([
            'message' => 'Tu cuenta está inactiva. Contacta al administrador.',
        ], 403);
    }

    if ($user->UsRol === 'cliente') {
        
        $cliente = DB::table('clientes')->where('FK_ClienteUser', $user->Id_User)->first();
        
        if (!$cliente) {
            return response()->json(['message' => 'No se encontró la información de cliente asociada.'], 404);
        }

        $personas = DB::table('personas')->where('FK_PersCliente', $cliente->Id_Cliente)->first();

        if (!$personas) {
            Log::info('Perfil incompleto para: ' . $request->email);
            return response()->json([
                'message' => 'Por favor completa tu perfil antes de iniciar sesión.',
                'user_id' => $user->Id_User,
                'rol' => $user->UsRol,
                'cliente' => $cliente->razon_social,
            ], 402);
        }
        
        Log::info('Inicio de sesión exitoso para cliente: ' . $request->email);
        return response()->json([
            'message' => 'Login exitoso',
            'user_id' => $user->Id_User,
            'rol' => $user->UsRol,
            'cliente' => $cliente->razon_social,
        ], 200);

    }
    else {
        Log::info('Inicio de sesión exitoso para rol: ' . $user->UsRol);
        return response()->json([
            'message' => 'Login exitoso',
            'user_id' => $user->Id_User,
            'rol' => $user->UsRol,
            'cliente' => 'PROSARC SA ESP', // Valor por defecto o nombre de la empresa
        ], 200);
    }
}

    public function login(Request $request)
    {
        \Log::info('Intento de inicio de sesión para: ' . $request->email);
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verificar si el usuario existe
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            \Log::info('Usuario no encontrado: ' . $request->email);
            return back()->withErrors([
                'email' => 'El correo electrónico no está registrado en nuestro sistema.',
            ])->withInput($request->only('email'));
        }

        // Verificar la contraseña
        if (!Hash::check($request->password, $user->password)) {
            \Log::info('Contraseña incorrecta para: ' . $request->email);
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ])->withInput($request->only('email'));
        }

        // Verificar si el correo está verificado
        if (!$user->email_verified_at) {
            \Log::info('Correo no verificado para: ' . $request->email);
            return back()->withErrors([
                'email' => 'Por favor verifica tu correo electrónico antes de iniciar sesión.',
            ])->withInput($request->only('email'));
        }

        // Verificar si la cuenta está activa
        if (!$user->is_active) {
            \Log::info('Cuenta inactiva para: ' . $request->email);
            return back()->withErrors([
                'email' => 'Tu cuenta está inactiva. Por favor contacta al administrador.',
            ])->withInput($request->only('email'));
        }

        // Si todo está correcto, iniciar sesión
        \Log::info('Iniciando sesión para: ' . $request->email);
        Auth::login($user);
        $request->session()->regenerate();
        
        // Verificar si el usuario tiene un perfil completo
        if ($user->UsRol === 'cliente' && $user->FK_UserPersona === null) {
            \Log::info('Redirigiendo a complete-profile para: ' . $request->email);
            return redirect()->route('personal.create');
        }

        // Redirigir a la página de usuarios
        \Log::info('Redirigiendo a users.index para: ' . $request->email);
        return redirect()->route('users.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 