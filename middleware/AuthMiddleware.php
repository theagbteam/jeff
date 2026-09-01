
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


public function writelog($userid, $role_name, $role, $user_details, $action, $company_logfile_url)
{
    // $logDir  = __DIR__ . '/../Log/';
    $logDir  = $company_logfile_url;
    $logFile = $logDir . 'log.log';

    // Create log directory if it doesn't exist
    if (!is_dir($logDir)) {
        if (!mkdir($logDir, 0755, true) && !is_dir($logDir)) {
            return [
                'success' => false,
                'message' => 'Unable to create log directory.'
            ];
        }
    }

    // Use Lagos timezone for this log entry
    $dateTime = new DateTime('now', new DateTimeZone('Africa/Lagos'));

    $date   = $dateTime->format('l, d F Y, h:i A');
    $dbDate = $dateTime->format('Y-m-d H:i:s');

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    $userid       = $userid ?: 'UNKNOWN';
    $role_name    = $role_name ?: 'UNKNOWN';
    $role         = $role ?: 'UNKNOWN';
    $user_details = $user_details ?: 'UNKNOWN';
    $action       = $action ?: 'UNKNOWN';

    // Audit trail status
    $status = 1;

    // =========================
    // DATABASE AUDIT TRAIL
    // =========================

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

    // =========================
    // FILE LOG
    // =========================

    $message = "Action: {$action} | User: {$user_details} | Role: {$role_name}";
    $line    = "[{$date}] {$message} | IP: {$ip}" . PHP_EOL;

    // Write log
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








public function audit_trail(AuditTrailDTO $data){
    $logDir  = $data->company_logfile_url;
    $logFile = $logDir . 'log.log';
    // Create log directory if it doesn't exist
    if (!is_dir($logDir)) {
        if (!mkdir($logDir, 0755, true) && !is_dir($logDir)) {
            return [
                'success' => false,
                'message' => 'Unable to create log directory.'
            ];
        }
    }

    // Lagos timezone
    $now = new DateTime(
        'now',
        new DateTimeZone('Africa/Lagos')
    );

    $dbDate  = $now->format('Y-m-d H:i:s');
    $logDate = $now->format('l, d F Y, h:i A');

    // Get IP address
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    // =========================
    // DATABASE AUDIT TRAIL
    // =========================

    try {

        $sql = "INSERT INTO audit_trail
                (`date`, userid, full_name, role, role_name, `Action`, ip, status)
                VALUES
                (:date, :userid, :full_name, :role, :role_name, :action, :ip, :status)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':date'      => $dbDate,
            ':userid'    => $data->userid,
            ':full_name' => $data->full_name,
            ':role'      => $data->role,
            ':role_name' => $data->role_name,
            ':action'    => $data->action,
            ':ip'        => $ip,
            ':status'    => $data->status
        ]);

    } catch (PDOException $e) {

        return [
            'success' => false,
            'message' => 'Failed to save audit trail.'
        ];
    }

    // =========================
    // FILE LOG
    // =========================

    $message = "Action: {$data->action} | User: {$data->full_name} | Role: {$data->role_name}";

    $line = "[{$logDate}] {$message} | IP: {$ip}" . PHP_EOL;

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
        'message' => 'Audit trail logged successfully.'
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