<?php

require_once 'BaseController.php';
require_once 'models/Course.php';

class CourseController extends BaseController {
    private $courseModel;

    public function __construct($db) {
        parent::__construct($db);
        $this->courseModel = new Course($db);
    }

    public function index() {
        $this->requireAuth(['admin', 'teacher', 'student']);
        
        $pagination = $this->getPaginationParams();
        $filters = [
            'search' => $this->request['query']['search'] ?? null
        ];
        
        // If teacher, only show their courses
        if ($this->user->role === 'teacher') {
            $filters['teacher_id'] = $this->user->id;
        }
        
        try {
            $courses = $this->courseModel->getAll($pagination['page'], $pagination['limit'], $filters);
            $this->respondWithJson($courses);
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function show($id) {
        $this->requireAuth(['admin', 'teacher', 'student']);
        
        try {
            $course = $this->courseModel->getById($id);
            if (!$course) {
                $this->respondWithError('Course not found', 404);
                return;
            }
            
            // Check if teacher has access to this course
            if ($this->user->role === 'teacher' && $course['teacher_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $this->respondWithJson($course);
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function store() {
        $this->requireAuth(['admin', 'teacher']);
        
        $requiredFields = ['title'];
        $this->validateRequired($this->request['body'], $requiredFields);
        
        try {
            $data = $this->request['body'];
            $data['teacher_id'] = $this->user->role === 'teacher' ? $this->user->id : $data['teacher_id'];
            
            $success = $this->courseModel->create($data);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Course created successfully'], 201);
            } else {
                $this->respondWithError('Failed to create course');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function update($id) {
        $this->requireAuth(['admin', 'teacher']);
        
        try {
            $course = $this->courseModel->getById($id);
            if (!$course) {
                $this->respondWithError('Course not found', 404);
                return;
            }
            
            // Check if teacher has access to update this course
            if ($this->user->role === 'teacher' && $course['teacher_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $success = $this->courseModel->update($id, $this->request['body']);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Course updated successfully']);
            } else {
                $this->respondWithError('Failed to update course');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function destroy($id) {
        $this->requireAuth(['admin', 'teacher']);
        
        try {
            $course = $this->courseModel->getById($id);
            if (!$course) {
                $this->respondWithError('Course not found', 404);
                return;
            }
            
            // Check if teacher has access to delete this course
            if ($this->user->role === 'teacher' && $course['teacher_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $success = $this->courseModel->delete($id);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Course deleted successfully']);
            } else {
                $this->respondWithError('Failed to delete course');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function enrollStudent($courseId) {
        $this->requireAuth(['admin', 'teacher']);
        
        $requiredFields = ['student_id'];
        $this->validateRequired($this->request['body'], $requiredFields);
        
        try {
            $course = $this->courseModel->getById($courseId);
            if (!$course) {
                $this->respondWithError('Course not found', 404);
                return;
            }
            
            // Check if teacher has access to this course
            if ($this->user->role === 'teacher' && $course['teacher_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $success = $this->courseModel->enrollStudent($courseId, $this->request['body']['student_id']);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Student enrolled successfully']);
            } else {
                $this->respondWithError('Failed to enroll student');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function unenrollStudent($courseId) {
        $this->requireAuth(['admin', 'teacher']);
        
        $requiredFields = ['student_id'];
        $this->validateRequired($this->request['body'], $requiredFields);
        
        try {
            $course = $this->courseModel->getById($courseId);
            if (!$course) {
                $this->respondWithError('Course not found', 404);
                return;
            }
            
            // Check if teacher has access to this course
            if ($this->user->role === 'teacher' && $course['teacher_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $success = $this->courseModel->unenrollStudent($courseId, $this->request['body']['student_id']);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Student unenrolled successfully']);
            } else {
                $this->respondWithError('Failed to unenroll student');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function getEnrolledStudents($courseId) {
        $this->requireAuth(['admin', 'teacher']);
        
        try {
            $course = $this->courseModel->getById($courseId);
            if (!$course) {
                $this->respondWithError('Course not found', 404);
                return;
            }
            
            // Check if teacher has access to this course
            if ($this->user->role === 'teacher' && $course['teacher_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $pagination = $this->getPaginationParams();
            $students = $this->courseModel->getEnrolledStudents($courseId, $pagination['page'], $pagination['limit']);
            
            $this->respondWithJson($students);
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }
} 