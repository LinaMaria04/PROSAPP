<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Crear servicio - ProsarApp</title>
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
            <h4 class="card-title mb-4">{{ isset($sede) ? 'Editar Servicio' : 'Crear Servicio' }}</h4>

            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ isset($sede) ? route('solservicios.update', $sede->id) : route('solservicios.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @if(isset($sede))
                @method('PUT')
              @endif

              <div class="mb-3">
                <label for="sedeserv" class="form-label">Seleccione la sede de recolección</label>
                <select class="form-select @error('sedeserv') is-invalid @enderror"
                  id="sedeserv" name="sedeserv" required>
                  <option value="">Seleccione una sede</option>
                  @foreach($sedes as $sede)
                    <option value="{{$sede->Id_Sede}}">{{$sede->NombreSede}}</option>
                  @endforeach
                </select>
                @error('sedeserv')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="numserv" class="form-label">Número de servicios</label>
                <select class="form-select @error('numserv') is-invalid @enderror"
                  id="numserv" name="numserv" required>
                  <option value="">Seleccione el numero de servicios</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                @error('numserv')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="frecserv" class="form-label">Frecuencia de recoleción</label>
                <select class="form-select @error('frecserv') is-invalid @enderror"
                  id="frecserv" name="frecserv" required>
                  <option value="">Seleccione la frecuencia de recolección</option>
                  <option value="diaria">Diaria</option>
                  <option value="semanal">Semanal</option>
                  <option value="mensual">Mensual</option>
                  <option value="anual">Anual</option>
                </select>
                @error('frecserv')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="residuoserv" class="form-label">Residuo a entregar</label>
                <select class="form-select @error('residuoserv') is-invalid @enderror"
                  id="residuoserv" name="residuoserv" required onchange="actualizarDetallesResiduo()">
                  <option value="">Seleccione el residuo a entregar</option>
                  @foreach($residuos as $residuo)
                    <option value="{{$residuo->ID_Respel}}">{{$residuo->RespelName}}</option>
                  @endforeach  
                </select>
                @error('residuoserv')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="detail-item">
                <div class="detail-label">Descripción</div>
                <div id="residuo-descripcion">-</div>
              </div>

              <div class="detail-item">
                  <div class="detail-label">Corriente</div>
                  <div id="residuo-corriente">-</div>
              </div>

              <div class="detail-item">
                  <div class="detail-label">Peligrosidad</div>
                  <div id="residuo-peligrosidad">-</div>
              </div>

              <div class="mb-3">
                <label for="respelkg" class="form-label">Cantidad - Kg</label>
                <input type="text" class="form-control @error('respelkg') is-invalid @enderror"
                  id="respelkg" name="respelkg" value="{{ old('respelkg', $sede->respelname ?? '') }}" required>
                @error('respelkg')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="embalaje" class="form-label">Embalaje</label>
                <select class="form-select @error('embalaje') is-invalid @enderror"
                  id="embalaje" name="embalaje" required>
                  <option value="">Seleccione un embalaje</option>
                  <option value="Sacos/Bolsas">Sacos/Bolsas</option>
                  <option value="Bidones Pequeños">Bidones Pequeños</option>
                  <option value="Bidones Grandes">Bidones Grandes</option>
                  <option value="Estibas  ">Estibas</option>
                </select>
                @error('embalaje')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                  {{'Solicitar'}}
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
    const residuosData = @json($residuos);
  </script>
  <script>
  function actualizarDetallesResiduo() {
      const idSeleccionado = document.getElementById('residuoserv').value;
      const residuo = residuosData.find(r => r.ID_Respel == idSeleccionado);

      if (residuo) {
          document.getElementById('residuo-descripcion').textContent = residuo.RespelDescrip || '-';
          document.getElementById('residuo-corriente').textContent = residuo.YRespelClasf4741 || '-';
          document.getElementById('residuo-peligrosidad').textContent = residuo.RespelIgrosidad || '-';
      } else {
          document.getElementById('residuo-descripcion').textContent = '-';
          document.getElementById('residuo-corriente').textContent = '-';
          document.getElementById('residuo-peligrosidad').textContent = '-';
      }
  }
  </script>

  
</body>
</html>
