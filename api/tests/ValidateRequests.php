<?php

class ValidateRequests
{
    public static function assertEquals($expected, $actual)
    {
        if ($expected !== $actual) {
            echo "Test failed: Expected '" . json_encode($expected) . "', got '" . json_encode($actual) . "'.\n";
        } else {
            echo "Test passed: Expected '" . json_encode($expected) . "', got '" . json_encode($actual) . "'.\n";
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
        $response = @file_get_contents($url, false, $context);

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
            $data = [
                'success' => $response['success'],
                'message' => $response['message']
            ];
            self::assertEquals([
                'success' => true,
                'message' => 'Course created successfully'
            ], $data);
        } catch (Exception $e) {
            echo "Error creating course: " . $e->getMessage() . "\n";
        }
    }

    public static function testGetAllCourses()
    {
        try {
            $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php');
            $data = [
                'success' => $response['success'],
                'message' => $response['message']
            ];
            self::assertEquals([
                'success' => true,
                "message" => "Courses found"
            ], $data);
        } catch (Exception $e) {
            echo "Error fetching all courses: " . $e->getMessage() . "\n";
        }
    }

    public static function testGetCourseById()
    {
        try {
            $courseId = 2;
            $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php?id=' . $courseId);
            $data = [
                'success' => $response['success'],
                'message' => $response['message']
            ];
            self::assertEquals([
                'success' => true,
                "message" => "Course found"
            ], $data);
        } catch (Exception $e) {
            echo "Error fetching course by ID: " . $e->getMessage() . "\n";
        }
    }

    public static function testUpdateCourse()
    {
        try {
            $data = [
                'id' => '2',
                'title' => 'Updated PHP Basics',
            ];
            $response = self::apiRequest('PUT', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => true,
                'message' => 'Course updated successfully'
            ], $response);
        } catch (Exception $e) {
            echo "Error updating course: " . $e->getMessage() . "\n";
        }
    }

    public static function testDeleteCourse()
    {
        try {
            $data = [
                'id' => '22',
            ];
            $response = self::apiRequest('DELETE', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals(['success' => true, 'message' => 'Course deleted successfully'], $response);
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
