<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Usuario - ProsarApp</title>
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
    </style>
</head>
<body>
    @include('layouts.appbar')

    <div class="container">
        <div class="row">
            @include('layouts.aside')
            <div class="col sm-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Detalles del Usuario</h4>
                            <div>
                                <a href="{{ route('users.edit', $user->UserSlug) }}" class="btn btn-warning me-2">
                                    <i class='bx bx-edit'></i> Editar
                                </a>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class='bx bx-arrow-back'></i> Volver
                                </a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="text-muted mb-1">Nombre</h5>
                                    <p class="fs-5">{{ $user->Nombre }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="text-muted mb-1">Correo Electrónico</h5>
                                    <p class="fs-5">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="text-muted mb-1">Rol</h5>
                                    <p class="fs-5">{{ $user->UsRol }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="text-muted mb-1">Estado</h5>
                                    @if($user->is_active)
                                        <span class="badge bg-success fs-6">Activo</span>
                                    @else
                                        <span class="badge bg-danger fs-6">Inactivo</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Información Adicional</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Fecha de Creación:</strong> {{ $user->created_at ? date('d/m/Y H:i', strtotime($user->created_at)) : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Última Actualización:</strong> {{ $user->updated_at ? date('d/m/Y H:i', strtotime($user->updated_at)) : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 