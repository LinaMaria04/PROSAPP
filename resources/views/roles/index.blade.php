@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Roles</h2>
                </div>
                <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">Crear Rol</a>    
                </div>
                <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles ?? [] as $role)
                                    <tr>
                                        <td>{{ $role->Rol }}</td>
                                        <td>{{ $role->Description ?? 'Sin descripción' }}</td>
                                        <td>
                                            <a href="{{ route('roles.edit', $role->Id_Rol) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="{{ route('roles.destroy', $role->Id_Rol) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No hay roles registrados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 