<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['Rol' => 'Administrador', 'Descripcion' => 'Administrador del sistema'],
            ['Rol' => 'Cliente', 'Descripcion' => 'Cliente del sistema'],
            ['Rol' => 'Conductor', 'Descripcion' => 'persona que conduce el vehiculo'],
            ['Rol' => 'Asesor Comercial', 'Descripcion' => 'persona que asesora a los clientes'],
            ['Rol' => 'Tesoreria', 'Descripcion' => 'persona que se encarga de la tesoreria'],
            ['Rol' => 'PDA', 'Descripcion' => 'persona que se encarga de la PDA'],
            ['Rol' => 'Logística', 'Descripcion' => 'persona que se encarga de la logística'],
        ]);
    }
}