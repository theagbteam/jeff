
<?php 
require_once  ROOT_PATH .'/models/User.php';
class AuthMiddleware {
       private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
       
    }





public function IsLoginSessionActive(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['userid']) && isset($_SESSION['role'])) {
        header("Location: index.php?action=dashboard");
        exit;
    } else {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header("Location: index.php");
        exit;
    }
} 






    
    public function SelectloginTableForOne($userid){
    $stmt = $this->conn->prepare(
        "SELECT * FROM login WHERE userid = :userid LIMIT 1"
    );

    $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return [
            'success' => false,
            'error'   => 'User ID does not exist'
        ];
    }

    return [
        'success' => true,
        'user'    => $user
    ];
}



public function writelog(
    $userid,
    $role_name,
    $role,
    $user_details,
    $action,
    $company_logfile_url
) {
    // =====================================================
    // LOG FILE PATH
    // company_logfile_url already contains the full path
    // Example:
    // C:\xampp\htdocs\jeff/log/log.log
    // =====================================================

    $logFile = $company_logfile_url;

    // Make sure a log file path was supplied
    if (empty($logFile)) {
        return [
            'success' => false,
            'message' => 'Log file path is empty.'
        ];
    }

    // Get the directory from the complete log file path
    $logDir = dirname($logFile);

    // Create log directory if it does not exist
    if (!is_dir($logDir)) {

        if (!mkdir($logDir, 0755, true) && !is_dir($logDir)) {

            return [
                'success' => false,
                'message' => 'Unable to create log directory.'
            ];
        }
    }

    // =====================================================
    // TIMEZONE
    // =====================================================

    $dateTime = new DateTime(
        'now',
        new DateTimeZone('Africa/Lagos')
    );

    $date   = $dateTime->format('l, d F Y, h:i A');
    $dbDate = $dateTime->format('Y-m-d H:i:s');

    // =====================================================
    // IP ADDRESS
    // =====================================================

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    // =====================================================
    // DEFAULT VALUES
    // =====================================================

    $userid       = $userid ?: 'UNKNOWN';
    $role_name    = $role_name ?: 'UNKNOWN';
    $role         = $role ?: 'UNKNOWN';
    $user_details = $user_details ?: 'UNKNOWN';
    $action       = $action ?: 'UNKNOWN';

    // Audit trail status
    $status = 1;

    // =====================================================
    // DATABASE AUDIT TRAIL
    // =====================================================

    try {

        $sql = "INSERT INTO audit_trail
                (`date`, userid, full_name, role, role_name, `Action`, ip, status)
                VALUES
                (:date, :userid, :full_name, :role, :role_name, :action, :ip, :status)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':date'      => $dbDate,
            ':userid'    => $userid,
            ':full_name' => $user_details,
            ':role'      => $role,
            ':role_name' => $role_name,
            ':action'    => $action,
            ':ip'        => $ip,
            ':status'    => $status
        ]);

    } catch (PDOException $e) {

        return [
            'success' => false,
            'message' => 'Log file was not affected, but failed to save audit trail.'
        ];
    }

    // =====================================================
    // FILE LOG
    // =====================================================

    $message = "Action: {$action} | User: {$user_details} | Role: {$role_name}";

    $line = "[{$date}] {$message} | IP: {$ip}" . PHP_EOL;

    // =====================================================
    // WRITE TO LOG FILE
    // =====================================================

    $result = file_put_contents(
        $logFile,
        $line,
        FILE_APPEND | LOCK_EX
    );

    if ($result === false) {

        return [
            'success' => false,
            'message' => 'Database audit saved, but failed to write log file.'
        ];
    }

    return [
        'success' => true,
        'message' => 'Log written successfully.'
    ];
}








    public function WhatDeviceIsThis(): string {

    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ua = strtolower($userAgent);

    // Device type
    if (preg_match('/tablet|ipad|playbook|silk|(android(?!.*mobile))/', $ua)) {
        $device = 'Tablet';
    } elseif (preg_match('/mobile|iphone|ipod|android|blackberry|iemobile|kindle|opera mini/', $ua)) {
        $device = 'Mobile';
    } else {
        $device = 'PC';
    }

    // Operating system
    if (preg_match('/windows nt 10/', $ua)) {
        $os = 'Windows 10/11';
    } elseif (preg_match('/windows nt 6.3/', $ua)) {
        $os = 'Windows 8.1';
    } elseif (preg_match('/windows nt 6.2/', $ua)) {
        $os = 'Windows 8';
    } elseif (preg_match('/windows nt 6.1/', $ua)) {
        $os = 'Windows 7';
    } elseif (preg_match('/iphone|ipad|ipod/', $ua)) {
        $os = 'iOS';
    } elseif (preg_match('/android/', $ua)) {
        $os = 'Android';
    } elseif (preg_match('/mac os x/', $ua)) {
        $os = 'macOS';
    } elseif (preg_match('/linux/', $ua)) {
        $os = 'Linux';
    } else {
        $os = 'Unknown OS';
    }

    // Browser
    if (preg_match('/edg\//', $ua)) {
        $browser = 'Microsoft Edge';
    } elseif (preg_match('/opr\//', $ua)) {
        $browser = 'Opera';
    } elseif (preg_match('/chrome\//', $ua)) {
        $browser = 'Google Chrome';
    } elseif (preg_match('/firefox\//', $ua)) {
        $browser = 'Mozilla Firefox';
    } elseif (preg_match('/safari\//', $ua) && !preg_match('/chrome\//', $ua)) {
        $browser = 'Safari';
    } else {
        $browser = 'Unknown Browser';
    }

    return "$device | $os | $browser";
}

}


?>