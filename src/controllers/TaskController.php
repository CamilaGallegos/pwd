<?php

class TaskController{
    private $task;

    public function __construct($task) {
        $this->task = $task;
    }

    public function getAllTasks(){ //maneja la solicitud de obteenr todas las tareas
        return $this->task->getAllTasks();
    }

    public function createTask(){ //maneja la solicitus de crear uan tarea
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';

            if (empty($name) || empty($description)) {
                echo json_encode(['message' => 'Todos los campos son obligatorios.']);
            } else {
                $this->task->createTask($name, $description);
                echo json_encode(['message' => 'Evento creado exitosamente.']);
            }
        } else {
            require 'views/events/create.php';
        }
    }

    public function getTaskById($id){//obtiene una tarea por id
        return $this->task->getTaskById($id);
    }

    public function updateTask($id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';

            if (empty($name) || empty($description)) {
                echo json_encode(['message' => 'Todos los campos son obligatorios.']);
            } else {
                $this->task->updateTask($id, $name, $description);
                echo json_encode(['message' => 'Evento actualizado exitosamente.']);
            }
        } else {
            require 'views/events/edit.php';
        }
    }

    public function deleteTask($id) {
        $this->task->deleteTask($id);
        echo json_encode(['message' => 'Evento eliminada exitosamente.']);
    }
    /*public function updateTask($id){
        $data = json_decode(file_get_contents('php://input'), true);
            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';

            if (empty($name) || empty($description)) {
                echo json_encode(['message' => 'Todos los campos son obligatorios.']);
            } else {
                $this->task->updateTask($id, $name, $description);
                echo json_encode(['message' => 'Evento actualizado exitosamente.']);
            }
            require 'views/events/edit.php';
        }
    }*/
}