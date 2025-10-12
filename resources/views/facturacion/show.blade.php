@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.aside')
        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Información de Facturación Electrónica</h4>
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">Tipo de Persona:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->TipoFacturacion)
                                {{ $user->cliente->TipoFacturacion }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">Razón Social:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->razon_social)
                                {{ $user->cliente->razon_social }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($user->cliente && $user->cliente->TipoFacturacion == 'Jurídica')
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">NIT:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->ClientDocumento)
                                {{ $user->cliente->ClientDocumento }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">RUT:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->ClientRut)
                                <a href="{{ asset('/documentos/rut/' . $user->cliente->ClientRut) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class='bx bx-file'></i> Ver documento RUT
                                </a>
                            @else
                                <span class="text-muted">No cargado</span>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">Cédula:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->ClientDocumento)
                                {{ $user->cliente->ClientDocumento }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">Correo Electrónico de Facturación:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->CorreoFE)
                                {{ $user->cliente->CorreoFE }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">Dirección:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->direccion)
                                {{ $user->cliente->direccion }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                            <i class='bx bx-arrow-back'></i> Volver al Perfil
                        </a>
                        <a href="{{ route('facturacion.edit') }}" class="btn btn-primary">
                            <i class='bx bx-edit'></i> Editar Información
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 