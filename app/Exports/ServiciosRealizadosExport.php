<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiciosRealizadosExport implements FromCollection, WithHeadings
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
            ->where('FK_Cliente', $cliente->Id_Cliente)
            ->select(
                'solicitudes_servicio.ID_SolSer',
                'solicitudes_servicio.FechaSolicitud',
                'solicitudes_servicio.Estado',
                'sedes.NombreSede as SedeNombre',
                'sedes.Direccion'
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
            'Dirección'
        ];
    }
}
