<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

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

    use ResetsPasswords;

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
}
