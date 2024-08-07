<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Inicio de Sesión</title>
</head>

<body>
    <h1>Inicio de Sesión</h1>
    <form id="login-form" action="../../index.php?action=login" method="post"><!---->
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p><a href="register.php">Crear una cuenta</a></p>
    <p><a href="../../index.html">Volver</a></p>
</body>
</html>