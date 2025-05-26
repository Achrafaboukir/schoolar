<?php

class Student {
    private $db;
    private $table = 'students';

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        // First create user
        $userModel = new User($this->db);
        $userData = [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'student',
            'status' => 'ACTIVE'
        ];
        
        $this->db->beginTransaction();
        
        try {
            $userModel->create($userData);
            $userId = $this->db->lastInsertId();
            
            // Then create student
            $query = "INSERT INTO " . $this->table . " 
                    (user_id, group_id, student_number, date_of_birth, baccaloriat_file, picture_file) 
                    VALUES (:user_id, :group_id, :student_number, :date_of_birth, :baccaloriat_file, :picture_file)";
            
            $stmt = $this->db->prepare($query);
            
            $studentData = [
                'user_id' => $userId,
                'group_id' => $data['group_id'],
                'student_number' => $data['student_number'],
                'date_of_birth' => $data['date_of_birth'],
                'baccaloriat_file' => $data['baccaloriat_file'] ?? null,
                'picture_file' => $data['picture_file'] ?? null
            ];
            
            $stmt->execute($studentData);
            $this->db->commit();
            
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getAll($page = 1, $limit = 10, $filters = []) {
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];
        
        if (!empty($filters['group_id'])) {
            $where[] = "s.group_id = :group_id";
            $params[':group_id'] = $filters['group_id'];
        }
        
        if (!empty($filters['search'])) {
            $where[] = "(u.firstname LIKE :search OR u.lastname LIKE :search OR u.email LIKE :search)";
            $params[':search'] = "%{$filters['search']}%";
        }
        
        $whereClause = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";
        
        $query = "SELECT s.*, u.firstname, u.lastname, u.email, u.status, g.name as group_name 
                FROM " . $this->table . " s 
                JOIN users u ON s.user_id = u.id 
                LEFT JOIN groups g ON s.group_id = g.id 
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
        $query = "SELECT s.*, u.firstname, u.lastname, u.email, u.status, g.name as group_name 
                FROM " . $this->table . " s 
                JOIN users u ON s.user_id = u.id 
                LEFT JOIN groups g ON s.group_id = g.id 
                WHERE s.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $student = $this->getById($id);
        if (!$student) {
            return false;
        }

        $this->db->beginTransaction();
        
        try {
            // Update user data
            $userModel = new User($this->db);
            $userData = array_intersect_key($data, array_flip(['firstname', 'lastname', 'email', 'status']));
            if (!empty($userData)) {
                $userModel->update($student['user_id'], $userData);
            }
            
            // Update student data
            $studentFields = [];
            $studentData = array_intersect_key($data, array_flip(['group_id', 'student_number', 'date_of_birth', 'baccaloriat_file', 'picture_file']));
            
            foreach ($studentData as $key => $value) {
                $studentFields[] = "$key = :$key";
            }
            
            if (!empty($studentFields)) {
                $query = "UPDATE " . $this->table . " SET " . implode(', ', $studentFields) . " WHERE id = :id";
                $stmt = $this->db->prepare($query);
                
                $studentData['id'] = $id;
                $stmt->execute($studentData);
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function delete($id) {
        $student = $this->getById($id);
        if (!$student) {
            return false;
        }

        $this->db->beginTransaction();
        
        try {
            // Delete student record
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            
            // Delete user record
            $userModel = new User($this->db);
            $userModel->delete($student['user_id']);
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
} 