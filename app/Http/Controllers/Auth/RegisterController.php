<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use App\Models\TipoComercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('api');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'Nombre' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'Contraseña' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'Nombre' => $data['Nombre'],
            'Email' => $data['Email'],
            'Contraseña' => Hash::make($data['Contraseña']),
        ]);
    }

    // Obtener tipos de documento para el select
    public function getTiposDocumento()
    {
        try {
            $tipos = [
                'CC' => 'Cédula de Ciudadanía',
                'CE' => 'Cédula de Extranjería',
                'NIT' => 'NIT',
                'PP' => 'Pasaporte'
            ];

            return response()->json([
                'success' => true,
                'data' => $tipos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    // Obtener tipos de comercio para el select
    public function getTiposComercio()
    {
        try {
            $tiposComercio = TipoComercio::select('Id_Comercio as value', 'Comercio as label', 'Descripción as description')
                ->where('DeleteComercio', 0)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $tiposComercio
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    // Paso 1: Validar y almacenar temporalmente los datos del cliente
    public function storeStep1(Request $request)
    {
        try {
            $messages = [
                'ClientDocumento.unique' => 'Este número de documento ya está registrado en nuestro sistema.',
                'ClientDocumento.required' => 'El número de documento es obligatorio.',
                'ClientDocType.required' => 'El tipo de documento es obligatorio.',
                'razon_social.required' => 'La razón social es obligatoria.',
                'direccion.required' => 'La dirección es obligatoria.',
                'telefono.required' => 'El teléfono es obligatorio.',
                'FK_TipoComercio.required' => 'El tipo de comercio es obligatorio.',
                'FK_TipoComercio.exists' => 'El tipo de comercio seleccionado no es válido.'
            ];

            $validatedData = $request->validate([
                'ClientDocType' => ['required', 'string'],
                'ClientDocumento' => ['required', 'string', 'unique:clientes'],
                'razon_social' => ['required', 'string', 'max:255'],
                'direccion' => ['required', 'string'],
                'telefono' => ['required', 'string'],
                'FK_TipoComercio' => ['required', 'exists:tipo_comercio,Id_Comercio'],
            ], $messages);

            // Almacenar datos en sesión
            $request->session()->put('register_step1', $validatedData);
            
            // Forzar que la sesión se guarde inmediatamente
            $request->session()->save();

            return response()->json([
                'success' => true,
                'message' => 'Datos del cliente validados correctamente',
                'next_step' => true,
                'session_data' => $request->session()->get('register_step1'),
                'session_id' => $request->session()->getId()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error en storeStep1', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    // Paso 2: Completar el registro
    public function storeStep2(Request $request)
    {
        try {
            // Verificar si existen los datos del paso 1
            if (!$request->session()->has('register_step1')) {
                \Log::error('Sesión del paso 1 no encontrada', [
                    'session_id' => $request->session()->getId(),
                    'all_session_data' => $request->session()->all()
                ]);
                
                return response()->json([
                    'success' => false,
                    'errors' => ['general' => ['Debe completar el paso 1 primero']],
                    'debug_info' => [
                        'session_id' => $request->session()->getId(),
                        'has_step1' => $request->session()->has('register_step1')
                    ]
                ], 422);
            }

            $step1Data = $request->session()->get('register_step1');
            
            if (empty($step1Data)) {
                \Log::error('Datos del paso 1 vacíos', [
                    'session_id' => $request->session()->getId()
                ]);
                return response()->json([
                    'success' => false,
                    'errors' => ['general' => ['Los datos del paso 1 están incompletos']]
                ], 422);
            }

            // Validar datos del paso 2
            try {
                $messages = [
                    'Email.required' => 'El correo electrónico es obligatorio.',
                    'Email.email' => 'Por favor, ingrese un correo electrónico válido.',
                    'Email.unique' => 'Este correo electrónico ya está registrado en nuestro sistema.',
                    'Email.max' => 'El correo electrónico no puede tener más de :max caracteres.'
                ];

                $validatedData = $request->validate([
                    'Email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'Contraseña' => ['required', 'confirmed', Rules\Password::defaults()],
                ], $messages);
            } catch (ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }

            DB::beginTransaction();
            try {
                // Crear el usuario
                $user = User::create([
                    'Nombre' => $step1Data['razon_social'],
                    'Email' => $validatedData['Email'],
                    'Contraseña' => Hash::make($validatedData['Contraseña']),
                    'UserSlug' => strtolower(str_replace(' ', '-', $step1Data['razon_social'])),
                    'UsRol' => 'cliente',
                    'is_active' => true,
                    'email_verified_at' => now()
                ]);

                // Crear el cliente asociado
                $cliente = Cliente::create([
                    'ClientDocType' => $step1Data['ClientDocType'],
                    'ClientDocumento' => $step1Data['ClientDocumento'],
                    'razon_social' => $step1Data['razon_social'],
                    'direccion' => $step1Data['direccion'],
                    'telefono' => $step1Data['telefono'],
                    'FK_TipoComercio' => $step1Data['FK_TipoComercio'],
                    'ClientSlug' => strtolower(str_replace(' ', '-', $step1Data['razon_social'])),
                    'FK_ClienteUser' => $user->Id_User,
                    'ClientStatus' => 'activo'
                ]);

                DB::commit();

                // Limpiar datos de sesión
                $request->session()->forget('register_step1');

                try {
                    Auth::login($user);
                } catch (\Exception $e) {
                    \Log::error('Error al iniciar sesión', [
                        'error' => $e->getMessage(),
                        'user_id' => $user->Id_User
                    ]);
                    // No retornamos error aquí, ya que el registro fue exitoso
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Gracias por registrarte en ProsarApp',
                    'verification_required' => true,
                    'data' => [
                        'user' => $user,
                        'cliente' => $cliente
                    ]
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error al crear usuario o cliente', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'step1_data' => $step1Data
                ]);
                return response()->json([
                    'success' => false,
                    'errors' => ['general' => ['Error al crear el registro: ' . $e->getMessage()]]
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('Error general en registro paso 2', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'errors' => ['general' => ['Error en el servidor: ' . $e->getMessage()]]
            ], 500);
        }
    }
}
