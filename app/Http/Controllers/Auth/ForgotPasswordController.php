<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('Email');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
        ];
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingrese un correo electrónico válido.',
            'email.exists' => 'No encontramos un usuario registrado con este correo electrónico.'
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(60);

        // Guardar el token en la base de datos
        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Enviar el correo
        try {
            Mail::send('emails.reset-password', ['user' => $user, 'token' => $token], function($message) use ($user) {
                $message->to($user->email);
                $message->subject('Restablecer Contraseña - ProsarApp');
            });

            return back()->with('status', 'Hemos enviado un enlace para restablecer tu contraseña por correo electrónico.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'No pudimos enviar el enlace de restablecimiento. Por favor, intenta nuevamente.']);
        }
    }
}
