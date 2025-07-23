<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del residuo - ProsarApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #1565C0, #64B5F6);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #1565C0;
            border-color: #1565C0;
        }
        .btn-primary:hover {
            background-color: #0D47A1;
            border-color: #0D47A1;
        }
        .detail-item {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">ProsarApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('residuoscomunes.index') }}" class="nav-link">
                            <i class='bx bx-arrow-back'></i> Volver
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Detalles del residuo</h4>
                            <h5 class="card-title text-center">{{$residuo?->RespelName}}</h5>  

                            <div class="detail-item">
                                <div class="detail-label">Nombre de residuo</div>
                                <div>{{$residuo->RespelName}}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Descripción</div>
                                <div>{{$residuo->RespelDescrip}}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Estado Físico</div>
                                <div>{{$residuo->RespelEstado}}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Peligrosidad</div>
                                <div>{{$residuo->RespelIgrosidad}}</div>
                            </div>

                            @if($residuo->YRespelClasf4741 <> null)
                                <div class="detail-item">
                                    <div class="detail-label">Peligrosidad</div>
                                    <div>{{$residuo->YRespelClasf4741}}</div>
                                </div>
                            @elseif($residuo->ARespelClasf4741 <> null)
                                <div class="detail-item">
                                    <div class="detail-label">Peligrosidad</div>
                                    <div>{{$residuo->ARespelClasf4741}}</div>
                                </div>
                            @else
                                <div class="detail-item">
                                    <div class="detail-label">N/A</div>
                                </div>
                            @endif

                            @if($residuo->RespelHojaSeguridad!=="RespelHojaDefault.pdf")
                                <div class="detail-item">
                                    <div class="detail-label">Hoja de seguridad</div>
                                    <div><a method='get' href='/img/HojaSeguridad/{{$residuo->RespelHojaSeguridad}}' target='_blank' class='btn btn-success'><i class='fas fa-file-pdf fa-lg'></a></div>
                                </div>
                            @else
                                <div class="detail-item">
                                    <div class="detail-label">N/A</div>
                                </div>
                            @endif

                            @if($residuo->RespelTarj!=="RespelTarjetaDefault.pdf")
                                <div class="detail-item">
                                    <div class="detail-label">Tarjeta de Emergencia</div>
                                    <div><a method='get' href='/img/TarjetaEmergencia/{{$residuo->RespelTarj}}' target='_blank' class='btn btn-success'><i class='fas fa-file-pdf fa-lg'></a></div>
                                </div>
                            @else
                                <div class="detail-item">
                                    <div class="detail-label">N/A</div>
                                </div>
                            @endif


                            <div class="mt-4">
                                <a href="/residuoscomunes/{{$residuo->RespelSlug}}/edit" class="btn btn-warning me-2">
                                    <i class='bx bx-edit'></i> Editar
                                </a>
                                <form action="" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                    <i class='bx bx-trash'></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Cargar de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Hoja de estilos de jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

</body>
</html>