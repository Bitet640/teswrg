<?php
require_once CORE_PATH . 'Model.php';

class Platform extends Model {
    protected $table = 'platforms';

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM platforms ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM platforms WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO platforms (name) VALUES (:name)");
        return $stmt->execute([
            'name' => $data['name']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE platforms SET name = :name WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM platforms WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
