<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify($id, $token)
    {
        $user = User::where('Id_User', $id)->firstOrFail();

        // Verificar si el usuario ya está verificado
        if ($user->email_verified_at !== null) {
            return redirect()->route('login')
                ->with('status', 'Tu correo electrónico ya ha sido verificado anteriormente.');
        }

        // Verificar el token
        if ($user->verification_token !== $token) {
            return redirect()->route('login')
                ->with('error', 'El enlace de verificación no es válido.');
        }

        // Actualizar el usuario
        $user->email_verified_at = now();
        $user->verification_token = null; // Opcional: limpiar el token después de usarlo
        $user->save();

        return redirect()->route('login')
            ->with('status', '¡Tu correo electrónico ha sido verificado exitosamente! Ya puedes iniciar sesión.');
    }

    public function resend(Request $request)
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard')
                ->with('info', 'Tu correo electrónico ya ha sido verificado.');
        }

        // Generar nuevo token y enviar correo
        $verificationToken = Str::random(60);
        $user->verification_token = $verificationToken;
        $user->save();

        Mail::send('emails.verify', ['user' => $user], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verifica tu correo electrónico');
        });

        return back()->with('success', 'Se ha enviado un nuevo enlace de verificación a tu correo electrónico.');
    }
}
