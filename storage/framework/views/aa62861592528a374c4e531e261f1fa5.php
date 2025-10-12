<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    
    <style>
        .navbar {
            background: linear-gradient(135deg, #1565C0, #64B5F6);
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        #controlSidebar {
            position: fixed;
            right: 0;
            top: 0;
            width: 300px;
            height: 100vh;
            background: linear-gradient(135deg, #64B5F6, #1565C0);
            color: white;
            padding: 20px;
            display: none; 
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div id="app">
        <?php
            $usuario = auth()->user();
        ?>
        
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/dashboard')); ?>">
                    ProsarApp
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <?php if(auth()->guard()->check()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('users.index')); ?>">Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('personal.index')); ?>">Personal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('sedes.index')); ?>">Sedes</a>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <?php if(auth()->guard()->guest()): ?>
                            <?php if(Route::has('login')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->Nombre); ?>

                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">
                                        <i class="fas fa-user me-2"></i><?php echo e(__('Mi Perfil')); ?>

                                    </a>
                                    
                                    <?php if(strtolower(trim(Auth::user()->UsRol)) == 'cliente' || strtolower(trim(Auth::user()->UsRol)) == 'clientes'): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('facturacion.show')); ?>">
                                        <i class="fas fa-receipt me-2"></i><?php echo e(__('Facturación Electrónica')); ?>

                                    </a>
                                    <?php endif; ?>
                                    
                                    <div class="dropdown-divider"></div>
                                    
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i><?php echo e(__('Cerrar Sesión')); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                            
                            <?php if(Auth::user()->email == 'sistemas@prosarc.com.co' || Auth::user()->email == 'sistemas2@prosarc.com.co'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="toggleSidebar">
                                    <i class="fa fa-cogs"></i>
                                </a>
                            </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Panel lateral para administración de roles (oculto por defecto) -->
        <?php if(auth()->guard()->check()): ?>
        <aside id="controlSidebar" class="control-sidebar">  
            <div class="tab-content">
                <div class="tap-pane active" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Panel de administración de roles</h3>
                </div>    
                <ul class="control-sidebar-menu">
                    <form action="/changerol/<?php echo e($usuario->Id_User); ?>" style="margin: 1em;" method="POST">
                        <?php echo csrf_field(); ?>
                        <label class="form-label">Seleccione el rol</label>
                        <select class="form-select" id="rol" name="usrol">
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
        <?php endif; ?>

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    
    <!-- JavaScript para alternar la visibilidad del panel -->
    <?php if(auth()->guard()->check()): ?>
    <?php if(Auth::user()->email == 'sistemas@prosarc.com.co' || Auth::user()->email == 'sistemas2@prosarc.com.co'): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            // Ocultar el sidebar si se hace clic fuera de él
            document.addEventListener("click", function (event) {
                const sidebar = document.getElementById("controlSidebar");
                const toggleButton = document.getElementById("toggleSidebar");

                // Verificar si el clic fue fuera del sidebar y fuera del botón de toggle
                const clicFueraSidebar = !sidebar.contains(event.target);
                const clicFueraBoton = !toggleButton.contains(event.target);

                if (sidebar.style.display === "block" && clicFueraSidebar && clicFueraBoton) {
                    sidebar.style.display = "none";
                }
            });
        });
    </script>
    <?php endif; ?>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\laragon\www\prosarapp\bakend\resources\views/layouts/app.blade.php ENDPATH**/ ?>