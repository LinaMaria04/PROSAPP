<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
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
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1565C0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        
        <p>Hola {{ $user->Nombre }},</p>

        <p>Has solicitado restablecer tu contraseña en ProsarApp. Haz clic en el siguiente botón para crear una nueva contraseña:</p>

        <p style="text-align: center;">
            <a href="{{ url('reset-password/' . $token) }}" class="button">
                Restablecer Contraseña
            </a>
        </p>

        <p>Si el botón no funciona, puedes copiar y pegar el siguiente enlace en tu navegador:</p>
        <p style="word-break: break-all;">
            {{ url('reset-password/' . $token) }}
        </p>

        <p>Este enlace expirará en 60 minutos por razones de seguridad.</p>

        <p>Si no solicitaste restablecer tu contraseña, puedes ignorar este correo y tu contraseña permanecerá sin cambios.</p>

        <div class="footer">
            <p>© {{ date('Y') }} ProsarApp. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html> 