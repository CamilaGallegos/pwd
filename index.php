<?php
// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'src/config/config.php';
require_once 'src/controllers/MainController.php';
require_once 'src/models/Task.php';
require_once __DIR__ . '/src/routes/Api.php';
require_once 'src/config/database.php';

session_start();

/*try {
    //crea una instancia de satabase y obtiene la conexión pdo ???
    $database = new Database();
    $pdo = $database->getConnection();
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    die();
}*/
$database = new Database();
$db = $database->getConnection();
//crea una instancia del controlador y llamar al método index
$mainController = new MainController($db);

//$action = isset($_GET['action']) ? $_GET['action'] : '';
//$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

//$mainController->handleRequest($action, $id);

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mainController->login();
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Método no permitido']);
        }
        break;
    case 'logout':
        $mainController->logout();
        break;
    default:
        $mainController->index();
        break;
}
