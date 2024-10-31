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
        $this->course->images = htmlspecialchars_decode(json_encode($data['images']));
        $this->course->link = $data['link'];

        return $this->course->create() ? json_encode(["message" => "Course created successfully"]) : json_encode(["message" => "Course creation failed"]);
    }
}
