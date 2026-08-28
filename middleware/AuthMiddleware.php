
<?php 
require_once  ROOT_PATH .'/models/User.php';
class AuthMiddleware {
       private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
       
    }

  public function IsLoginSessionActive(): void {
    if (!isset($_SESSION['userid']) || !isset($_SESSION['role'])) {
         if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header("Location: index");
        exit;
    }
    }
public function GetAllUserRoleCapacity(): array {
    if (!isset($_SESSION['userid']) || !isset($_SESSION['role'])) {
        header("Location: index?action=dashboard");
        exit;
    }

    $stmt = $this->conn->prepare(
        "SELECT * FROM login WHERE userid = :userid LIMIT 1"
    );

    $stmt->bindValue(':userid', $_SESSION['userid'], PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return [
            'success' => false,
            'error'   => 'Unable to retrieve the user role. Please try again.'
        ];
    }

    return [
        'success' => true,
        'user'    => $user
    ];
}



public function writelog($userid, $role){

    $logDir  = __DIR__ . '/../Log/';
    $logFile = $logDir . 'log.log';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    date_default_timezone_set('Africa/Lagos');
    $date = date('l, d F Y, h:i A');

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    // Return everything controller needs
    return [
        'logFile' => $logFile,
        'date'    => $date,
        'ip'      => $ip
    ];
}


    
    public function WhatDeviceIsThis(): string {

        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');

        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobile))/', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/mobile|iphone|ipod|android|blackberry|iemobile|kindle|opera mini/', $userAgent)) {
            return 'mobile';
        }

        return 'pc';
    }
}


?>