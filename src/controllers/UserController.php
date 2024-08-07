<?php

class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            if ($this->userModel->createUser($username, $hashedPassword)) {
                echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        }
    }
}
