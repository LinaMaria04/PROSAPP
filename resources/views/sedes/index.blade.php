<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedes - ProsarApp</title>
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
                            <h4 class="card-title mb-0">Lista de Sedes</h4>
                            <a href="{{ route('sedes.create') }}" class="btn btn-primary">
                                <i class='bx bx-plus-circle'></i> Crear Sedes
                            </a>
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
                                        <th>Nombre de sede</th>
                                        <th>Direccion</th>
                                        <th>Localidad</th>
                                        <th>Ver</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sedes as $sede)
                                        <tr>
                                            <td>{{$sede->NombreSede}}</td>
                                            <td>{{$sede->Direccion}}</td>
                                            <td>{{$sede->SedeMapLocalidad}}</td>
                                            <td>
                                                <a href="/sedes/{{$sede->SedeSlug}}" class="btn btn-info">
                                                    <i class='bx bx-show' type="submit"></i> Ver
                                                </a>
                                            </td>
                                            <td>    
                                                <a href="/sedes/{{$sede->SedeSlug}}/edit" class="btn btn-warning">
                                                    <i class='bx bx-edit'></i>Editar
                                                </a>
                                            </td>
                                            <td>    
                                                <td>    
                                                    <a method='get' href='#' data-toggle='modal' data-target='#myModal{{$sede->SedeSlug}}' class='btn btn-danger pull-left'>
                                                    <form action='{{route('sedes.destroy', $sede->SedeSlug)}}' method='POST'  class="col-12 pull-right">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                                            <i class='bx bx-trash'></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>  
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($sedes->hasPages())
                            <div class="mt-4">
                                {{ $sedes->links() }}
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