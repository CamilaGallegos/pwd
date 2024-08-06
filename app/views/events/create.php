<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="app/css/styles.css">
    <title>Crear Evento</title>
</head>

<body>
    <h1>Crear evento</h1>
    <form action="index.php?action=create" method="post">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="description">Descripción:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <button type="submit">Crear</button>
    </form>
    <p><a href="index.php">Volver</a></p>
</body>

</html>