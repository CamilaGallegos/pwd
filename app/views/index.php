<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>La Güemes</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">La Güemes</div>
            <div class="menu">
                <a href="#">Inicio</a>
                <a href="#">Eventos</a>
                <a href="#">Galería</a>
                <a href="#">Contacto</a>
            </div>
            <div class="login">
                <?php if ($this->isLoggedIn()) : ?>
                    <a href="index.php?action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                <?php else : ?>
                    <a href="index.php?action=login"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <section class="events">
            <h1>Eventos de La Güemes</h1>

            <?php if ($this->isLoggedIn()) : ?>
                <a href="index.php?action=create" class="btn btn-primary">Crear nuevo evento</a>
            <?php endif; ?>

            <?php if (empty($tasks)) : ?>
                <p>No hay eventos disponibles.</p>
            <?php else : ?>
                <ul>
                    <?php foreach ($tasks as $task) : ?>
                        <li>
                            <strong><?php echo htmlspecialchars($task['name'] ?? ''); ?></strong>: <?php echo htmlspecialchars($task['description'] ?? ''); ?>
                            <?php if ($this->isLoggedIn()) : ?>
                                <a href="index.php?action=edit&id=<?php echo $task['id']; ?>" class="btn btn-secondary">Editar</a>
                                <form action="index.php?action=delete&id=<?php echo $task['id']; ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section class="gallery">
            <h2>Galería de Fotos</h2>
            <div class="photo-grid">
                <!-- Ejemplo de foto -->
                <div class="photo">
                    <img src="path/to/photo.jpg" alt="Foto evento">
                </div>
                <!-- Más fotos -->
            </div>
        </section>
    </main>

    <footer>
        <p class="social-media-p">Contactanos en nuestras redes sociales:</p>
        <div class="social-media">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="https://www.instagram.com/laguemes.curzas/">Instagram</a>
        </div>
        <p class="social-media-p">Ubicación: monseñor, Ciudad, País</p>
    </footer>
</body>

</html>