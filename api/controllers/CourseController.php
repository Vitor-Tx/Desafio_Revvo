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
        )
            return json_encode([
                "success" => false,
                "message" => "Required data not informed"
            ]);
        $this->course->title = $data['title'];
        $this->course->description = $data['description'];
        $this->course->thumbnail = $data['thumbnail'];
        $this->course->images = htmlspecialchars_decode(json_encode($data['images']));
        $this->course->link = $data['link'];

        return $this->course->create()
            ? json_encode([
                "success" => true,
                "message" => "Course created successfully",
            ])
            : json_encode([
                "success" => false,
                "message" => "Course creation failed",
            ]);
    }

    public function delete($id)
    {
        if (!isset($data['id']) || !$this->course->exists($id)) {
            return json_encode([
                "success" => false,
                "message" => "Course not found",
            ]);
        }

        $this->course->id = $id;
        return $this->course->delete()
            ? json_encode([
                "success" => true,
                "message" => "Course deleted successfully",
            ])
            : json_encode([
                "success" => false,
                "message" => "Course deletion failed",
            ]);
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
            return json_encode([
                "success" => false,
                "message" => "Course not found",
            ]);
        }
    }

    public function update($data)
    {
        if (!isset($data['id']) || !$this->course->exists($data['id'])) {
            return json_encode([
                "success" => false,
                "message" => "Course not found",
            ]);
        }

        $this->course->id = $data['id'];

        $updateSuccess = $this->course->update();
        if ($updateSuccess) {
            return json_encode([
                "success" => true,
                "message" => "Course updated successfully",
            ]);
        } else {
            return json_encode([
                "success" => false,
                "message" => "Course update failed",
            ]);
        }
    }
}
