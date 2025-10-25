<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\ProgramacionServicios;


class ProgramarRutasConductores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:programar-rutas-conductores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Programación diaria de servicios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando programación automática de rutas diarias');

        //$hoy = Carbon::today()->toDateString();

        $hoy = '2025-10-27';
        $servicios = DB::table('progamacion_vehiculos')
            ->join('solicitudes_servicio', 'solicitudes_servicio.ID_SolSer' , '=', 'progamacion_vehiculos.FK_Servicio')
            ->join('sedes', 'sedes.Id_Sede', '=', 'solicitudes_servicio.FK_Sede')
            ->whereDate('progamacion_vehiculos.ProgVehFecha', $hoy)
            ->select('progamacion_vehiculos.FK_Vehiculo', 'solicitudes_servicio.ID_SolSer', 'sedes.Direccion', 'sedes.SedeMapLat', 'sedes.SedeMapLong')
            ->orderBy('progamacion_vehiculos.FK_Vehiculo')
            ->get()
            ->groupBy('FK_Vehiculo');

        foreach ($servicios as $vehiculoId => $listaServicios) {
            $puntos = $listaServicios->map(fn($s) => [
                'lat' => $s->SedeMapLat,
                'lng' => $s->SedeMapLong,
            ])->toArray();

            $ruta = $this->calcularRutaOptima($vehiculoId, $puntos);

            Log::info("Ruta calculada para el vehículo {$vehiculoId}:", $ruta);

            $orden = $ruta['orden_optimo'];
            $segmentos = $ruta['distancia_total'];

            foreach ($segmentos as $index => $segmento){
                ProgramacionServicios::create([
                    'ProVehFecha' = $hoy;
                    'ProgHoraAprox' = "";
                    







                    'FK_Vehiculo' => $vehiculoId,
                    'FK_Servicio' => $servicios[$orden[$index]]['id'], // servicio ordenado
                    'FK_SedeServicio' => $servicios[$orden[$index]]['sede_id'],
                    'ProgVehFecha' => Carbon::today(),
                    'ProgHoraAprox' => Carbon::now()->addMinutes($segmento['duration']['value'] / 60),
                    'SedeMapLat' => $segmento['end_location']['lat'],
                    'SedeMapLong' => $segmento['end_location']['lng'],
                    'ProgServSlug' => Str::slug("vehiculo-$vehiculoId-servicio-" . $servicios[$orden[$index]]['id']),
                    'Observacion' => 'Ruta generada automáticamente',
                ])
                

            }
            
        }
    }

    function calcularRutaOptima($vehiculoId, $puntos) {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        // Ejemplo: $puntos = [
        //   ['lat' => 4.6486, 'lng' => -74.1089],
        //   ['lat' => 4.6823, 'lng' => -74.0912],
        //   ['lat' => 4.7553, 'lng' => -74.0442]
        // ];

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
            'orden_optimo' => $data['routes'][0]['waypoint_order'] ?? [],
            'distancia_total' => $data['routes'][0]['legs'] ?? [],
            'mapa_url' => $data['routes'][0]['overview_polyline']['points'] ?? null
        ];
    }
}
