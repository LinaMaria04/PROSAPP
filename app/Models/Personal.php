<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model{
    protected $table='personas';
    protected $fillable = ['Id_Peronsa', 'PersDocType', 'PersDocNumber', 'PrimerNombre', 'SegundoNombre', 'Apellidos', 'Telefono', 'FK_PersCliente', 'PersSlug'];        
    protected $primaryKey = 'Id_Peronsa';
}