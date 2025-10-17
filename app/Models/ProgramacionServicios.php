<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramacionServicios extends Model{

    protected $table='programacion_servicios';
    protected $fillable = ['id', 'FK_Servicio', 'FK_Vehiculo', 'ProgVehDia', 'ProgVehFecha', 'ProgVehKgAsignados', 'ProgVehEstado', 'ProgVehDelete', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';

    public function servicio(){

        return $this->belongsTo(Solser::class, 'FK_Servicio', 'ID_SolSer');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'FK_ProgVehiculo');
    }


}