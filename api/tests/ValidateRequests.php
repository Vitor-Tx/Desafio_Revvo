<?php

class ValidateRequests
{
    public static function assertEquals($expected, $actual)
    {
        if ($expected !== $actual) {
            echo "Test failed: Expected '" . "', got '" . "'.\n";
        } else {
            echo "Test passed: Expected and actual are equal.\n";
        }
    }
    public static function apiRequest($method, $url, $data = null)
    {
        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => strtoupper($method),
            ],
        ];

        if ($data) {
            $options['http']['content'] = json_encode($data);
        }

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new Exception("Error making API request to $url");
        }

        return json_decode($response, true);
    }

    public static function testCreateCourse()
    {
        try {
            $data = [
                'title' => 'PHP Basics',
                'description' => 'Learn the fundamentals of PHP programming.',
                'thumbnail' => 'uploads/php_basics_thumbnail.jpg',
                'images' => ['uploads/php_intro_1.jpg', 'uploads/php_intro_2.jpg'],
                'link' => 'https://example.com/php-basics',
            ];
            $response = self::apiRequest('POST', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals(['message' => 'Course created successfully'], $response);
        } catch (Exception $e) {
            echo "Error creating course: " . $e->getMessage() . "\n";
        }
    }

    public static function testGetAllCourses()
    {
        try {
            $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php');
            $expectedResponse = [
                ['id' => 1, 'title' => 'PHP Basics', 'description' => 'Learn PHP.', 'thumbnail' => 'example.jpg', 'link' => 'example.com'],
            ];
            self::assertEquals($expectedResponse, $response);
        } catch (Exception $e) {
            echo "Error fetching all courses: " . $e->getMessage() . "\n";
        }
    }

    public static function testGetCourseById()
    {
        try {
            $courseId = 2;
            $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php?id=' . $courseId);
            $expectedResponse = ['id' => 1, 'title' => 'PHP Basics', 'description' => 'Learn PHP.', 'thumbnail' => 'example.jpg', 'link' => 'example.com'];
            self::assertEquals($expectedResponse, $response);
        } catch (Exception $e) {
            echo "Error fetching course by ID: " . $e->getMessage() . "\n";
        }
    }

    public static function testUpdateCourse()
    {
        try {
            $courseId = 2;
            $data = [
                'id' => '2',
                'title' => 'Updated PHP Basics',
                'description' => 'Learn the fundamentals of PHP programming with updates.',
            ];
            $response = self::apiRequest('PUT', 'http://localhost/revvo-test/api/index.php?id=' . $courseId, $data);
            self::assertEquals(['message' => 'Course updated successfully'], $response);
        } catch (Exception $e) {
            echo "Error updating course: " . $e->getMessage() . "\n";
        }
    }

    public static function testDeleteCourse()
    {
        try {
            $courseId = 22;
            $data = [
                'id' => '22',
            ];
            $response = self::apiRequest('DELETE', 'http://localhost/revvo-test/api/index.php?id=' . $courseId, $data);
            self::assertEquals(['message' => 'Course deleted successfully'], $response);
        } catch (Exception $e) {
            echo "Error deleting course: " . $e->getMessage() . "\n";
        }
    }
}

ValidateRequests::testCreateCourse();
ValidateRequests::testGetAllCourses();
ValidateRequests::testGetCourseById();
ValidateRequests::testUpdateCourse();
ValidateRequests::testDeleteCourse();
