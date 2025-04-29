<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo electrónico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin: 20px 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            background-color: #1565C0;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #666;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verifica tu correo electrónico</h1>
        </div>
        
        <p>Hola,</p>
        
        <p>Gracias por registrarte en ProsarApp. Para completar tu registro, por favor verifica tu dirección de correo electrónico haciendo clic en el botón de abajo:</p>
        
        <div style="text-align: center;">
            <a href="{{ route('verification.verify', ['id' => $user->Id_User, 'hash' => $user->verification_token]) }}" class="btn">
                Verificar correo electrónico
            </a>
        </div>
        
        <p>Si no creaste una cuenta en ProsarApp, puedes ignorar este correo.</p>
        
        <p>Si tienes problemas para hacer clic en el botón, copia y pega el siguiente enlace en tu navegador:</p>
        <p style="word-break: break-all;">
            {{ route('verification.verify', ['id' => $user->Id_User, 'hash' => $user->verification_token]) }}
        </p>
        
        <div class="footer">
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p>&copy; {{ date('Y') }} ProsarApp. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html> 