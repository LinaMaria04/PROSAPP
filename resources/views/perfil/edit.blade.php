@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.aside')
        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Editar Mi Perfil</h4>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Avatar-->
                        <div class="mb-4 text-center">
                            <div class="mb-3">
                                @if($user->avatar)
                                    <img src="{{ asset('/img/ImagesProfile/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px; font-size: 48px;">
                                        {{ strtoupper(substr($user->Nombre, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Cambiar foto de perfil</label>
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="Nombre" class="form-label">Nombre / Razón Social</label>
                            <input type="text" class="form-control @error('Nombre') is-invalid @enderror" id="Nombre" name="Nombre" value="{{ old('Nombre', $user->Nombre) }}" required>
                            @error('Nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="TipoDocumento" class="form-label">Tipo de Documento</label>
                            <select class="form-control @error('ClientDocType') is-invalid @enderror" id="TipoDocumento" name="ClientDocType">
                                <option value="">Seleccione...</option>
                                <option value="CC" {{ old('ClientDocType', $user->cliente ? $user->cliente->ClientDocType : '') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                <option value="CE" {{ old('ClientDocType', $user->cliente ? $user->cliente->ClientDocType : '') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                <option value="NIT" {{ old('ClientDocType', $user->cliente ? $user->cliente->ClientDocType : '') == 'NIT' ? 'selected' : '' }}>NIT</option>
                                <option value="Pasaporte" {{ old('ClientDocType', $user->cliente ? $user->cliente->ClientDocType : '') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                            </select>
                            @error('ClientDocType')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="NumeroDocumento" class="form-label">Número de Documento</label>
                            <input type="text" class="form-control @error('ClientDocumento') is-invalid @enderror" id="NumeroDocumento" name="ClientDocumento" value="{{ old('ClientDocumento', $user->cliente ? $user->cliente->ClientDocumento : '') }}">
                            @error('ClientDocumento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="Telefono" name="telefono" value="{{ old('telefono', $user->cliente ? $user->cliente->telefono : '') }}">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h5>Cambiar Contraseña</h5>
                        <p class="text-muted small">Deja estos campos en blanco si no deseas cambiar la contraseña.</p>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                                <i class='bx bx-arrow-back'></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save'></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
