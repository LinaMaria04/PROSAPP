<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Personal - ProsarApp</title>
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
        .form-control:focus {
            border-color: #1565C0;
            box-shadow: 0 0 0 0.25rem rgba(21, 101, 192, 0.25);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">ProsarApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('personal.index') }}" class="nav-link">
                            <i class='bx bx-arrow-back'></i> Volver
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ isset($persona) ? 'Editar Personal' : 'Crear Personal' }}</h4>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ isset($persona) ? route('personal.update', $persona->id) : route('personal.store') }}" method="POST">
                            @csrf
                            @if(isset($persona))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                            <label for="primernombre" class="form-label">Primer Nombre</label>
                                <input type="text" class="form-control @error('primernombre') is-invalid @enderror" 
                                       id="primernombre" name="primernombre" value="{{ old('primernombre', $persona->nombre ?? '') }}" required>
                                @error('primernombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="segundonombre" class="form-label">Segundo Nombre</label>
                                <input type="text" class="form-control @error('segundonombre') is-invalid @enderror" 
                                       id="segundonombre" name="segundonombre" value="{{ old('segundonombre', $persona->nombre ?? '') }}" required>
                                @error('segundonombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                                       id="apellido" name="apellido" value="{{ old('apellido', $persona->nombre ?? '') }}" required>
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tipdoc" class="form-label">Tipo de Documento</label>
                                <select class="form-select @error('tipdoc') is-invalid @enderror" 
                                        id="tipdoc" name="tipdoc" required>
                                    <option value="">Seleccione un Tipo de Documento</option>
                                    <option value="CC" {{ (old('tipdoc', $persona->PersDocType ?? '') == 'CC') ? 'selected' : '' }}>CC</option>
                                    <option value="TI" {{ (old('tipdoc', $persona->PersDocType ?? '') == 'TI') ? 'selected' : '' }}>TI</option>
                                    <option value="CE" {{ (old('tipdoc', $persona->PersDocType ?? '') == 'CE') ? 'selected' : '' }}>CE</option>

                                </select>
                                @error('tipdoc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="numdoc" class="form-label">Número de Documento</label>
                                <input type="text" class="form-control @error('numdoc') is-invalid @enderror" 
                                       id="numdoc" name="numdoc" value="{{ old('numdoc', $persona->nombre ?? '') }}" required>
                                @error('numdoc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" name="telefono" value="{{ old('telefono', $persona->telefono ?? '') }}" required>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($persona) ? 'Actualizar' : 'Guardar' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 