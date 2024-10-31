<?php
require_once 'models/Course.php';

class CourseController
{
    private $course;

    public function __construct($db)
    {
        $this->course = new Course($db);
    }

    public function create($data)
    {
        if (
            !isset($data['title'])
            || !isset($data['description'])
            || !isset($data['thumbnail'])
            || !isset($data['images'])
            || !isset($data['link'])
        ) {
            http_response_code(400);
            return json_encode([
                "success" => false,
                "message" => "Required data not informed"
            ]);
        }

        $this->course->title = $data['title'];
        $this->course->description = $data['description'];
        $this->course->thumbnail = $data['thumbnail'];
        $this->course->images = htmlspecialchars_decode(json_encode($data['images']));
        $this->course->link = $data['link'];

        if ($this->course->create()) {
            http_response_code(201);
            return json_encode([
                "success" => true,
                "message" => "Course created successfully",
            ]);
        } else {
            http_response_code(500);
            return json_encode([
                "success" => false,
                "message" => "Course creation failed",
            ]);
        }
    }

    public function delete($id)
    {
        if (!$this->course->exists($id)) {
            http_response_code(404);
            return json_encode([
                "success" => false,
                "message" => "Course not found",
            ]);
        }

        $this->course->id = $id;
        if ($this->course->delete()) {
            http_response_code(200);
            return json_encode([
                "success" => true,
                "message" => "Course deleted successfully",
            ]);
        } else {
            http_response_code(500);
            return json_encode([
                "success" => false,
                "message" => "Course deletion failed",
            ]);
        }
    }

    public function getAll()
    {
        $stmt = $this->course->readAll();
        $courses = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = $row;
        }

        if ($stmt->rowCount() > 0) {
            return json_encode([
                "success" => true,
                "message" => "Courses found",
                "data" => $courses
            ]);
        } else {
            http_response_code(404);
            return json_encode([
                "success" => false,
                "message" => "No Course found",
            ]);
        }
    }

    public function getOne($id)
    {
        $this->course->id = $id;
        $stmt = $this->course->readOne();

        if ($stmt->rowCount() > 0) {
            return json_encode([
                "success" => true,
                "message" => "Course found",
                "data" => $stmt->fetch(PDO::FETCH_ASSOC)
            ]);
        } else {
            http_response_code(404);
            return json_encode([
                "success" => false,
                "message" => "Course not found",
            ]);
        }
    }

    public function update($data)
    {
        if (!isset($data['id']) || !$this->course->exists($data['id'])) {
            http_response_code(404);
            return json_encode([
                "success" => false,
                "message" => "Course not found",
            ]);
        }

        $this->course->id = $data['id'];
        $this->course->title = $data['title'] ?? "";
        $this->course->description = $data['description'] ?? "";
        $this->course->thumbnail = $data['thumbnail'] ?? "";
        $this->course->images = htmlspecialchars_decode(json_encode($data['images']  ?? []));
        $this->course->link = $data['link'] ?? "";

        if ($this->course->update()) {
            return json_encode([
                "success" => true,
                "message" => "Course updated successfully",
            ]);
        } else {
            http_response_code(500);
            return json_encode([
                "success" => false,
                "message" => "Course update failed",
            ]);
        }
    }
}
