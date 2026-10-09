<?php
require_once ROOT_PATH . '/core/database.php';

class State {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT id, name, capital FROM states ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM states WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}