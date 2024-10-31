<?php
require_once 'config/db.php';
require_once 'controllers/CourseController.php';

$database = new Database();
$db = $database->getConnection();
$courseController = new CourseController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo $courseController->create($data);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id'])) {
        echo $courseController->delete($data['id']);
    } else {
        echo json_encode(["message" => "Course ID not provided"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $courseController->getAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    echo $courseController->getOne($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id'])) {
        echo $courseController->update($data);
    } else {
        echo json_encode(["message" => "Course ID not provided"]);
    }
}
