<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WompiController extends Controller
{
    public function callback(Request $request)
    {
        $transactionId = $request->query('id');

        // Verifica el estado del pago con la API de Wompi
        $response = Http::get("https://sandbox.wompi.co/v1/transactions/{$transactionId}");
        $data = $response->json();

        $status = $data['data']['status'] ?? 'UNKNOWN';
        $reference = $data['data']['reference'] ?? null;

        // Puedes guardar el estado en BD o actualizar la liquidación
        Log::info("Callback Wompi recibido", [
            'reference' => $reference,
            'status' => $status,
        ]);

        // Redirige a Flutter usando un esquema de URL personalizado
        return redirect()->away("myapp://wompi-result?status={$status}&reference={$reference}");
    }
}
