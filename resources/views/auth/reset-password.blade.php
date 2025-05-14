<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - ProsarApp</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1565C0, #64B5F6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .reset-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(21, 101, 192, 0.25);
            border-color: #1565C0;
        }
        .btn-primary {
            padding: 0.75rem;
            background-color: #1565C0;
            border-color: #1565C0;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #0D47A1;
            border-color: #0D47A1;
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="logo">
            <h2 class="mb-3">ProsarApp</h2>
            <p class="text-muted">Restablecer Contraseña</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                <input type="password" class="form-control" 
                       id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Restablecer Contraseña
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-decoration-none" style="color: #1565C0;">
                    Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 