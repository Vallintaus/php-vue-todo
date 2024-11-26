<?php 

namespace Jusa\Backend\Controllers;


use Jusa\Backend\Models\Task;

class TaskController
{
    private Task $task;

    public function __construct()
    {
        $this->task = new Task();
    }

    public function handleRequest(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $method = $_SERVER['REQUEST_METHOD'];
        $input = json_decode(file_get_contents('php://input'), true);

        switch ($method) {
            case 'GET':
                echo json_encode($this->task->getAll());
                break;

            case 'POST':
                if (!empty($input['title'])) {
                    echo json_encode($this->task->create($input['title']));
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Title is required']);
                }
                break;

            case 'PUT':
                $urlParts = explode('/', $_SERVER['REQUEST_URI']);
                $id = end($urlParts);
            
                if (is_numeric($id) && isset($input['completed'])) {
                    $success = $this->task->update($id, $input['completed']);
                    if ($success) {
                        echo json_encode(['id' => $id, 'completed' => $input['completed']]);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Failed to update task']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid input']);
                }
                break;

            case 'DELETE':
                $urlParts = explode('/', $_SERVER['REQUEST_URI']);
                $id = end($urlParts);
                if ($this->task->delete($id)) {
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Failed to delete task']);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
                break;
        }
    }
}