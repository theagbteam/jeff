<?php

// define('ROOT_PATH', dirname(__DIR__));


require_once ROOT_PATH . '/core/database.php';

class ModelDev {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
       
    }




// All site settings data
public function web_settings() {
$table_site_settings = "company";
    $stmt = $this->conn->prepare(
        "SELECT * FROM {$table_site_settings}"
    );
    $stmt->execute();

    // return $stmt->fetch(PDO::FETCH_ASSOC);
    $web_settings = $stmt->fetch(PDO::FETCH_ASSOC);
    return $web_settings;
}



    public function login($userid, $password, $role) {
      

}
}