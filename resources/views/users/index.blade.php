<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - ProsarApp</title>
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
        .table th {
            background-color: #f8f9fa;
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
                            <h4 class="card-title mb-0">Lista de Usuarios</h4>
                            
                            {{-- Solo administradores pueden crear usuarios --}}
                            @if(App\Permisos::check(App\Permisos::ADMINISTRADORES))
                                <a href="{{ route('users.create') }}" class="btn btn-primary">
                                    <i class='bx bx-plus-circle'></i> Agregar Usuario
                                </a>
                            @endif
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Ver</th>
                                        {{-- Solo administradores pueden editar y eliminar --}}
                                        @if(App\Permisos::check(App\Permisos::ADMINISTRADORES))
                                            <th>Editar</th>
                                            <th>Eliminar</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->Nombre }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->UsRol }}</td>
                                            <td>
                                                @if($user->is_active)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('users.show', $user->UserSlug) }}" class="btn btn-info">
                                                    <i class='bx bx-show'></i> Ver
                                                </a>
                                            </td>
                                            
                                            {{-- Solo administradores pueden editar y eliminar --}}
                                            @if(App\Permisos::check(App\Permisos::ADMINISTRADORES))
                                                <td>    
                                                    <a href="{{ route('users.edit', $user->UserSlug) }}" class="btn btn-warning">
                                                        <i class='bx bx-edit'></i> Editar
                                                    </a>
                                                </td>
                                                <td>    
                                                    <form action="{{ route('users.destroy', $user->UserSlug) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                            <i class='bx bx-trash'></i> Eliminar
                                                        </button>
                                                    </form>    
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($users->hasPages())
                            <div class="mt-4">
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>    
            </div>
        </div>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 