<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sedes extends Model{
    protected $table='sedes';
    protected $fillable = ['Id_Sede', 'FK_Persona', 'NombreSede', 'Direccion', 'SedeMapAddressSearch', 'SedeMapAddressResult', 'SedeMapLat', 'SedeMapLong', 'SedeMapLocalidad', 'SedeSlug', 'DeleteSedes'];        
    protected $primaryKey = 'Id_Sede';
}