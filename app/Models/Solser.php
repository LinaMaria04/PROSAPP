<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solser extends Model{
    protected $table='solicitudes_servicio';
    protected $fillable = ['ID_SolSer', 'NumFactura', 'FechaSolicitud', 'Estado', 'Observaciones', 'created_at', 'updated_at'];        
    protected $primaryKey = 'ID_SolSer';
}