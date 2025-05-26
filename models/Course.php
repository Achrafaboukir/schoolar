<?php

class Course {
    private $db;
    private $table = 'courses';

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                (title, teacher_id) 
                VALUES (:title, :teacher_id)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function getAll($page = 1, $limit = 10, $filters = []) {
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];
        
        if (!empty($filters['teacher_id'])) {
            $where[] = "c.teacher_id = :teacher_id";
            $params[':teacher_id'] = $filters['teacher_id'];
        }
        
        if (!empty($filters['search'])) {
            $where[] = "c.title LIKE :search";
            $params[':search'] = "%{$filters['search']}%";
        }
        
        $whereClause = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";
        
        $query = "SELECT c.*, u.firstname as teacher_firstname, u.lastname as teacher_lastname,
                (SELECT COUNT(*) FROM course_enrollments ce WHERE ce.course_id = c.id) as student_count
                FROM " . $this->table . " c
                JOIN users u ON c.teacher_id = u.id
                {$whereClause}
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
        $query = "SELECT c.*, u.firstname as teacher_firstname, u.lastname as teacher_lastname,
                (SELECT COUNT(*) FROM course_enrollments ce WHERE ce.course_id = c.id) as student_count
                FROM " . $this->table . " c
                JOIN users u ON c.teacher_id = u.id
                WHERE c.id = :id";
        
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
        // First delete all enrollments
        $query = "DELETE FROM course_enrollments WHERE course_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        
        // Then delete the course
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    public function enrollStudent($courseId, $studentId) {
        $query = "INSERT INTO course_enrollments (course_id, student_id) VALUES (:course_id, :student_id)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'course_id' => $courseId,
            'student_id' => $studentId
        ]);
    }

    public function unenrollStudent($courseId, $studentId) {
        $query = "DELETE FROM course_enrollments WHERE course_id = :course_id AND student_id = :student_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'course_id' => $courseId,
            'student_id' => $studentId
        ]);
    }

    public function getEnrolledStudents($courseId, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT s.*, u.firstname, u.lastname, u.email, u.status, g.name as group_name
                FROM course_enrollments ce
                JOIN students s ON ce.student_id = s.id
                JOIN users u ON s.user_id = u.id
                LEFT JOIN groups g ON s.group_id = g.id
                WHERE ce.course_id = :course_id
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 