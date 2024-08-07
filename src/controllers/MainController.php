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

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            $username = trim($data['username']);
            $password = trim($data['password']);
            
            if (empty($username) || empty($password)) {
                echo json_encode(['message' => 'Todos los campos son obligatorios']);
                return;
            }

            //busca el usuario en la db
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user && password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                echo json_encode(['success' => true]);
            }else{
                echo json_encode(['message' => 'Usuario o contrasela incorrecta']);
            }
        }else{
            echo json_encode(['message' => 'Acción no válida']);
            //require __DIR__ . '/../views/users/login.php';
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

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
            if (empty($username) || empty($password)){
                echo json_encode(['message' => 'Todos los campos son obligatorios']);
                return;
            }
    
            //crea el usuario
            $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hash);
    
            if ($stmt->execute()){
                echo json_encode(['message' => 'Usuario creado exitosamente']);
            }else{
                echo json_encode(['message' => 'Error al crear el usuario']);
            }
        }else{
            require 'views/users/register.php';
        }
    }
}
