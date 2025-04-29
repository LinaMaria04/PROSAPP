<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoComercioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposComercio = [
            ['Comercio' => 'Comercio Minorista', 'Descripción' => 'Establecimientos de venta al por menor'],
            ['Comercio' => 'Comercio Mayorista', 'Descripción' => 'Establecimientos de venta al por mayor'],
            ['Comercio' => 'Industria', 'Descripción' => 'Empresas industriales y manufactureras'],
            ['Comercio' => 'Servicios', 'Descripción' => 'Empresas de servicios'],
            ['Comercio' => 'Restaurante', 'Descripción' => 'Establecimientos de comida y bebidas'],
            ['Comercio' => 'Hotel', 'Descripción' => 'Establecimientos de hospedaje'],
            ['Comercio' => 'Educación', 'Descripción' => 'Instituciones educativas'],
            ['Comercio' => 'Salud', 'Descripción' => 'Establecimientos de salud'],
            ['Comercio' => 'Oficina', 'Descripción' => 'Oficinas y espacios corporativos'],
            ['Comercio' => 'Otro', 'Descripción' => 'Otros tipos de comercio']
        ];

        foreach ($tiposComercio as $tipo) {
            DB::table('tipo_comercio')->insert([
                'Comercio' => $tipo['Comercio'],
                'Descripción' => $tipo['Descripción'],
                'created_at' => now(),
                'updated_at' => now(),
                'DeleteComercio' => 0
            ]);
        }
    }
}
