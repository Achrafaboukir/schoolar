<?php

require_once 'controllers/StudentController.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/FeedbackController.php';

class Router {
    private $db;
    private $routes = [];

    public function __construct($db) {
        $this->db = $db;
        $this->setupRoutes();
    }

    private function setupRoutes() {
        // Student routes
        $this->addRoute('GET', '/api/students', 'StudentController', 'index');
        $this->addRoute('GET', '/api/students/(\d+)', 'StudentController', 'show');
        $this->addRoute('POST', '/api/students', 'StudentController', 'store');
        $this->addRoute('PUT', '/api/students/(\d+)', 'StudentController', 'update');
        $this->addRoute('DELETE', '/api/students/(\d+)', 'StudentController', 'destroy');

        // Course routes
        $this->addRoute('GET', '/api/courses', 'CourseController', 'index');
        $this->addRoute('GET', '/api/courses/(\d+)', 'CourseController', 'show');
        $this->addRoute('POST', '/api/courses', 'CourseController', 'store');
        $this->addRoute('PUT', '/api/courses/(\d+)', 'CourseController', 'update');
        $this->addRoute('DELETE', '/api/courses/(\d+)', 'CourseController', 'destroy');
        $this->addRoute('POST', '/api/courses/(\d+)/enroll', 'CourseController', 'enrollStudent');
        $this->addRoute('POST', '/api/courses/(\d+)/unenroll', 'CourseController', 'unenrollStudent');
        $this->addRoute('GET', '/api/courses/(\d+)/students', 'CourseController', 'getEnrolledStudents');

        // Feedback routes
        $this->addRoute('GET', '/api/feedback', 'FeedbackController', 'index');
        $this->addRoute('GET', '/api/feedback/(\d+)', 'FeedbackController', 'show');
        $this->addRoute('POST', '/api/feedback', 'FeedbackController', 'store');
        $this->addRoute('PUT', '/api/feedback/(\d+)', 'FeedbackController', 'update');
        $this->addRoute('DELETE', '/api/feedback/(\d+)', 'FeedbackController', 'destroy');
        $this->addRoute('GET', '/api/courses/(\d+)/feedback/stats', 'FeedbackController', 'getStats');
    }

    private function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        foreach ($this->routes as $route) {
            $pattern = '#^' . $route['path'] . '$#';
            
            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove the full match
                
                $controller = new $route['controller']($this->db);
                return call_user_func_array([$controller, $route['action']], $matches);
            }
        }
        
        // No matching route found
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
} 