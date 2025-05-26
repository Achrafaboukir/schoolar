<?php

class BaseController {
    protected $db;
    protected $request;
    protected $user;

    public function __construct($db) {
        $this->db = $db;
        $this->request = $this->parseRequest();
        $this->user = $this->authenticateUser();
    }

    protected function parseRequest() {
        $request = [
            'method' => $_SERVER['REQUEST_METHOD'],
            'path' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            'query' => $_GET,
            'body' => null
        ];

        if (in_array($request['method'], ['POST', 'PUT', 'PATCH'])) {
            $request['body'] = json_decode(file_get_contents('php://input'), true);
        }

        return $request;
    }

    protected function authenticateUser() {
        $headers = getallheaders();
        $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

        if (!$token) {
            return null;
        }

        try {
            // Verify JWT token and get user data
            $decoded = JWT::decode($token, getenv('JWT_SECRET'), array('HS256'));
            return $decoded;
        } catch (Exception $e) {
            return null;
        }
    }

    protected function requireAuth($roles = []) {
        if (!$this->user) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        if (!empty($roles) && !in_array($this->user->role, $roles)) {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }
    }

    protected function respondWithJson($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function respondWithError($message, $statusCode = 400) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode(['error' => $message]);
    }

    protected function getPaginationParams() {
        $page = isset($this->request['query']['page']) ? (int)$this->request['query']['page'] : 1;
        $limit = isset($this->request['query']['limit']) ? (int)$this->request['query']['limit'] : 10;
        
        return [
            'page' => max(1, $page),
            'limit' => min(100, max(1, $limit))
        ];
    }

    protected function validateRequired($data, $fields) {
        $missing = [];
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $missing[] = $field;
            }
        }
        
        if (!empty($missing)) {
            $this->respondWithError('Missing required fields: ' . implode(', ', $missing), 400);
            exit;
        }
    }

    protected function handleFileUpload($file, $allowedTypes, $maxSize, $uploadDir) {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        if ($file['size'] > $maxSize) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileType = $finfo->file($file['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            throw new RuntimeException('Invalid file format.');
        }

        $fileName = sprintf('%s-%s.%s',
            uniqid(),
            hash('sha256', $file['tmp_name']),
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        return $fileName;
    }
} 