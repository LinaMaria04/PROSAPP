<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $fillable = ['Id_Rol', 'Rol', 'Descripcion'];
    protected $primaryKey = 'Id_Rol';
}


