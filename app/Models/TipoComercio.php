<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComercio extends Model
{
    use HasFactory;

    protected $table = 'tipo_comercio';
    protected $primaryKey = 'Id_Comercio';

    protected $fillable = [
        'Comercio',
        'Descripción'
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'FK_TipoComercio', 'Id_Comercio');
    }
} 