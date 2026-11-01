<?php
require_once ROOT_PATH . '/core/database.php';

class Lga {
    private $db;

   public function __construct() {
        $this->db = (new Database())->getConnection();
    }

   public function getAll() {
        $stmt = $this->db->query("SELECT id, name FROM lgas ORDER BY name ASC");
        return $stmt->fetchAll();
    }


    public function getByState($stateId) {
        $stmt = $this->db->prepare(
            "SELECT id, name FROM lgas WHERE state_id = ? ORDER BY name ASC"
        );
        $stmt->execute([$stateId]);
        return $stmt->fetchAll();
    }
}