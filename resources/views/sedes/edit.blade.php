<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sede - ProsarApp</title>
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
    @include('layouts.appbar')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Editar Sede</h4>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form role="form" action="{{ route('sedes.update', $sede->SedeSlug) }}" method="POST" enctype="multipart/form-data" data-bs-toggle="validator" class="form">
                            @csrf
                            @if(isset($sede))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="sedename" class="form-label">Nombre de la sede</label>
                                <input type="text" class="form-control @error('sedename') is-invalid @enderror" 
                                       id="sedename" name="sedename" value="{{ old('sedename', $sede->NombreSede ?? '') }}" required>
                                @error('sedename')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="persencargada" class="form-label">Persona Encargada</label>
                                <select class="form-select @error('persencargada') is-invalid @enderror" 
                                        id="persencargada" name="persencargada" required>
                                        <option value="">Seleccione una persona</option>
                                     @foreach($personas as $persona)
                                        <option value="{{ $persona->Id_Peronsa }}" {{ (old('persencargada', $sede->FK_Persona ?? '') == $persona->Id_Peronsa) ? 'selected' : '' }}>
                                            {{ $persona->PrimerNombre }} {{ $persona->SegundoNombre }} {{ $persona->Apellidos }}
                                        </option>    
                                     @endforeach
                                </select>
                                @error('persencargada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control @error('correo') is-invalid @enderror" 
                                       id="correo" name="correo" value="{{ old('correo', $sede->Correo ?? '') }}" required>
                                @error('correo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono</label>
                                <input type="number" class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" name="telefono" value="{{ old('telefono', $sede->telefono ?? '') }}" required>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- search input box -->
                            <div class="form-group col-md-12 " id="SedeMapAddressContainer">
                                <label for="sedeinputaddress">Dirección de recolección (Mapa)</label><small class="help-block with-errors">*</small>
                                <div class="input-group">
                                    <input type="text" id="search_location" name="SedeMapAddressSearch" class="form-control" placeholder="Search location" value="{{ old('SedeMapAddressSearch') }}">
                                </div>
                            </div>
                            <br>
                            <!-- display google map -->
                            <div id="geomap" style="width: 100%;height: 400px;" ></div>

                            <!-- display selected location information -->
                            <div class="col-md-12 form-group">
                                <label for="latitud">Latitud</label><small class="help-block with-errors">*</small>
                                <input type= "text" id="latitud" name="latitud" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="longitud">Longitud</label><small class="help-block with-errors">*</small>
                                <input type= "text" id="longitud" name="longitud" class="form-control">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($sede) ? 'Actualizar' : 'Guardar' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

     <!-- Cargar de jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <!-- Hoja de estilos de jQuery UI -->
     <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
 
     <!-- jQuery UI (que depende de jQuery) -->
     <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
 
     <!-- Script de Google Maps, que usa la función iniciarMapa -->
     <!--<script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=iniciarMapa"></script>-->
     <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmXZYVyhhC1GkMIel7Cln3g-8zftcmGac&libraries=places&callback=iniciarMapa"></script>
 
     <script>
         var map; // Declara map a nivel global
         var  geocoder; // Declara geocoder a nivel global
         var autocompletar;
         var sede = {!! json_encode($sede) !!};
 
         const input = document.getElementById('search_location');
         //Función para iniciar el mapa
         function iniciarMapa() {
            var latitud = parseFloat(sede.SedeMapLat); //Obtiene la latitud de entrada y se convierte en números flotantes, y se deja un valor predeterminado
            var longitud = parseFloat(sede.SedeMapLong); //Obtiene la longitud de entrada y se convierten en números flotantes, y se deja un valor predeterminado
 
             // Validación de las coordenadas
             if (!isNaN(latitud) && !isNaN(longitud)) {
                 generarMapa(latitud, longitud); // Pasar las coordenadas correctas
             } else {
                 console.error("Error: Las coordenadas son inválidas.");
             }
         }
         //Función para generar el mapa    
         function generarMapa(latitud, longitud) { //En la función se pasa las variables de latitud y longitud
             map = new google.maps.Map(document.getElementById('geomap'), {
                 zoom: 12, // Tamaño del mapa
                 center: new google.maps.LatLng(latitud, longitud), // Corrección de nombres de variables
             });
             // Creación del marcador de la ubicación (Rojo) 
             marcador = new google.maps.Marker({
                 map:map, // Asocia el marcador al mapa creado anteriormente
                 draggable: true, //Parmite que el marcardor se pueda mover
                 position: new google.maps.LatLng(latitud, longitud)
             })   
 
             //Crea evento para seleccionar la latitud y la longitud de la ubicacion colocada en el mapa
             marcador.addListener('dragend', function(event){
                 document.getElementById('latitud').value = this.getPosition().lat();
                 document.getElementById('longitud').value = this.getPosition().lng();
             })
 
             initAutocomplete();
 
         }   
         //Función para el buscador de direcciones
         function initAutocomplete(){
             //Se habilita el autocompletar del buscador
             autocompletar = new google.maps.places.Autocomplete(input)
             // Se crea el evento que toma el id del input y lo asocia al autocompletar
             autocompletar.addListener('place_changed', function(){
                 const lugar = autocompletar.getPlace();
                 map.setCenter(lugar.geometry.location);
                 marcador.setPosition(lugar.geometry.location);
 
                     //Se guardan las coordenadas en la variable
                     const latitud = lugar.geometry.location.lat();
                     const longitud = lugar.geometry.location.lng();
                     // Se guardan las coordenadas en los inputs
                     document.getElementById('latitud').value = latitud;
                     document.getElementById('longitud').value = longitud;
             })
 
         }     
     </script>    
</body>
</html> 