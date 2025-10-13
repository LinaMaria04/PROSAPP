<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TarifasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarifas = [
            ['ID_Tarifa' => 1, 'Categoria' => '0 a 12', 'Costo' => 55000],
            ['ID_Tarifa' => 2, 'Categoria' => '12 A 20', 'Costo' => 73000],
            ['ID_Tarifa' => 3, 'Categoria' => '20 a 40', 'Costo' => 104000],
            ['ID_Tarifa' => 4, 'Categoria' => '40 a 60', 'Costo' => 137000],
            ['ID_Tarifa' => 5, 'Categoria' => '60 a 100', 'Costo' => 220000],
            ['ID_Tarifa' => 6, 'Categoria' => '100 a 150', 'Costo' => 313000],
        ];

        DB::table('tarifas')->insert($tarifas);
    }
}
