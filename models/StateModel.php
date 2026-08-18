<?php
// require_once ROOT_PATH . '/app/core/database.php';
class StateModel {
     public $conn;

     public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
       
    }


//  public function __construct($conn) {
//         $this->conn = $conn;
//     }


        public function GetAstateLGAs($state_id) {
         $stmt =  $this->conn->prepare("SELECT id, name FROM lgas WHERE state_id = ? ORDER BY name");
        $stmt->execute([$state_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }





    
   
    //  public function getAllStates() {
    //      $stmt =  $this->conn->query("SELECT id, name FROM states ORDER BY name");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    public function GetAllStates() {
    $stmt = $this->conn->query("SELECT id, name FROM state_cmd WHERE id BETWEEN 1 AND 37 ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function GetAllNisFormations() {
    $stmt = $this->conn->query("SELECT id, name FROM state_cmd ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function GetaParticularFormation($formation_id) {
    $stmt = $this->conn->prepare("SELECT id, name FROM state_cmd WHERE id = ? ORDER BY name");
    // $stmt->execute([$formation_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    
    public function getLGAs($state_id) {
         $stmt =  $this->conn->prepare("SELECT id, name FROM lgas WHERE state_id = ? ORDER BY name");
        $stmt->execute([$state_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 





    