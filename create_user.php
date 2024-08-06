<?php
// Conectar a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=guemes_db', 'root', '21dia01mes');

// Encriptar la contraseña
$password = password_hash('21dia01mes', PASSWORD_DEFAULT);

// Insertar el usuario con la contraseña encriptada
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute(['camilagallegos', $password]);

echo "Usuario creado exitosamente :)))";
