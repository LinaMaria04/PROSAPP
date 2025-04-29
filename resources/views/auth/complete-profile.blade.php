    @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Completar Perfil') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('complete-profile') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="Nombre_Empresa" class="col-md-4 col-form-label text-md-end">{{ __('Nombre de la Empresa') }}</label>
                            <div class="col-md-6">
                                <input id="Nombre_Empresa" type="text" class="form-control @error('Nombre_Empresa') is-invalid @enderror" name="Nombre_Empresa" value="{{ old('Nombre_Empresa') }}" required autofocus>
                                @error('Nombre_Empresa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Nit" class="col-md-4 col-form-label text-md-end">{{ __('NIT') }}</label>
                            <div class="col-md-6">
                                <input id="Nit" type="text" class="form-control @error('Nit') is-invalid @enderror" name="Nit" value="{{ old('Nit') }}" required>
                                @error('Nit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Direccion" class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>
                            <div class="col-md-6">
                                <input id="Direccion" type="text" class="form-control @error('Direccion') is-invalid @enderror" name="Direccion" value="{{ old('Direccion') }}" required>
                                @error('Direccion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Telefono" class="col-md-4 col-form-label text-md-end">{{ __('Teléfono') }}</label>
                            <div class="col-md-6">
                                <input id="Telefono" type="text" class="form-control @error('Telefono') is-invalid @enderror" name="Telefono" value="{{ old('Telefono') }}" required>
                                @error('Telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Ciudad" class="col-md-4 col-form-label text-md-end">{{ __('Ciudad') }}</label>
                            <div class="col-md-6">
                                <input id="Ciudad" type="text" class="form-control @error('Ciudad') is-invalid @enderror" name="Ciudad" value="{{ old('Ciudad') }}" required>
                                @error('Ciudad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Departamento" class="col-md-4 col-form-label text-md-end">{{ __('Departamento') }}</label>
                            <div class="col-md-6">
                                <input id="Departamento" type="text" class="form-control @error('Departamento') is-invalid @enderror" name="Departamento" value="{{ old('Departamento') }}" required>
                                @error('Departamento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Representante_Legal" class="col-md-4 col-form-label text-md-end">{{ __('Representante Legal') }}</label>
                            <div class="col-md-6">
                                <input id="Representante_Legal" type="text" class="form-control @error('Representante_Legal') is-invalid @enderror" name="Representante_Legal" value="{{ old('Representante_Legal') }}" required>
                                @error('Representante_Legal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Email_Contacto" class="col-md-4 col-form-label text-md-end">{{ __('Email de Contacto') }}</label>
                            <div class="col-md-6">
                                <input id="Email_Contacto" type="email" class="form-control @error('Email_Contacto') is-invalid @enderror" name="Email_Contacto" value="{{ old('Email_Contacto') }}" required>
                                @error('Email_Contacto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Telefono_Contacto" class="col-md-4 col-form-label text-md-end">{{ __('Teléfono de Contacto') }}</label>
                            <div class="col-md-6">
                                <input id="Telefono_Contacto" type="text" class="form-control @error('Telefono_Contacto') is-invalid @enderror" name="Telefono_Contacto" value="{{ old('Telefono_Contacto') }}" required>
                                @error('Telefono_Contacto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Completar Registro') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 