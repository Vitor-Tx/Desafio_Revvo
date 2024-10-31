<?php
require_once 'config/db.php';

class Course
{
    private $conn;
    private $table = "courses";

    public $id;
    public $title;
    public $description;
    public $thumbnail;
    public $images;
    public $link;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " SET title=:title, description=:description, thumbnail=:thumbnail, images=:images, link=:link";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->thumbnail = htmlspecialchars(strip_tags($this->thumbnail));
        $this->images = htmlspecialchars(strip_tags($this->images));
        $this->link = htmlspecialchars(strip_tags($this->link));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":thumbnail", $this->thumbnail);
        $stmt->bindParam(":images", $this->images);
        $stmt->bindParam(":link", $this->link);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
