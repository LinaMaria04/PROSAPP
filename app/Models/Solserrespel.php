<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solserrespel extends Model{
    protected $table='solicitud_residuos';
    protected $fillable = ['ID_SolRes', 'FK_SolSer', 'SolResKgEnviado', 'SolResKgRecibido', 'SolResEmbalaje', 'SolResSlug', 'FK_Residuo', 'DeleteSolRes'];
    protected $primaryKey = 'ID_SolRes';
}