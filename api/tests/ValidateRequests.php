<?php

class ValidateRequests
{
    public static function assertEquals($expected, $actual, $message = "")
    {
        if ($expected === $actual) {
            echo "Test passed: $message\n";
        } else {
            echo "Test failed: $message. Expected '$expected', got '$actual'.\n";
        }
    }

    public static function assertJson($actual, $message = "")
    {
        json_decode($actual);
        self::assertEquals(null, json_last_error(), $message);
    }

    public static function run()
    {
        self::testCreateCourse();
        self::testGetAllCourses();
        self::testGetCourseById();
        self::testUpdateCourse();
        self::testDeleteCourse();
    }

    private static function makeRequest($method, $url, $data = null)
    {
        $options = [
            "http" => [
                "header" => "Content-Type: application/json\r\n",
                "method" => $method,
                "content" => $data
            ]
        ];
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    private static function testCreateCourse()
    {
        $apiUrl = 'http://localhost/revvo-test/api/index.php';
        $mockCourseData = [
            'title' => 'Mock Course',
            'description' => 'This is a mock course description.',
            'thumbnail' => 'uploads/mock_thumbnail.jpg',
            'images' => ['uploads/mock_image_1.jpg', 'uploads/mock_image_2.jpg'],
            'link' => 'https://example.com/mock-course'
        ];
        $response = self::makeRequest('POST', $apiUrl, json_encode($mockCourseData));
        self::assertJson($response, 'Creating a course should return valid JSON');
    }

    private static function testGetAllCourses()
    {
        $apiUrl = 'http://localhost/revvo-test/api/index.php';
        $response = self::makeRequest('GET', $apiUrl);
        self::assertJson($response, 'Fetching all courses should return valid JSON');
    }

    private static function testGetCourseById()
    {
        $apiUrl = 'http://localhost/revvo-test/api/index.php?id=1';
        $response = self::makeRequest('GET', $apiUrl);
        self::assertJson($response, 'Fetching course by ID should return valid JSON');
    }

    private static function testUpdateCourse()
    {
        $apiUrl = 'http://localhost/revvo-test/api/index.php';
        $mockUpdateData = [
            'id' => 1,
            'title' => 'Updated Course',
            'description' => 'This is an updated course description.',
            'thumbnail' => 'uploads/updated_thumbnail.jpg',
            'images' => ['uploads/updated_image_1.jpg', 'uploads/updated_image_2.jpg'],
            'link' => 'https://example.com/updated-course'
        ];
        $response = self::makeRequest('PUT', $apiUrl, json_encode($mockUpdateData));
        self::assertJson($response, 'Updating a course should return valid JSON');
    }

    private static function testDeleteCourse()
    {
        $apiUrl = 'http://localhost/revvo-test/api/index.php';
        $response = self::makeRequest('DELETE', $apiUrl, json_encode(['id' => 1]));
        self::assertJson($response, 'Deleting a course should return valid JSON');
    }
}

ValidateRequests::run();
