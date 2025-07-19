<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResiduoComun extends Model{
    protected $table='residuos';
    protected $fillable = ['ID_Respel', 'RespelName', 'RespelDescrip', 'YRespelClasf4741', 'ARespelClasf4741', 'RespelIgrosidad', 'RespelEstado', 'Cedula', 'RespelHojaSeguridad', 'RespelTarj', 'RespelSlug' , 'RespelStatus', 'FK_RespelCoti', 'RespelFoto', 'SustanciaControlada', 'SustanciaControladaTipo', 'SustanciaControladaNombre', 'SustanciaControladaDocumento', 'RespelDeclaracion', 'RespelStatusDescription', 'AceiteUsado', 'RespelDelete'];        
    protected $primaryKey = 'ID_Respel';
}