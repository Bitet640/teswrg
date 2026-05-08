<?php
require_once CORE_PATH . 'Model.php';

class Category extends Model {
    protected $table = 'categories';

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO categories (name, color) VALUES (:name, :color)");
        return $stmt->execute([
            'name' => $data['name'],
            'color' => $data['color']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE categories SET name = :name, color = :color WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'color' => $data['color']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
