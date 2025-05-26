<?php

class Feedback {
    private $db;
    private $table = 'feedback';

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                (course_id, student_id, content, is_anonymous) 
                VALUES (:course_id, :student_id, :content, :is_anonymous)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function getAll($page = 1, $limit = 10, $filters = []) {
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];
        
        if (!empty($filters['course_id'])) {
            $where[] = "f.course_id = :course_id";
            $params[':course_id'] = $filters['course_id'];
        }
        
        if (!empty($filters['student_id'])) {
            $where[] = "f.student_id = :student_id";
            $params[':student_id'] = $filters['student_id'];
        }
        
        $whereClause = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";
        
        $query = "SELECT f.*, c.title as course_title, 
                CASE WHEN f.is_anonymous = 0 THEN u.firstname ELSE 'Anonymous' END as student_firstname,
                CASE WHEN f.is_anonymous = 0 THEN u.lastname ELSE '' END as student_lastname
                FROM " . $this->table . " f
                JOIN courses c ON f.course_id = c.id
                JOIN students s ON f.student_id = s.id
                JOIN users u ON s.user_id = u.id
                {$whereClause}
                ORDER BY f.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT f.*, c.title as course_title,
                CASE WHEN f.is_anonymous = 0 THEN u.firstname ELSE 'Anonymous' END as student_firstname,
                CASE WHEN f.is_anonymous = 0 THEN u.lastname ELSE '' END as student_lastname
                FROM " . $this->table . " f
                JOIN courses c ON f.course_id = c.id
                JOIN students s ON f.student_id = s.id
                JOIN users u ON s.user_id = u.id
                WHERE f.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        
        $query = "UPDATE " . $this->table . " SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    public function getFeedbackStats($courseId) {
        $query = "SELECT 
                COUNT(*) as total_feedback,
                SUM(CASE WHEN is_anonymous = 1 THEN 1 ELSE 0 END) as anonymous_count,
                DATE(created_at) as feedback_date,
                COUNT(DISTINCT student_id) as unique_students
                FROM " . $this->table . "
                WHERE course_id = :course_id
                GROUP BY DATE(created_at)
                ORDER BY feedback_date DESC
                LIMIT 30";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 