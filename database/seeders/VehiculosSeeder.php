<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehiculos = [
            ['ID_Vehiculo' => 1, 'VehiPlaca' => 'NUV-586', 'VehiTipo' => 'Camión sencillo (2 Ejes)', 'VehiCapacidad' => '100', 'VehiKmActual' => '0', 'VehiculoMtto' => 0],
            ['ID_Vehiculo' => 2, 'VehiPlaca' => 'JTY-063', 'VehiTipo' => 'Camión sencillo (2 Ejes)', 'VehiCapacidad' => '100', 'VehiKmActual' => '0', 'VehiculoMtto' => 0],
        ];

        DB::table('vehiculos')->insert($vehiculos);

    }
}
