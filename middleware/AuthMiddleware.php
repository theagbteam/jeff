
<?php 
require_once  ROOT_PATH .'/models/User.php';
class AuthMiddleware {

  public function IsLoginSessionActive(): void {
    if (!isset($_SESSION['userid']) || !isset($_SESSION['role']) || !isset($_SESSION['level'])) {
        header("Location: index");
        exit;
    }

    header("Location: index?action=dashboard");
    exit;
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