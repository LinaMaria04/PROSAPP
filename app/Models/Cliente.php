<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'Id_Cliente';

    protected $fillable = [
        'ClientDocType',
        'ClientDocumento',
        'razon_social',
        'direccion',
        'telefono',
        'FK_TipoComercio',
        'ClientSlug',
        'ClientRut',
        'CorreoFE',
        'ClientStatus',
        'TipoFacturacion',
        'FK_ClienteUser'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'FK_ClienteUser', 'Id_User');
    }

    public function tipoComercio()
    {
        return $this->belongsTo(TipoComercio::class, 'FK_TipoComercio', 'Id_Comercio');
    }
} 