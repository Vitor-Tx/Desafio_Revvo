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
