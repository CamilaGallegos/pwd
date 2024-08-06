<?php 
require_once 'src/models/Task.php';
require_once 'src/controllers/TaskController.php';

class MainController {
    private $pdo;
    private $taskController;

    public function __construct($pdo) {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        };
        $this->pdo = $pdo;
        $taskModel = new Task($pdo);
        $this->taskController = new TaskController($taskModel);
    }

    public function index() {
        // Obtener todos los eventos usando TaskController
        $tasks = $this->taskController->getAllTasks();

        // Verificar si el usuario ha iniciado sesión
        $isLoggedIn = $this->isLoggedIn();
        require 'index.html';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($username === 'camilagallegos' && $password === '21dia01mes') {
                $_SESSION['isLoggedIn'] = true;
                header('Location: index.php'); //redirige a la pagina principal
                exit;
            }else{//redirige de nuevo al formulario de inicio de sesion con un mensaje de error
                $_SESSION['login_error'] = 'Usuario o contraseña incorrecta';
                header('Location: views/users/login.php');
                exit;
            }
        }else{
            require 'views/users/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: views/users/login.php');
        exit;
    }

    private function isLoggedIn() {
        return isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'];
    }
    

    public function handleRequest($action, $id = null) {
        if ($this->isLoggedIn()) {
            switch ($action) {
                case 'create':
                    $this->taskController->createTask($id);
                    break;
                case 'edit':
                    $this->taskController->updateTask($id);
                    break;
                case 'delete':
                    $this->taskController->deleteTask($id);
                    break;
                default:
                    $this->index();
                    break;
            }
        } else {
            header('Location: index.php?action=login');
        }
    }
}
