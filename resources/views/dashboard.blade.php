@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Bienvenido, {{ auth()->user()->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>Has iniciado sesión correctamente en ProsarApp.
                    </div>
                    
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-info-circle me-2"></i>Información de tu cuenta:
                        </h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <i class="fas fa-user me-2"></i>
                                <strong>Nombre:</strong> {{ auth()->user()->name }}
                            </div>
                            <div class="list-group-item">
                                <i class="fas fa-envelope me-2"></i>
                                <strong>Email:</strong> {{ auth()->user()->email }}
                            </div>
                            <div class="list-group-item">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <strong>Fecha de registro:</strong> {{ auth()->user()->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 