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
    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);

        if (!$user || $user->verification_token !== $hash) {
            return redirect()->route('login')
                ->with('error', 'El enlace de verificación no es válido.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')
                ->with('info', 'Tu correo electrónico ya ha sido verificado anteriormente.');
        }

        $user->email_verified_at = now();
        $user->is_active = true;
        $user->verification_token = null;
        $user->save();

        return redirect()->route('login')
            ->with('success', '¡Tu correo electrónico ha sido verificado exitosamente! Ahora puedes iniciar sesión.');
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
