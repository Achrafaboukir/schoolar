<?php

require_once 'BaseController.php';
require_once 'models/Student.php';

class StudentController extends BaseController {
    private $studentModel;

    public function __construct($db) {
        parent::__construct($db);
        $this->studentModel = new Student($db);
    }

    public function index() {
        $this->requireAuth(['admin', 'teacher']);
        
        $pagination = $this->getPaginationParams();
        $filters = [
            'search' => $this->request['query']['search'] ?? null,
            'group_id' => $this->request['query']['group_id'] ?? null
        ];
        
        try {
            $students = $this->studentModel->getAll($pagination['page'], $pagination['limit'], $filters);
            $this->respondWithJson($students);
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function show($id) {
        $this->requireAuth(['admin', 'teacher']);
        
        try {
            $student = $this->studentModel->getById($id);
            if (!$student) {
                $this->respondWithError('Student not found', 404);
                return;
            }
            
            $this->respondWithJson($student);
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function store() {
        $this->requireAuth(['admin']);
        
        $requiredFields = [
            'firstname', 'lastname', 'email', 'password',
            'student_number', 'group_id'
        ];
        
        $this->validateRequired($this->request['body'], $requiredFields);
        
        try {
            // Handle file uploads if present
            if (isset($_FILES['baccaloriat_file'])) {
                $this->request['body']['baccaloriat_file'] = $this->handleFileUpload(
                    $_FILES['baccaloriat_file'],
                    ['application/pdf'],
                    5 * 1024 * 1024, // 5MB
                    'uploads/baccaloriat/'
                );
            }
            
            if (isset($_FILES['picture_file'])) {
                $this->request['body']['picture_file'] = $this->handleFileUpload(
                    $_FILES['picture_file'],
                    ['image/jpeg', 'image/png'],
                    2 * 1024 * 1024, // 2MB
                    'uploads/pictures/'
                );
            }
            
            $success = $this->studentModel->create($this->request['body']);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Student created successfully'], 201);
            } else {
                $this->respondWithError('Failed to create student');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function update($id) {
        $this->requireAuth(['admin']);
        
        try {
            $student = $this->studentModel->getById($id);
            if (!$student) {
                $this->respondWithError('Student not found', 404);
                return;
            }
            
            // Handle file uploads if present
            if (isset($_FILES['baccaloriat_file'])) {
                $this->request['body']['baccaloriat_file'] = $this->handleFileUpload(
                    $_FILES['baccaloriat_file'],
                    ['application/pdf'],
                    5 * 1024 * 1024,
                    'uploads/baccaloriat/'
                );
                
                // Delete old file if exists
                if ($student['baccaloriat_file']) {
                    @unlink('uploads/baccaloriat/' . $student['baccaloriat_file']);
                }
            }
            
            if (isset($_FILES['picture_file'])) {
                $this->request['body']['picture_file'] = $this->handleFileUpload(
                    $_FILES['picture_file'],
                    ['image/jpeg', 'image/png'],
                    2 * 1024 * 1024,
                    'uploads/pictures/'
                );
                
                // Delete old file if exists
                if ($student['picture_file']) {
                    @unlink('uploads/pictures/' . $student['picture_file']);
                }
            }
            
            $success = $this->studentModel->update($id, $this->request['body']);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Student updated successfully']);
            } else {
                $this->respondWithError('Failed to update student');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function destroy($id) {
        $this->requireAuth(['admin']);
        
        try {
            $student = $this->studentModel->getById($id);
            if (!$student) {
                $this->respondWithError('Student not found', 404);
                return;
            }
            
            // Delete associated files
            if ($student['baccaloriat_file']) {
                @unlink('uploads/baccaloriat/' . $student['baccaloriat_file']);
            }
            if ($student['picture_file']) {
                @unlink('uploads/pictures/' . $student['picture_file']);
            }
            
            $success = $this->studentModel->delete($id);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Student deleted successfully']);
            } else {
                $this->respondWithError('Failed to delete student');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }
} 