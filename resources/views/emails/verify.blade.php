<!DOCTYPE html>
<html>
<head>
    <title>Verifica tu correo electrónico</title>
</head>
<body>
    <h1>¡Bienvenido a ProsarApp!</h1>
    <p>Por favor verifica tu correo electrónico haciendo clic en el siguiente enlace:</p>
    <a href="{{ url('/verify-email/' . $token) }}">Verificar correo electrónico</a>
    <p>Si no has creado una cuenta en ProsarApp, por favor ignora este correo.</p>
</body>
</html> 