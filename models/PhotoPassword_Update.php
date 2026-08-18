<?php
class PhotoPassword_Update {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updatePhoto($serviceNo, $filename) {
        $stmt = $this->conn->prepare("UPDATE personnel SET img=? WHERE service_no=?");
        return $stmt->execute([$filename, $serviceNo]);
    }

    public function updatePassword($serviceNo, $hashedPassword) {
        $stmt = $this->conn->prepare("UPDATE login SET password=? WHERE service_no=?");
        return $stmt->execute([$hashedPassword, $serviceNo]);
    }
}