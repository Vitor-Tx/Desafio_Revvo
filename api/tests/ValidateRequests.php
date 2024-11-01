<?php

class ValidateRequests
{
    public static function assertEquals($expected, $actual)
    {
        if ($expected !== $actual) {
            echo "\nTest failed: ";
            //Expected '" . htmlspecialchars_decode(json_encode($expected)) . "', got '" . htmlspecialchars_decode(json_encode($actual)) . "'.\n
        } else {
            echo "\nTest passed: ";
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

        $httpCode = null;
        if (isset($http_response_header) && preg_match('/\bHTTP\/\d+\.\d+\s+(\d+)/', $http_response_header[0], $matches)) {
            $httpCode = (int) $matches[1];
        }

        if ($response === false && $httpCode !== null) {
            return [
                'success' => false,
                'message' => "API request failed with status code $httpCode",
                'http_code' => $httpCode
            ];
        }

        if ($response !== false) {
            return json_decode($response, true);
        }

        $error = error_get_last();
        return [
            'success' => false,
            'message' => "API request failed: " . ($error['message'] ?? 'Unknown error')
        ];
    }

    public static function testCreateCourse()
    {

        $data = [
            'title' => 'PHP Basics',
            'description' => 'Learn PHP fundamentals.',
            'thumbnail' => 'uploads/php_basics_thumbnail.jpg',
            'images' => ['uploads/php_intro_1.jpg', 'uploads/php_intro_2.jpg'],
            'link' => 'https://example.com/php-basics',
        ];
        $response = self::apiRequest('POST', 'http://localhost/revvo-test/api/index.php', $data);
        self::assertEquals(['success' => true, 'message' => 'Course created successfully'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Create course";
    }

    public static function testCreateCourseWithoutTitle()
    {

        $data = [
            'description' => 'Learn PHP fundamentals.',
            'thumbnail' => 'uploads/php_basics_thumbnail.jpg',
            'images' => ['uploads/php_intro_1.jpg', 'uploads/php_intro_2.jpg'],
            'link' => 'https://example.com/php-basics',
        ];
        $response = self::apiRequest('POST', 'http://localhost/revvo-test/api/index.php', $data);
        self::assertEquals(['success' => false, 'message' => 'API request failed with status code 400'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Create course without title";
    }

    public static function testGetAllCourses()
    {

        $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php');
        self::assertEquals(['success' => true, 'message' => 'Courses found'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Get all courses";
    }

    public static function testGetCourseById()
    {

        $courseId = 23;
        $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php?id=' . $courseId);
        self::assertEquals(['success' => true, 'message' => 'Course found'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Get course by id";
    }

    public static function testGetCourseByInvalidId()
    {

        $response = self::apiRequest('GET', 'http://localhost/revvo-test/api/index.php?id=invalid_id');
        self::assertEquals(['success' => false, 'message' => 'API request failed with status code 404'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Get course by invalid id";
    }

    public static function testUpdateCourse()
    {

        $data = [
            'id' => '23',
            'title' => 'Updated PHP Basics',
        ];
        $response = self::apiRequest('PUT', 'http://localhost/revvo-test/api/index.php', $data);
        self::assertEquals(['success' => true, 'message' => 'Course updated successfully'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Update course";
    }

    public static function testUpdateNonExistentCourse()
    {

        $data = [
            'id' => '99999',
            'title' => 'Non-existent Course',
        ];
        $response = self::apiRequest('PUT', 'http://localhost/revvo-test/api/index.php', $data);
        self::assertEquals(['success' => false, 'message' => 'API request failed with status code 404'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Update non existent course";
    }

    public static function testDeleteCourse()
    {

        $data = ['id' => '22'];
        $response = self::apiRequest('DELETE', 'http://localhost/revvo-test/api/index.php', $data);
        self::assertEquals(['success' => true, 'message' => 'Course deleted successfully'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Delete course";
    }

    public static function testDeleteNonExistentCourse()
    {
        $data = ['id' => '99999'];
        $response = self::apiRequest('DELETE', 'http://localhost/revvo-test/api/index.php', $data);
        self::assertEquals(['success' => false, 'message' => 'API request failed with status code 404'], [
            'success' => $response['success'] ?? false,
            'message' => $response['message'] ?? 'No message'
        ]);
        echo "Delete nonexistent course";
    }
}

ValidateRequests::testCreateCourse();
ValidateRequests::testCreateCourseWithoutTitle();
ValidateRequests::testGetAllCourses();
ValidateRequests::testGetCourseById();
ValidateRequests::testGetCourseByInvalidId();
ValidateRequests::testUpdateCourse();
ValidateRequests::testUpdateNonExistentCourse();
ValidateRequests::testDeleteCourse();
ValidateRequests::testDeleteNonExistentCourse();
