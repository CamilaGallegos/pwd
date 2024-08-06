<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/styles.css">
    <title>Editar Evento</title>
</head>

<body>
    <h1>Editar Evento</h1>
    <form action="index.php?action=edit&id=<?php echo $task['id']; ?>" method="post">
        <label for="name">Nombre del Evento:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($task['name'] ?? ''); ?>" required>
        <br>
        <label for="description">Descripción:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($task['description'] ?? ''); ?></textarea>
        <br>
        <button type="submit">Guardar Cambios</button>
    </form>
    <p><a href="index.php">Volver</a></p>
</body>

</html>