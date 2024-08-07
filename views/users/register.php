<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form id="register-form" action="../../index.php?action=register" method="post">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Registrar</button>
    </form>
    <p><a href="login.php">Volver a Inicio de Sesión</a></p>
</body>
</html>
