<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificado E-{{ sprintf("%07s", $certificado->ID_Cert) }}</title>

<style>
@page { margin: 90px 25px 260px 25px; }
body {
    background-image: url('{{ asset("img/WATERMARKV5.png") }}');
    background-size: 600px;
    background-repeat: no-repeat;
    background-position: center;
}
header, footer {
    position: fixed;
    left: 0; right: 0;
    background-color: transparent;
    color: #000;
}
header { top: -60px; }
footer { bottom: -60px; }
.invoice-box { font-size: 12px; font-family: Helvetica, Arial, sans-serif; color: #000; }
.invoice-box table { width: 100%; border-collapse: collapse; }
.invoice-box table td { padding: 3px; vertical-align: top; }
.invoice-box table tr.heading td { background: rgb(0,56,140); color: #ddd; font-weight: bold; }
.invoice-box table tr.item td { border-bottom: 1px solid rgb(198,211,255); }
.invoice-box table tr.total td { border-top: 2px solid rgb(11,24,68); font-weight: bold; text-align: right; }
</style>
</head>

<body>
<header>
    <table width="100%">
        <tr>
            <td><img src="{{ public_path('img/logo.png') }}" style="width: 80px; height: 80px; object-fit: contain;"></td>
            <td style="text-align: right; font-size:16px;">
                <b>N°:</b> <b style="color:red;">E-{{ sprintf("%07s", $certificado->ID_Cert) }}</b><br>
                Fecha: {{ date('Y-m-d') }}
            </td>
        </tr>
    </table>
</header>

<footer>
    <table width="100%" style="font-size:10px; text-align:center;">
        <tr>
            <td>
                Certificado generado y firmado digitalmente desde <b>PROSAPP</b> &copy; {{ date('Y') }} <br>
                ¡Protejamos el medio ambiente; así aseguramos la vida y bienestar de nuestros hijos y generaciones futuras!
            </td>
        </tr>
    </table>
</footer>

<main>
    <div class="invoice-box">
        <table>
            <tr><td colspan="4" style="text-align:center; font-size:16px;"><b>Certificado de Termodestrucción</b></td></tr>

            <tr>
                <td colspan="2" style="line-height:14px;">
                    <b style="color:grey;">GENERADOR:</b><br>
                    <b>{{ $datos->razon_social }}</b><br>
                    {{ $datos->ClientDocumento }}<br>
                    {{ $datos->Direccion }} - <b>{{ $datos->NombreSede }}</b><br>
                    <b style="color:grey;">CONTACTO:</b><br>
                    {{ $datos->Correo }}<br>
                    {{ $datos->telefono }}
                </td>
                <td colspan="2" style="text-align:right; line-height:14px;">
                    <b style="color:grey;">TRANSPORTADOR:</b><br>
                    <b>Prosarc S.A. ESP</b><br>
                    NIT 900.079.188-0<br>
                    Km 6 vía a la Mesa, Mosquera Cundinamarca<br>
                    Tel. 317 667 3032 – 317 667 3035
                </td>
            </tr>

            <tr><td colspan="4" style="font-size:12px; text-align:justify;">
                El <b><i>GENERADOR</i></b> entregó su(s) residuo(s) a <b>Prosarc S.A. ESP</b> para tratamiento de <b>Termodestrucción</b> durante el día
                <b>{{ date('Y-m-d', strtotime($datos->ProVehFecha)) }}</b>, de acuerdo con el servicio <b>#{{ $certificado->FK_CertSolser }}</b>:
            </td></tr>

            <tr class="heading">
                <td colspan="2">RESIDUO</td>
                <td style="text-align:center;">CORRIENTE</td>
                <td>PESO</td>
            </tr>

            @php $totalKg = 0; @endphp
            @foreach($residuos as $Residuo)
                <tr class="item">
                    <td colspan="2">{{ $Residuo->RespelName }}</td>
                    <td style="text-align:center;">{{ $Residuo->YRespelClasf4741 }}</td>
                    <td>{{ $Residuo->SolResKgRecibido ?? 'N/A' }} Kg.</td>
                </tr>
                @php $totalKg += $Residuo->SolResKgRecibido; @endphp
            @endforeach

            <tr class="total"><td colspan="3"></td><td>Total: {{ $totalKg }} Kg.</td></tr>

            <tr><td><b>Observaciones:</b></td><td colspan="3"></td></tr>

            <tr><td colspan="4" style="font-size:10px; text-align:justify;">
                Para este proceso se registraron temperaturas no menores a 850°C en la cámara de combustión y 1.200°C en la post-combustión.
                Se utilizaron los sistemas de enfriamiento y depuración de gases conforme a la Resolución 058 de 2002, 0886 de 2004 y 909 de 2008 del MAVDT.
            </td></tr>

            <tr>
                <td colspan="4" style="text-align:center;">
                    <table width="100%">
                        <tr>
                            <td>
                                <img src="{{ public_path('img/firma1.png') }}" width="100"><br>
                                <b>Coordinador<br>Servicios Express</b>
                            </td>
                            <td>
                                <img src="{{ public_path('img/firma2.png') }}" width="100"><br>
                                <b>Director de Planta</b>
                            </td>
                            <td>
                                @if($firmaCliente)
                                    <img src="{{ public_path('storage/' . $firmaCliente) }}" width="100"><br>
                                @endif
                                <b>Cliente</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</main>
</body>
</html>
