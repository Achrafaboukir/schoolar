<?php

require_once 'BaseController.php';
require_once 'models/Feedback.php';
require_once 'models/Course.php';

class FeedbackController extends BaseController {
    private $feedbackModel;
    private $courseModel;

    public function __construct($db) {
        parent::__construct($db);
        $this->feedbackModel = new Feedback($db);
        $this->courseModel = new Course($db);
    }

    public function index() {
        $this->requireAuth(['admin', 'teacher', 'student']);
        
        $pagination = $this->getPaginationParams();
        $filters = [
            'course_id' => $this->request['query']['course_id'] ?? null
        ];
        
        // If student, only show their feedback
        if ($this->user->role === 'student') {
            $filters['student_id'] = $this->user->id;
        }
        // If teacher, only show feedback for their courses
        elseif ($this->user->role === 'teacher') {
            $teacherCourses = $this->courseModel->getAll(1, 1000, ['teacher_id' => $this->user->id]);
            $courseIds = array_column($teacherCourses, 'id');
            if (empty($courseIds)) {
                $this->respondWithJson([]);
                return;
            }
            $filters['course_ids'] = $courseIds;
        }
        
        try {
            $feedback = $this->feedbackModel->getAll($pagination['page'], $pagination['limit'], $filters);
            $this->respondWithJson($feedback);
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function show($id) {
        $this->requireAuth(['admin', 'teacher', 'student']);
        
        try {
            $feedback = $this->feedbackModel->getById($id);
            if (!$feedback) {
                $this->respondWithError('Feedback not found', 404);
                return;
            }
            
            // Check access permissions
            if ($this->user->role === 'student' && $feedback['student_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            elseif ($this->user->role === 'teacher') {
                $course = $this->courseModel->getById($feedback['course_id']);
                if ($course['teacher_id'] !== $this->user->id) {
                    $this->respondWithError('Access denied', 403);
                    return;
                }
            }
            
            $this->respondWithJson($feedback);
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function store() {
        $this->requireAuth(['student']);
        
        $requiredFields = ['course_id', 'content'];
        $this->validateRequired($this->request['body'], $requiredFields);
        
        try {
            // Verify course exists
            $course = $this->courseModel->getById($this->request['body']['course_id']);
            if (!$course) {
                $this->respondWithError('Course not found', 404);
                return;
            }
            
            $data = $this->request['body'];
            $data['student_id'] = $this->user->id;
            $data['is_anonymous'] = $data['is_anonymous'] ?? false;
            
            $success = $this->feedbackModel->create($data);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Feedback submitted successfully'], 201);
            } else {
                $this->respondWithError('Failed to submit feedback');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function update($id) {
        $this->requireAuth(['student']);
        
        try {
            $feedback = $this->feedbackModel->getById($id);
            if (!$feedback) {
                $this->respondWithError('Feedback not found', 404);
                return;
            }
            
            // Only allow students to update their own feedback
            if ($feedback['student_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $success = $this->feedbackModel->update($id, $this->request['body']);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Feedback updated successfully']);
            } else {
                $this->respondWithError('Failed to update feedback');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function destroy($id) {
        $this->requireAuth(['admin', 'student']);
        
        try {
            $feedback = $this->feedbackModel->getById($id);
            if (!$feedback) {
                $this->respondWithError('Feedback not found', 404);
                return;
            }
            
            // Only allow students to delete their own feedback or admins to delete any feedback
            if ($this->user->role === 'student' && $feedback['student_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $success = $this->feedbackModel->delete($id);
            
            if ($success) {
                $this->respondWithJson(['message' => 'Feedback deleted successfully']);
            } else {
                $this->respondWithError('Failed to delete feedback');
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function getStats($courseId) {
        $this->requireAuth(['admin', 'teacher']);
        
        try {
            // Verify course exists and teacher has access
            $course = $this->courseModel->getById($courseId);
            if (!$course) {
                $this->respondWithError('Course not found', 404);
                return;
            }
            
            if ($this->user->role === 'teacher' && $course['teacher_id'] !== $this->user->id) {
                $this->respondWithError('Access denied', 403);
                return;
            }
            
            $stats = $this->feedbackModel->getFeedbackStats($courseId);
            $this->respondWithJson($stats);
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }
} 