<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Crear residuo - ProsarApp</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet"/>
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
            <a href="{{ route('residuoscomunes.index') }}" class="nav-link">
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
            <h4 class="card-title mb-4">{{ isset($sede) ? 'Editar Residuo' : 'Crear Residuo' }}</h4>

            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ isset($sede) ? route('residuoscomunes.update', $sede->id) : route('residuoscomunes.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @if(isset($sede))
                @method('PUT')
              @endif

              <div class="mb-3">
                <label for="respelname" class="form-label">Nombre residuo</label>
                <input type="text" class="form-control @error('respelname') is-invalid @enderror"
                  id="respelname" name="respelname" value="{{ old('respelname', $sede->respelname ?? '') }}" required>
                @error('respelname')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="respeldescripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control @error('respeldescripcion') is-invalid @enderror"
                  id="respeldescripcion" name="respeldescripcion" value="{{ old('respeldescripcion', $sede->respeldescripcion ?? '') }}" required>
                @error('respeldescripcion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="estadofisico" class="form-label">Estado Físico</label>
                <select class="form-select @error('estadofisico') is-invalid @enderror"
                  id="estadofisico" name="estadofisico" required>
                  <option value="">Seleccione un estado físico</option>
                  <option value="Líquido">Líquido</option>
                  <option value="Sólido">Sólido</option>
                  <option value="SemiSólido">SemiSólido</option>
                  <option value="Gaseoso">Gaseoso</option>
                </select>
                @error('estadofisico')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="peligrosidad" class="form-label">Peligrosidad</label>
                <select class="form-select @error('peligrosidad') is-invalid @enderror"
                  id="peligrosidad" name="peligrosidad" required>
                  <option value="">Seleccione una peligrosidad</option>
                  <option value="No peligroso">No peligroso</option>
                  <option value="Corrosivo">Corrosivo</option>
                  <option value="Reactivo">Reactivo</option>
                  <option value="Explosivo">Explosivo</option>
                  <option value="Toxico">Tóxico</option>
                  <option value="Inflamable">Inflamable</option>
                  <option value="Patógeno-Infeccioso">Patógeno-Infeccioso</option>
                  <option value="Radiactivo">Radiactivo</option>
                </select>
                @error('peligrosidad')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3" id="tipoclasificacion-container" style="display: none;">
                <label for="tipoclasificacion" class="form-label">Tipo de clasificación</label>
                <select class="form-select" id="tipoclasificacion" name="tipoclasificacion">
                  <option value="">Seleccione una opción</option>
                  <option value="Y">Y</option>
                  <option value="A">A</option>
                </select>
              </div>

              <div class="mb-3" id="ClasificacionY" style="display: none;">
                <label for="ClasificacionY" class="form-label">Clasificación Y</label>
                <select class="form-select" id="ClasificacionY" name="ClasificacionY">
                  <option value="">Seleccione una opción</option>
                  <!-- Opciones Y1 a Y45 -->
                  @for ($i = 1; $i <= 45; $i++)
                    <option value="Y{{ $i }}">Y{{ $i }}</option>
                  @endfor
                </select>
              </div>

              <div class="mb-3" id="ClasificacionA" style="display: none;">
                <label for="ClasificacionA" class="form-label">Clasificación A</label>
                <select class="form-select" id="ClasificacionA" name="ClasificacionA">
                  <option value="">Seleccione una opción</option>
                  <!-- Opciones Y1 a Y45 -->
                  @for ($i = 1; $i <= 45; $i++)
                    <option value="A{{ $i }}">Y{{ $i }}</option>
                  @endfor
                </select>
              </div>

              <div class="mb-3">
                <label for="hoja0" class="form-label">Hoja de seguridad</label>
                <input id="hoja0" name="RespelHojaSeguridad" type="file" data-validate="true" required data-filesize="10240" class="form-control" accept=".pdf">
              </div>

              <div class="mb-3">
                <label for="tarjeta0" class="form-label">Tarjeta de emergencia</label>
                <input id="tarjeta0" name="RespelTarj" type="file" data-filesize="5120" class="form-control" accept=".pdf" required>
              </div>

              <div class="mb-3">
                <label for="foto0" class="form-label">Imagen de residuo</label>
                <input id="foto0" name="RespelFoto" type="file" class="form-control" accept=".jpg,.jpeg,.png" required>
              </div>


              <div class="mb-3">
                <label for="Tratamiento" class="form-label">Tratamiento</label>
                <select class="form-select @error('Tratamiento') is-invalid @enderror"
                  id="Tratamiento" name="Tratamiento" required>
                  <option value="">Seleccione un Tratamiento</option>
                  <option value="Termodestrucción">Termodestrucción</option>
                  <option value="Aprovechamiento">Aprovechamiento</option>
                  <option value="Dispocisión Escombrera">Dispocisión Escombrera</option>
                  <option value="Protección de marca">Protección de marca</option>
                  <option value="Celda de seguridad">Celda de seguridad</option>
                </select>
                @error('Tratamiento')
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#peligrosidad').on('change', function() {
        var valor = $(this).val();
        if (valor && valor !== 'No peligroso') {
          $('#tipoclasificacion-container').show();
        } else {
          $('#tipoclasificacion-container').hide();
          $('#ClasificacionY').hide();
        }
      });

      $('#tipoclasificacion').on('change', function() {
        var valor = $(this).val();
        if (valor === 'Y') {
          $('#ClasificacionY').show();
        } else {
          $('#ClasificacionY').hide();
        }
      });

      $('#tipoclasificacion').on('change', function() {
        var valor = $(this).val();
        if (valor === 'A') {
          $('#ClasificacionA').show();
        } else {
          $('#ClasificacionA').hide();
        }
      });
    });

    
  </script>

</body>
</html>
