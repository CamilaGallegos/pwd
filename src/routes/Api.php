<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../controllers/TaskController.php';

$database = new Database();
$db = $database->getConnection();

$taskModel = new Task($db);
$taskController = new TaskController($taskModel);

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getAllTasks':
        echo json_encode($taskController->getAllTasks());
        break;
    case 'createTask':
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        echo json_encode($taskController->createTask($name, $description));
        break;
    case 'getTaskById':
        $id = $_GET['id'] ?? 0;
        echo json_encode($taskController->getTaskById($id));
        break;
    case 'updateTask':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        echo json_encode($taskController->updateTask($id, $name, $description));
        break;
    case 'deleteTask':
        $id = $_GET['id'] ?? 0;
        echo json_encode($taskController->deleteTask($id));
        break;
    case 'session':
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo json_encode(['isLoggedIn' => true]);
        }else{
            echo json_encode(['isLoggedIn' => false]);
        }
        break;
    default:
        echo json_encode(['message' => 'Invalid action']);
        break;
}

/*$router->get('/api/session', function() {
    session_start();
    if (isset($_SESSION['user_id'])) {
        echo json_encode(['isLoggedIn' => true]);
    } else {
        echo json_encode(['isLoggedIn' => false]);
    }
});*/