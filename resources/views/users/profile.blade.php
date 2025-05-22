@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.aside')
        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Mi Perfil</h4>
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        @if($user->avatar)
                            <img src="{{ asset('/img/ImagesProfile/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px; font-size: 48px;">
                                {{ strtoupper(substr($user->Nombre, 0, 1)) }}
                            </div>
                        @endif
                        <h5 class="mb-0">{{ $user->Nombre }}</h5>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">Tipo de Documento:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->ClientDocType)
                                {{ $user->cliente->ClientDocType }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">Número de Documento:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->ClientDocumento)
                                {{ $user->cliente->ClientDocumento }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 text-md-end fw-bold">Teléfono:</div>
                        <div class="col-md-8">
                            @if($user->cliente && $user->cliente->telefono)
                                {{ $user->cliente->telefono }}
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class='bx bx-edit'></i> Editar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 