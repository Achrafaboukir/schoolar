<?php

require_once 'controllers/StudentController.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/FeedbackController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/PageController.php';

class Router {
    private $db;
    private $routes = [];

    public function __construct($db) {
        $this->db = $db;
        $this->setupRoutes();
    }

    private function setupRoutes() {
        // Auth routes
        $this->addRoute('GET', '/login', 'AuthController', 'showLogin');
        $this->addRoute('POST', '/login', 'AuthController', 'login');
        $this->addRoute('GET', '/register', 'AuthController', 'showRegister');
        $this->addRoute('POST', '/register', 'AuthController', 'register');
        $this->addRoute('POST', '/logout', 'AuthController', 'logout');

        // Home route
        $this->addRoute('GET', '/', 'AuthController', 'showWelcome');

        // Dashboard route
        $this->addRoute('GET', '/dashboard', 'DashboardController', 'index');

        // Static pages
        $this->addRoute('GET', '/about-us', 'PageController', 'about');
        $this->addRoute('GET', '/contact-us', 'PageController', 'contact');
        $this->addRoute('GET', '/privacy-policy', 'PageController', 'privacy');

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
        
        // Get the request URI and remove the base path
        $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base_path = BASE_PATH;
        
        // Remove the base path from the request URI
        if (strpos($request_uri, $base_path) === 0) {
            $request_uri = substr($request_uri, strlen($base_path));
        }
        
        // Ensure the path starts with a forward slash
        $path = '/' . ltrim($request_uri, '/');
        
        // Debug information
        error_log("Method: " . $method);
        error_log("Path: " . $path);
        error_log("Base Path: " . $base_path);
        
        foreach ($this->routes as $route) {
            $pattern = '#^' . preg_quote($route['path'], '#') . '$#';
            
            error_log("Checking route: " . $route['path'] . " with pattern: " . $pattern);
            
            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                error_log("Route matched: " . $route['controller'] . "@" . $route['action']);
                
                // Remove the full match from matches array
                array_shift($matches);
                
                $controller = new $route['controller']($this->db);
                return call_user_func_array([$controller, $route['action']], $matches);
            }
        }
        
        // No matching route found
        header("HTTP/1.0 404 Not Found");
        if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Not Found']);
        } else {
            echo "<h1>404 Not Found</h1>";
            echo "<p>The requested URL " . htmlspecialchars($path) . " was not found on this server.</p>";
        }
        exit;
    }
}

// Home route
Route::get('/', function() {
    return view('welcome');
}); 