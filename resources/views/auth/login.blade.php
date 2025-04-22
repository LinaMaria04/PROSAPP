<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'ProsarApp') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1565C0, #64B5F6);
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            padding: 0;
            overflow: hidden;
        }
        .login-header {
            background: #1565C0;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .login-body {
            padding: 30px;
        }
        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus {
            border-color: #1565C0;
            box-shadow: 0 0 0 0.2rem rgba(21, 101, 192, 0.25);
        }
        .btn-primary {
            background-color: #1565C0;
            border-color: #1565C0;
            padding: 12px;
            font-weight: 500;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #0D47A1;
            border-color: #0D47A1;
        }
        .form-check-input:checked {
            background-color: #1565C0;
            border-color: #1565C0;
        }
        .register-link {
            color: #1565C0;
            text-decoration: none;
        }
        .register-link:hover {
            color: #0D47A1;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h3 class="mb-0">{{ config('app.name', 'ProsarApp') }}</h3>
        </div>
        <div class="login-body">
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                </button>

                <div class="text-center">
                    <a href="{{ route('register') }}" class="register-link">
                        ¿No tienes una cuenta? Regístrate
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
