<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Personal - ProsarApp</title>
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
   @include('layouts.appbar')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Detalles del Personal</h4>

                        <div class="detail-item">
                            <div class="detail-label">Nombre completo</div>
                            <div>{{ $persona->PrimerNombre}} {{ $persona->SegundoNombre}} {{$persona->Apellidos}}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Tipo de Documento</div>
                            <div>{{ $persona->PersDocType}}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Numero de Documento</div>
                            <div>{{ $persona->PersDocNumber}}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Teléfono</div>
                            <div>{{ $persona->Telefono ?? 'No especificado' }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Cliente</div>
                            <div>{{ $persona->FK_PersCliente }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Fecha de registro</div>
                            <div>{{ $persona->created_at}}</div>
                        </div>

                        <div class="mt-4">
                            <a href="/personal/{{$persona->PersSlug}}/edit" class="btn btn-warning me-2">
                                <i class='bx bx-edit'></i> Editar
                            </a>
                            {{--<form action="{{ route('personal.destroy', $persona->id) }}" method="POST" class="d-inline">--}}
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
</body>
</html>