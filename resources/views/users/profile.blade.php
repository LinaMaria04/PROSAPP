@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Perfil de Usuario</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>Información Personal</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 fw-bold">Nombre:</div>
                            <div class="col-md-8">{{ $user->Nombre }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 fw-bold">Correo Electrónico:</div>
                            <div class="col-md-8">{{ $user->email }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 fw-bold">Rol:</div>
                            <div class="col-md-8">{{ $user->UsRol }}</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('users.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Editar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 