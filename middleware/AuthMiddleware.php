
<?php 
require_once  ROOT_PATH .'/models/User.php';
class AuthMiddleware {
       private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
       
    }
    
    

public function RequestOTP(string $email, string $ref_id): array{
    try {

        $email = trim($email);
        $ref_id = trim($ref_id);

        // Ref ID is always required
        if (empty($ref_id)) {
            return [
                'status' => false,
                'message' => 'Ref ID is required.'
            ];
        }

        /*
         * If both Email and Ref ID are provided,
         * make sure they belong to the same user.
         *
         * If only Ref ID is provided,
         * search by Ref ID only.
         */
        if (!empty($email)) {

            $sql = "SELECT userid, email, fullname
                    FROM users 
                    WHERE email = :email 
                    AND userid = :userid 
                    LIMIT 1";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':email' => $email,
                ':userid' => $ref_id
            ]);

        } else {

            $sql = "SELECT userid, email, fullname
                    FROM users 
                    WHERE userid = :userid 
                    LIMIT 1";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':userid' => $ref_id
            ]);
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'status' => false,
                'message' => !empty($email)
                    ? 'Invalid email or Ref ID.'
                    : 'Invalid Ref ID.'
            ];
        }

        // Generate a secure six-digit OTP
        $otp = (string) random_int(100000, 999999);

        // Save the OTP in the user's record
        $updateSql = "UPDATE users 
                      SET otp_request = :otp 
                      WHERE userid = :userid";

        $updateStmt = $this->conn->prepare($updateSql);

        $updateStmt->execute([
            ':otp' => $otp,
            ':userid' => $user['userid']
        ]);

        return [
            'status' => true,
            'message' => 'OTP generated successfully.',
            'otp' => $otp,
            'email' => $user['email'],
            'user_name' => $user['fullname'],
            'userid' => $user['userid']
        ];

    } catch (PDOException $e) {

        error_log("OTP Request Error: " . $e->getMessage());

        return [
            'status' => false,
            'message' => 'An error occurred while generating the OTP.'
        ];
    }
}




public function ValidateAndConsumeActionToken()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (
        !isset($_POST['action_token']) ||
        !isset($_SESSION['action_token'])
    ) {
        return false;
    }

    if (!hash_equals($_SESSION['action_token'], $_POST['action_token'])) {
        return false;
    }

    // Consume the token immediately.
    unset($_SESSION['action_token']);

    // Generate a new token for the next form submission.
    $_SESSION['action_token'] = bin2hex(random_bytes(32));

    return true;
}










    public function checkConnection(): bool    {
        $ch = curl_init('https://www.google.com/');

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_CONNECTTIMEOUT => 3,
        ]);

        curl_exec($ch);

        $connected = !curl_errno($ch);

        curl_close($ch);

        return $connected;
    }


    
 public function ValidateTurnstile($CF_SecretKey, $CF_VerificationSiteUrl)
{
    $turnstile_token = $_POST['cf-turnstile-response'] ?? '';

    if (empty($turnstile_token)) {

        $_SESSION['error'] = 'Please complete the human verification.';

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    try {

        $ch = curl_init($CF_VerificationSiteUrl);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'secret'   => $CF_SecretKey,
                'response' => $turnstile_token
            ],
            CURLOPT_TIMEOUT => 10
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            curl_close($ch);

            $_SESSION['error'] = 'Human verification failed. Please try again.';

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        curl_close($ch);

        $result = json_decode($response, true);

        if (empty($result['success'])) {

            $_SESSION['error'] = 'Human verification failed. Please try again.';

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        return true;

    } catch (Exception $e) {

        $_SESSION['error'] = 'Human verification failed. Please try again.';

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
public function IsLoginSessionActive(){

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['userid']) && isset($_SESSION['role'])) {

        header("Location: index.php?action=dashboard");
        exit;

    }

    return false;
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