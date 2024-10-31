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

    public function exists($id)
    {
        $query = "SELECT COUNT(*) FROM courses WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " SET title=:title, description=:description, thumbnail=:thumbnail, images=:images, link=:link";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title ?? ""));
        $this->description = htmlspecialchars(strip_tags($this->description ?? ""));
        $this->thumbnail = htmlspecialchars(strip_tags($this->thumbnail ?? ""));
        $this->link = htmlspecialchars(strip_tags($this->link ?? ""));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":thumbnail", $this->thumbnail);
        $stmt->bindParam(":images", $this->images);
        $stmt->bindParam(":link", $this->link);

        return $stmt->execute();
    }

    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function readAll()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update()
    {
        $query = "UPDATE courses SET title = :title, description = :description, thumbnail = :thumbnail, images = :images, link = :link WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':thumbnail', $this->thumbnail);
        $stmt->bindParam(':images', $this->images);
        $stmt->bindParam(':link', $this->link);
        $stmt->bindParam(':id', $this->id);

        try {
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Update error: " . $e->getMessage());
            return false;
        }
    }


    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
