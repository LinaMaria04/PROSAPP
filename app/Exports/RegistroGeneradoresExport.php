<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistroGeneradoresExport implements FromCollection, WithHeadings
{
    protected $clienteNombre;

    public function __construct($clienteNombre)
    {
        $this->clienteNombre = $clienteNombre;
    }

    public function collection()
    {

        $cliente = DB::table('clientes')
            ->where('razon_social', $this->clienteNombre)
            ->select('Id_Cliente')
            ->first();

        if (!$cliente) {
            return collect([]);
        }

        return DB::table('solicitudes_servicio')
            ->join('sedes', 'sedes.Id_Sede', '=', 'solicitudes_servicio.FK_Sede')
            ->join('solicitud_residuos', 'solicitud_residuos.FK_SolSer', '=', 'solicitudes_servicio.ID_SolSer')
            ->join('residuos', 'residuos.ID_Respel', '=', 'solicitud_residuos.FK_Residuo')
            ->join('certificados', 'certificados.FK_CertSolser', '=', 'solicitudes_servicio.ID_SolSer')
            ->where('FK_Cliente', $cliente->Id_Cliente)
            ->select(
                'solicitudes_servicio.ID_SolSer',
                'solicitudes_servicio.FechaSolicitud',
                'solicitudes_servicio.Estado',
                'sedes.NombreSede as SedeNombre',
                'residuos.RespelName',
                'residuos.RespelDescrip',
                'residuos.YRespelClasf4741',
                'residuos.RespelIgrosidad',
                'residuos.RespelEstado',
                'solicitud_residuos.SolResEmbalaje',
                'solicitud_residuos.SolResKgRecibido',
                'certificados.ID_Cert'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Servicio',
            'Fecha',
            'Estado',
            'Sede',
            'Residuo',
            'Descripción',
            'Clasificación',
            'Peligrosidad',
            'Estado',
            'Embalaje',
            'Cantidad (Kg)',
            '# Certidicado'
        ];
    }
}
