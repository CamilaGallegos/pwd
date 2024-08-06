<?php
class Task //clase tarea
{
    private $pdo; //almacena conexion a la db

    public function __construct($pdo) //el constructor recibe la conexion y la asigna a pdo
    {
        $this->pdo = $pdo;
    }

    public function getAllTasks() //este metodo ejecuta una cnsulta sql
    {
        $stmt = $this->pdo->query('SELECT * FROM tasks'); //obtiene toda la tarea de la tabla tasks
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //y devuelve un array asociativo
    }

    public function createTask($name, $description)
    {
        $stmt = $this->pdo->prepare('INSERT INTO tasks (name, description) VALUES (:name, :description)');
        $stmt->execute(['name' => $name, 'description' => $description]);
    }

    public function deleteTask($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function getTaskById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTask($id, $name, $description)
    {
        $stmt = $this->pdo->prepare('UPDATE tasks SET name = :name, description = :description WHERE id = :id');
        $stmt->execute(['name' => $name, 'description' => $description, 'id' => $id]);
    }
}
