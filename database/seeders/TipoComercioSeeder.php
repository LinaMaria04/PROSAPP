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
        $tipos_comercio = [
            [
                'Comercio' => 'Industria Manufacturera',
                'Descripción' => 'Empresas dedicadas a la transformación de materias primas en productos terminados',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Servicios de Salud',
                'Descripción' => 'Hospitales, clínicas y centros médicos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Comercio Minorista',
                'Descripción' => 'Tiendas y establecimientos de venta al por menor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Servicios Profesionales',
                'Descripción' => 'Empresas de consultoría, asesoría y servicios especializados',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Construcción',
                'Descripción' => 'Empresas dedicadas a la construcción y desarrollo inmobiliario',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Tecnología',
                'Descripción' => 'Empresas de desarrollo de software y servicios tecnológicos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Educación',
                'Descripción' => 'Instituciones educativas y centros de formación',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Hostelería y Turismo',
                'Descripción' => 'Hoteles, restaurantes y servicios turísticos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Agricultura',
                'Descripción' => 'Empresas dedicadas a la producción agrícola y ganadera',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Comercio' => 'Transporte y Logística',
                'Descripción' => 'Empresas de transporte y servicios logísticos',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('tipo_comercio')->insert($tipos_comercio);
    }
}
