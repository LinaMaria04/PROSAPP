<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    use HasFactory;

    protected $table = 'liquidacion_servicios';
    protected $primaryKey = 'ID_LiquiServ';

    protected $fillable = [
        'FK_SolSer',
        'TotalKg',
        'FK_Tarifas',
        'TotalKgAdicional',
        'TotalPagar',
        'LiquiServSlug',
        'FK_TipoPago',
        'created_at',
        'updated_at',
        'DeleteLiquiServ',
    ];
}