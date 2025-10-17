<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model{

    protected $table='vehiculos';
    protected $fillable = ['ID_Vehiculo', 'VehiPlaca', 'VehiTipo', 'VehiCapacidad', 'VehiKmActual', 'VehiculoSlug', 'VehiculoMtto', 'DeleteVehiculo', 'created_at', 'updated_at'];
    protected $primaryKey = 'ID_Vehiculo';

}