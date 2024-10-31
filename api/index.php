<?php
require_once 'config/db.php';
require_once 'controllers/CourseController.php';

$database = new Database();
$db = $database->getConnection();
$courseController = new CourseController($db);

http_response_code(200);
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $response = $courseController->create($data);
    echo $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id'])) {
        $response = $courseController->delete($data['id']);
        echo $response;
    } else {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Course ID not provided"
        ]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $response = $courseController->getAll();
    echo $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $response = $courseController->getOne($_GET['id']);
    echo $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id'])) {
        $response = $courseController->update($data);
        echo $response;
    } else {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Course ID not provided"
        ]);
    }
}
