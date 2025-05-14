<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'Email' => 'required|email',
            'Contraseña' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'Email.required' => 'El campo correo electrónico es obligatorio.',
            'Email.email' => 'El correo electrónico debe ser una dirección válida.',
            'Contraseña.required' => 'El campo contraseña es obligatorio.',
            'Contraseña.confirmed' => 'La confirmación de la contraseña no coincide.',
            'Contraseña.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'Email',
            'Contraseña',
            'Contraseña_confirmation',
            'token'
        );
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingrese un correo electrónico válido.',
            'email.exists' => 'No encontramos un usuario registrado con este correo electrónico.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'El enlace de restablecimiento no es válido o ha expirado.']);
        }

        // Verificar si el token ha expirado (60 minutos)
        if (now()->isAfter(now()->subHours(1)->addMinutes(config('auth.passwords.users.expire', 60)))) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'El enlace de restablecimiento ha expirado.']);
        }

        $user = User::where('email', $request->email)->first();
        
        // Actualizar contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar el token usado
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('status', 'Tu contraseña ha sido restablecida exitosamente.');
    }
}
