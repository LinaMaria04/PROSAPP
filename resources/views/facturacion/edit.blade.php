@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.aside')
        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Editar Información de Facturación Electrónica</h4>
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('facturacion.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="TipoFacturacion" class="form-label">Tipo de Persona</label>
                            <select class="form-control @error('TipoFacturacion') is-invalid @enderror" id="TipoFacturacion" name="TipoFacturacion" onchange="mostrarCamposSegunTipo()">
                                <option value="">Seleccione...</option>
                                <option value="Natural" {{ old('TipoFacturacion', $user->cliente ? $user->cliente->TipoFacturacion : '') == 'Natural' ? 'selected' : '' }}>Persona Natural</option>
                                <option value="Jurídica" {{ old('TipoFacturacion', $user->cliente ? $user->cliente->TipoFacturacion : '') == 'Jurídica' ? 'selected' : '' }}>Persona Jurídica</option>
                            </select>
                            @error('TipoFacturacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="razon_social" class="form-label">Razón Social</label>
                            <input type="text" class="form-control @error('razon_social') is-invalid @enderror" id="razon_social" name="razon_social" value="{{ old('razon_social', $user->cliente ? $user->cliente->razon_social : '') }}">
                            @error('razon_social')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- persona natural -->
                        <div id="campos_natural"style="display: {{old('TipoFacturacion', $user->cliente ? $user->cliente->TipoFacturacion : '') == 'Natural' ? 'block' : 'none' }}">
                            <div class="mb-3">
                            <label for="ClientRut" class="form-label">Cedula (Archivo PDF o imagen)</label>
                            <input type="file" class="form-control @error('ClientRut_file') is-invalid @enderror" id="ClientRut_file" name="ClientRut_file">
                            @if($user->cliente && $user->cliente->ClientRut)
                                <small class="text-success">Cedula ya cargada: {{ $user->cliente->ClientRut }}</small>
                            @endif
                            @error('ClientRut_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                     
                        </div>  
                        <!-- persona jueridica -->                   
                        <div id="campos_juridica" style="display: {{ old('TipoFacturacion', $user->cliente ? $user->cliente->TipoFacturacion : '') == 'Jurídica' ? 'block' : 'none' }}">
                            <div class="mb-3">
                                <label for="ClientRut" class="form-label">RUT (Archivo PDF o imagen)</label>
                                <input type="file" class="form-control @error('ClientRut_file') is-invalid @enderror" id="ClientRut_file" name="ClientRut_file">
                                @if($user->cliente && $user->cliente->ClientRut)
                                    <small class="text-success">RUT ya cargado: {{ $user->cliente->ClientRut }}</small>
                                @endif
                                @error('ClientRut_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="CorreoFE" class="form-label">Correo Electrónico para Facturación</label>
                            <input type="email" class="form-control @error('CorreoFE') is-invalid @enderror" id="CorreoFE" name="CorreoFE" value="{{ old('CorreoFE', $user->cliente ? $user->cliente->CorreoFE : '') }}">
                            @error('CorreoFE')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección de Facturación</label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $user->cliente ? $user->cliente->direccion : '') }}">
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('facturacion.show') }}" class="btn btn-secondary">
                                <i class='bx bx-arrow-back'></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save'></i> Guardar Información
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarCamposSegunTipo() {
    const tipoPersona = document.getElementById('TipoFacturacion').value;
    const camposJuridica = document.getElementById('campos_juridica');
    const camposNatural = document.getElementById('campos_natural');

    if (tipoPersona === 'Jurídica') {
        camposJuridica.style.display = 'block';
        camposNatural.style.display = 'none';
    } else {
        camposJuridica.style.display = 'none';
        camposNatural.style.display = 'block';
    }
}

// Ejecutar al cargar la página
document.addEventListener('DOMContentLoaded', mostrarCamposSegunTipo);
</script>
@endsection 