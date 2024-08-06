<?php
$host = 'localhost';
$db = 'guemes_db';
$user = 'root';
$pass = '21dia01mes';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

define('BASE_URL', 'http://localhost/guemes/');