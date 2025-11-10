<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $primaryKey = 'Id_Peronsa';

    protected $fillable = [
        'PersDocType',
        'PersDocNumber',
        'PrimerNombre',
        'SegundoNombre',
        'Apellidos',
        'Telefono',
        'FK_PersCliente',
        'PersSlug',
        'created_at',
        'updated_at',
        'DeletePersona'
    ];
}