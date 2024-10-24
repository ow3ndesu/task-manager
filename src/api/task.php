<?php
// Include database and controller
require_once('../config/database.php');
require_once('../controllers/TaskController.php');

// Set headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];
$controller = new TaskController();

// Switch based on the request method
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $controller->getTaskById($_GET['id']);
        } else {
            $controller->getAllTasks();
        }
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $controller->createTask($data);
        break;

    case 'PUT':
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents("php://input"));
            $controller->updateTask($_GET['id'], $data);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $controller->deleteTask($_GET['id']);
        }
        break;

    default:
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
?>
