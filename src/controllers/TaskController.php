<?php
require_once('../models/Task.php');
require_once('../config/database.php');

class TaskController {
    private $conn;
    private $task;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->task = new Task($this->conn);
    }

    public function getAllTasks() {
        $stmt = $this->task->getAllTasks();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($tasks);
    }

    public function getTaskById($id) {
        $stmt = $this->task->getTaskById($id);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($task) {
            echo json_encode($task);
        } else {
            echo json_encode(['message' => 'Task not found']);
        }
    }

    public function createTask($data) {
        if ($this->task->createTask($data)) {
            echo json_encode(['message' => 'Task created']);
        } else {
            echo json_encode(['message' => 'Task not created']);
        }
    }

    public function updateTask($id, $data) {
        if ($this->task->updateTask($id, $data)) {
            echo json_encode(['message' => 'Task updated']);
        } else {
            echo json_encode(['message' => 'Task not updated']);
        }
    }

    public function deleteTask($id) {
        if ($this->task->deleteTask($id)) {
            echo json_encode(['message' => 'Task deleted']);
        } else {
            echo json_encode(['message' => 'Task not deleted']);
        }
    }
}
?>
