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
        $this->course->title = $data['title'];
        $this->course->description = $data['description'];
        $this->course->thumbnail = $data['thumbnail'];
        $this->course->images = htmlspecialchars_decode(json_encode($data['images']));  // Encode images array to JSON
        $this->course->link = $data['link'];

        return $this->course->create() ? json_encode(["message" => "Course created successfully"]) : json_encode(["message" => "Course creation failed"]);
    }

    public function delete($id)
    {
        $this->course->id = $id;
        return $this->course->delete() ? json_encode(["message" => "Course deleted successfully"]) : json_encode(["message" => "Course deletion failed"]);
    }

    public function getAll()
    {
        $stmt = $this->course->readAll();
        $courses = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = $row;
        }

        return json_encode($courses);
    }

    public function getOne($id)
    {
        $this->course->id = $id;
        $stmt = $this->course->readOne();

        if ($stmt->rowCount() > 0) {
            return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            return json_encode(["message" => "Course not found"]);
        }
    }

    public function update($data)
    {
        $this->course->id = $data['id'];
        $this->course->title = $data['title'];
        $this->course->description = $data['description'];
        $this->course->thumbnail = $data['thumbnail'];
        $this->course->images = json_encode($data['images']);
        $this->course->link = $data['link'];

        return $this->course->update() ? json_encode(["message" => "Course updated successfully"]) : json_encode(["message" => "Course update failed"]);
    }
}
