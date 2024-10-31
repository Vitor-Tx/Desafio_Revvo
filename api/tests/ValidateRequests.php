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

    public static function testCreateCourseWithoutTitle()
    {
        try {
            $data = [
                'description' => 'Learn the fundamentals of PHP programming.',
                'thumbnail' => 'uploads/php_basics_thumbnail.jpg',
                'images' => ['uploads/php_intro_1.jpg', 'uploads/php_intro_2.jpg'],
                'link' => 'https://example.com/php-basics',
            ];
            $response = self::apiRequest('POST', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => false,
                'message' => 'Required data not informed',
            ], $response);
        } catch (Exception $e) {
            echo "Error creating course without title: " . $e->getMessage() . "\n";
        }
    }

    public static function testDeleteNonExistentCourse()
    {
        try {
            $data = [
                'id' => '99999',
            ];
            $response = self::apiRequest('DELETE', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => false,
                'message' => 'Course not found',
            ], $response);
        } catch (Exception $e) {
            echo "Error deleting non-existent course: " . $e->getMessage() . "\n";
        }
    }

    public static function testUpdateNonExistentCourse()
    {
        try {
            $data = [
                'id' => '99999',
                'title' => 'Updated Title',
            ];
            $response = self::apiRequest('PUT', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => false,
                'message' => 'Course not found',
            ], $response);
        } catch (Exception $e) {
            echo "Error updating non-existent course: " . $e->getMessage() . "\n";
        }
    }

    public static function testGetCourseByInvalidId()
    {
        try {
            $courseId = 'invalid_id';
            $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php?id=' . $courseId);
            self::assertEquals([
                'success' => false,
                'message' => 'Course not found',
            ], $response);
        } catch (Exception $e) {
            echo "Error fetching course by invalid ID: " . $e->getMessage() . "\n";
        }
    }

    public static function testCreateCourseWithInvalidData()
    {
        try {

            $data = [
                'title' => '',
                'description' => 'Some description',
                'thumbnail' => 'uploads/thumbnail.jpg',
                'images' => ['uploads/image1.jpg'],
                'link' => 'https://example.com/course-link',
            ];
            $response = self::apiRequest('POST', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => false,
                'message' => 'Course creation failed',
            ], $response);
        } catch (Exception $e) {
            echo "Error creating course with invalid data: " . $e->getMessage() . "\n";
        }
    }

    public static function testUpdateCourseWithMissingFields()
    {
        try {
            $data = [
                'id' => '1',
            ];
            $response = self::apiRequest('PUT', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => false,
                'message' => 'Course not found',
            ], $response);
        } catch (Exception $e) {
            echo "Error updating course with missing fields: " . $e->getMessage() . "\n";
        }
    }

    public static function testGetAllCoursesWhenEmpty()
    {
        try {
            $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php');
            self::assertEquals([
                'success' => false,
                'message' => 'No Course found',
            ], [
                'success' => $response['success'],
                'message' => $response['message']
            ]);
        } catch (Exception $e) {
            echo "Error fetching all courses when empty: " . $e->getMessage() . "\n";
        }
    }

    public static function testGetCourseByIdNotInteger()
    {
        try {
            $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php?id=abc');
            self::assertEquals([
                'success' => false,
                'message' => 'Course not found',
            ], $response);
        } catch (Exception $e) {
            echo "Error fetching course by non-integer ID: " . $e->getMessage() . "\n";
        }
    }

    public static function testDeleteCourseWithoutId()
    {
        try {
            $data = [];
            $response = self::apiRequest('DELETE', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => false,
                'message' => 'Course ID not provided',
            ], $response);
        } catch (Exception $e) {
            echo "Error deleting course without ID: " . $e->getMessage() . "\n";
        }
    }

    public static function testCreateCourseWithInvalidLink()
    {
        try {
            $data = [
                'title' => 'PHP Advanced',
                'description' => 'Advanced PHP programming concepts.',
                'thumbnail' => 'uploads/php_advanced_thumbnail.jpg',
                'images' => ['uploads/php_advanced_1.jpg'],
                'link' => 'invalid-url',
            ];
            $response = self::apiRequest('POST', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => false,
                'message' => 'Course creation failed',
            ], $response);
        } catch (Exception $e) {
            echo "Error creating course with invalid link: " . $e->getMessage() . "\n";
        }
    }

    public static function testUpdateCourseWithInvalidId()
    {
        try {
            $data = [
                'id' => 'invalid_id',
                'title' => 'Updated Title',
            ];
            $response = self::apiRequest('PUT', 'http://localhost/revvo-test/api/index.php', $data);
            self::assertEquals([
                'success' => false,
                'message' => 'Course not found',
            ], $response);
        } catch (Exception $e) {
            echo "Error updating course with invalid ID: " . $e->getMessage() . "\n";
        }
    }
}

ValidateRequests::testCreateCourse();
ValidateRequests::testGetAllCourses();
ValidateRequests::testGetCourseById();
ValidateRequests::testUpdateCourse();
ValidateRequests::testDeleteCourse();
ValidateRequests::testCreateCourseWithoutTitle();
ValidateRequests::testDeleteNonExistentCourse();
ValidateRequests::testUpdateNonExistentCourse();
ValidateRequests::testGetCourseByInvalidId();
ValidateRequests::testCreateCourseWithInvalidData();
ValidateRequests::testUpdateCourseWithMissingFields();
ValidateRequests::testGetAllCoursesWhenEmpty();
ValidateRequests::testGetCourseByIdNotInteger();
ValidateRequests::testDeleteCourseWithoutId();
ValidateRequests::testCreateCourseWithInvalidLink();
ValidateRequests::testUpdateCourseWithInvalidId();
