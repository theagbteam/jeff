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






public function getRoleCounts()
{
    $sql = "SELECT
                SUM(role = 'developer') AS developers,
                SUM(role = 'reporter') AS reporters,
                SUM(role = 'supervisor') AS supervisors,
                SUM(role = 'administrator') AS administrators
            FROM login";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function GetRequestSum(){
   
    $sql = "SELECT COUNT(*) AS total FROM request";
     $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}




public function TicketCount()
{
    $sql = "SELECT
                COUNT(*) AS total,
                SUM(status = 0) AS status_0,
                SUM(status = 1) AS status_1,
                SUM(status = 2) AS status_2
            FROM tickets";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}













}