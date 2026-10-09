<?php
require_once ROOT_PATH . '/core/database.php';

class Lga {
    private $db;

   public function __construct() {
        $this->db = (new Database())->getConnection();
    }


    public function getByState($stateId) {
        $stmt = $this->db->prepare(
            "SELECT id, name FROM lgas WHERE state_id = ? ORDER BY name ASC"
        );
        $stmt->execute([$stateId]);
        return $stmt->fetchAll();
    }
}