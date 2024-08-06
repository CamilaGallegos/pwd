<?php
require 'config.php';

try {
    $stmt = $pdo->query("SELECT 'Conexión exitosa :D' AS mensaje");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['mensaje'];
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
