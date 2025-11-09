<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ProgramacionServicios;
use App\Models\Solser;

class ProgramarRutasConductores extends Command
{
    protected $signature = 'app:programar-rutas-conductores';
    protected $description = 'Programación diaria de servicios';

    public function handle()
    {
        $this->info('Iniciando programación automática de rutas diarias');

        // Puedes cambiar esta fecha de prueba
        //$hoy = '2025-10-27';
        $hoy = Carbon::today()->toDateString();

        $serviciosAgrupados = DB::table('progamacion_vehiculos')
            ->join('solicitudes_servicio', 'solicitudes_servicio.ID_SolSer', '=', 'progamacion_vehiculos.FK_Servicio')
            ->join('sedes', 'sedes.Id_Sede', '=', 'solicitudes_servicio.FK_Sede')
            ->whereDate('progamacion_vehiculos.ProgVehFecha', $hoy)
            ->select(
                'progamacion_vehiculos.FK_Vehiculo',
                'solicitudes_servicio.ID_SolSer as id',
                'solicitudes_servicio.FK_Sede as sede_id',
                'sedes.Direccion',
                'sedes.SedeMapLat',
                'sedes.SedeMapLong'
            )
            ->orderBy('progamacion_vehiculos.FK_Vehiculo')
            ->get()
            ->groupBy('FK_Vehiculo');

        foreach ($serviciosAgrupados as $vehiculoId => $listaServicios) {
            $puntos = $listaServicios->map(fn($s) => [
                'lat' => $s->SedeMapLat,
                'lng' => $s->SedeMapLong,
            ])->toArray();

            $ruta = $this->calcularRutaOptima($vehiculoId, $puntos);

            Log::info("Ruta calculada para el vehículo {$vehiculoId}", $ruta);

            $orden = $ruta['orden_optimo'];
            $segmentos = $ruta['distancia_total'];

            // 🔁 Recorremos el orden óptimo
            foreach ($orden as $i => $indiceServicio) {
                $servicio = $listaServicios[$indiceServicio];
                $segmento = $segmentos[$i] ?? null;

                ProgramacionServicios::create([
                    'ProVehFecha'     => $hoy,
                    'ProgHoraAprox'   => Carbon::now()->addMinutes(($segmento['duration']['value'] ?? 0) / 60),
                    'FK_Vehiculo'     => $vehiculoId,
                    'FK_Conductor'    => 1, // Puedes cambiar esto por el conductor real
                    'FK_Servicio'     => $servicio->id,
                    'FK_SedeServicio' => $servicio->sede_id,
                    'SedeMapLat'      => $servicio->SedeMapLat,
                    'SedeMapLong'     => $servicio->SedeMapLong,
                    'ProgServSlug'    => null,
                    'Observacion'     => 'Ruta generada automáticamente',
                    'created_at'      => Carbon::now(),
                    'updated_at'      => Carbon::now(),
                    'DeletProgServ'   => 0,
                    'Orden'           => $i + 1,
                    'Distancia'       => $segmento['distance']['value'] ?? null,
                    'Duracion'        => $segmento['duration']['value'] ?? null,
                ]);

                Solser::where('ID_SolSer', $servicio->id)
                    ->update(['Estado' => 'Programado']);


            }
        }
    }

    private function calcularRutaOptima($vehiculoId, $puntos)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        if (count($puntos) < 2) {
            return ['orden_optimo' => [0], 'distancia_total' => [], 'mapa_url' => null];
        }

        $origen = "{$puntos[0]['lat']},{$puntos[0]['lng']}";
        $destinos = collect($puntos)->skip(1)->map(fn($p) => "{$p['lat']},{$p['lng']}")->implode('|');

        $response = Http::get("https://maps.googleapis.com/maps/api/directions/json", [
            'origin' => $origen,
            'destination' => $origen,
            'waypoints' => "optimize:true|$destinos",
            'key' => $apiKey,
        ]);

        $data = $response->json();

        return [
            'orden_optimo'    => $data['routes'][0]['waypoint_order'] ?? [],
            'distancia_total' => $data['routes'][0]['legs'] ?? [],
            'mapa_url'        => $data['routes'][0]['overview_polyline']['points'] ?? null,
        ];
    }
}
