<?php
require_once CORE_PATH . 'Model.php';

class Prompt extends Model {

    public function getAll($filters = [], $search = null, $limit = 12, $offset = 0) {
        $sql = "SELECT p.*, c.name as category_name, c.color as category_color 
                FROM prompts p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE 1=1";
        $params = [];

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }
        if (!empty($filters['type'])) {
            $sql .= " AND p.type = :type";
            $params['type'] = $filters['type'];
        }


        if ($search) {
            $sql .= " AND (p.title LIKE :search OR p.content LIKE :search)";
            $params['search'] = "%$search%";
        }

        $sql .= " ORDER BY p.is_favorite DESC, p.created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        
        // Bind limit and offset as integers
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        
        // Bind other parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($filters = [], $search = null) {
        $sql = "SELECT COUNT(*) FROM prompts p WHERE 1=1";
        $params = [];

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }
        if (!empty($filters['type'])) {
            $sql .= " AND p.type = :type";
            $params['type'] = $filters['type'];
        }


        if ($search) {
            $sql .= " AND (p.title LIKE :search OR p.content LIKE :search)";
            $params['search'] = "%$search%";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function find($id) {
        $sql = "SELECT p.*, c.name as category_name, c.color as category_color 
                FROM prompts p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO prompts (user_id, category_id, title, content, platform, type, status, image_path) 
                VALUES (:user_id, :category_id, :title, :content, :platform, :type, :status, :image_path)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'content' => $data['content'],
            'platform' => $data['platform'],
            'type' => $data['type'],
            'status' => $data['status'],
            'image_path' => $data['image_path'] ?? null
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE prompts SET 
                category_id = :category_id, 
                title = :title, 
                content = :content, 
                platform = :platform, 
                type = :type, 
                status = :status";
                
        $params = [
            'id' => $id,
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'content' => $data['content'],
            'platform' => $data['platform'],
            'type' => $data['type'],
            'status' => $data['status']
        ];

        if (isset($data['image_path'])) {
            $sql .= ", image_path = :image_path";
            $params['image_path'] = $data['image_path'];
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM prompts WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function toggleFavorite($id) {
        $stmt = $this->db->prepare("UPDATE prompts SET is_favorite = NOT is_favorite WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }


}
