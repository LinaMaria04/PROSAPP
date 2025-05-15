<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la sede - ProsarApp</title>
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
        .detail-item {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
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
                        <h4 class="card-title mb-4">Detalles de la sede</h4>
                            <h5 class="card-title text-center">{{$sede?->NombreSede}}</h5>  

                            <div class="detail-item">
                                <div class="detail-label">Persona Encargada</div>
                                <div>{{ $persona->PrimerNombre}} {{ $persona->SegundoNombre}} {{$persona->Apellidos}}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Correo</div>
                                <div>{{$sede->Correo}}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Telefono</div>
                                <div>{{$sede->telefono}}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Direccion</div>
                                <div>{{$sede->Direccion}}</div>
                            </div>

                            <div id="geomap" style="width: 100%;height: 400px;" ></div>

                            <div class="mt-4">
                                <a href="/sedes/{{$sede->SedeSlug}}/edit" class="btn btn-warning me-2">
                                    <i class='bx bx-edit'></i> Editar
                                </a>
                            {{--<form action="{{ route('personal.destroy', $persona->id) }}" method="POST" class="d-inline">--}}
                                <form action="" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                    <i class='bx bx-trash'></i> Eliminar
                                </button>
                            </form>
                        </div>
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
        var sede = {!! json_encode($sede) !!}; //Trae los datos de la consulta del controlador y los convierte a JSON

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
                draggable: false, //Parmite que el marcardor se pueda mover
                position: new google.maps.LatLng(latitud, longitud)
            }) 
        }  

    </script>    
</body>
</html>