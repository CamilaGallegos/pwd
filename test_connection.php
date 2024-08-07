<?php
require_once 'src/config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    echo 'Conexión exitosa :D';
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}