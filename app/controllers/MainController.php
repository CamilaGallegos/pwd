<?php
require_once 'app/models/Task.php';
class MainController //clase que actua como controlador principal
{
    private $pdo;
    private $taskModel;

    public function __construct($pdo)
    {
        session_start();
        $this->pdo = $pdo;
        $this->taskModel = new Task($pdo);
    }

    public function index() //metodo que manejara la pagina principal de la app
    {
        // Obtener todos los eventos
        $tasks = $this->taskModel->getAllTasks();

        // Verificar si el usuario ha iniciado sesión
        $isLoggedIn = $this->isLoggedIn();

        // Incluir la vista index.php y pasar los datos de los eventos y el estado de inicio de sesión
        require 'app/views/index.php';
    }

    public function create()
    {
        if ($this->isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name']);
                $description = trim($_POST['description']);

                if (empty($name) || empty($description)) {
                    echo "Todos los campos son obligatorios.";
                } else {
                    $taskModel = new Task($this->pdo);
                    $taskModel->createTask($name, $description);
                    header('Location: index.php');
                }
            } else {
                require 'app/views/events/create.php';
            }
        } else {
            header('Location: index.php?action=login');
        }
    }

    public function delete($id)
    {
        if ($this->isLoggedIn()) {
            //$taskModel = new Task($this->pdo);
            $this->taskModel->deleteTask($id);
            header('Location: index.php');
        } else {
            header('Location: index.php?action=login');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: index.php');
            } else {
                echo "Nombre de usuario o contraseña incorrectos.";
            }
        } else {
            require 'app/views/users/login.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
    }

    private function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function edit($id)
    {
        if ($this->isLoggedIn()) {
            $task = $this->taskModel->getTaskById($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name']);
                $description = trim($_POST['description']);

                if (empty($name) || empty($description)) {
                    echo "Todos los campos son obligatorios.";
                } else {
                    $this->taskModel->updateTask($id, $name, $description);
                    header('Location: index.php');
                }
            } else {
                require 'app/views/events/edit.php';
            }
        } else {
            header('Location: index.php?action=login');
        }
    }

    public function update($id)
    {
        if ($this->isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $this->taskModel->updateTask($id, $name, $description);
                header('Location: index.php');
            } else {
                header('Location: index.php');
            }
        } else {
            header('Location: index.php?action=login');
        }
    }
}
