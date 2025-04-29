<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if (!$user->email_verified_at) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Por favor verifica tu correo electrónico antes de iniciar sesión.');
            }
        }

        return $next($request);
    }
}
