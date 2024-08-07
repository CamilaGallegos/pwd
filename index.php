<?php
// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'src/config/config.php';
require_once 'src/controllers/MainController.php';
require_once 'src/models/Task.php';
require_once 'src/controllers/UserController.php';
require_once 'src/models/User.php';
require_once __DIR__ . '/src/routes/Api.php';
require_once 'src/config/database.php';

session_start();

try {
    $database = new Database();
    $pdo = $database->getConnection();
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    die();
}

$taskModel = new Task($pdo);
$mainController = new MainController($pdo);
$userModel = new User($pdo);
$userController = new UserController($userModel);

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

switch ($action) {
    case 'create':
        $mainController->create();
        break;
    case 'delete':
        if ($id !== null) {
            $mainController->delete($id);
        }
        break;
    case 'edit':
        if ($id !== null) {
            $mainController->edit($id);
        }
        break;
    case 'login':
        $userController->login();
        break;
    case 'logout':
        $userController->logout();
        break;
    case 'register':
        $userController->register();
        break;
    default:
        echo json_encode(['message' => 'Acción no válida']);
        break;
}
