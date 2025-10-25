<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramacionServicios extends Model{

    protected $table='programacion_servicios';
    protected $fillable = ['ID_ProgServicio ', 'ProVehFecha', 'ProgHoraAprox', 'FK_Vehiculo', 'FK_Conductor', 'FK_Servicio', 'FK_SedeServicio', 'SedeMapLat', 'SedeMapLong', 'ProgServSlug', 'Observacion', 'created_at', 'updated_at', 'DeletProgServ', 'Orden', 'Distancia', 'Duracion'];
    protected $primaryKey = 'ID_ProgServicio ';

}