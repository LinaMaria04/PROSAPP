@php
    use App\Models\User;
    use App\Http\Controllers\rolescontroller;

    $usuario = auth()->user();

    dd($usuario);

@endphp
<style>
    .navbar {
            background: linear-gradient(135deg, #1565C0, #64B5F6);
        }   

    .hidden {
        display: none;
    }    
    
</style>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">ProsarApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="toggleSidebar">
                        <i class="fa fa-cogs"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Panel lateral (oculto por defecto) -->
<aside id="controlSidebar" class="control-sidebar ">  
    <div class="tab-content">
        <div class="tap-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Panel de administración de roles</h3>
        </div>    
        <ul class="control-sidebar-menu">
            <!-- Aquí iría el permiso de rol administrador cuando ya se tengan creados -->
            <form action="/changerol" style="margin: 1em;" method="POST">
                @csrf
                <label for ="rol">Seleccione el rol</label>
                <select id="rol" name="usrol">
                    <option>Administrador</option>
                    <option>Cliente</option>
                    <option>Conductor</option>
                    <option>Asesor Comercial</option>
                    <option>Tesoreria</option>
                    <option>PDA</option>
                    <option>Logística</option>
                </select>
                <button style="margin: 1em;" type="submit" class="btn btn-success pull-right">Guardar</button>
            </form>  

        </ul>
    </div>
</aside>

<!-- Estilos para ocultar el panel -->
<style>
    #controlSidebar {
        position: fixed;
        right: 0;
        top: 0;
        width: 300px;
        height: 100vh;
        background: white;
        color: black;
        padding: 20px;
        display: none; 
    }
</style>

<!-- JavaScript para alternar la visibilidad del panel -->
<script>
    document.getElementById("toggleSidebar").addEventListener("click", function (event) {
        event.preventDefault(); // Evita que la página se recargue
        let sidebar = document.getElementById("controlSidebar");

        // Alternar visibilidad
        if (sidebar.style.display === "none" || sidebar.style.display === "") {
            sidebar.style.display = "block"; // Mostrar el panel
        } else {
            sidebar.style.display = "none"; // Ocultar el panel
        }
    });
</script>



  