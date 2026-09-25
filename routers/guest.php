<?php if (session_status() === PHP_SESSION_NONE) { session_start();}
require_once ROOT_PATH . "/controllers/UserController.php";
$controller = new UserController();
$SearchForMiddleware = new AuthMiddleware();

$action = $_GET['action'] ?? 'login';

switch ($action) {

    case 'login':
        $controller->page_login();
        break;
    case 'otpr':
        $controller->page_otp();
        break;
           case 'resend_otp':
         $controller->page_login();
        break;
    case 'verify_otp':
        $controller->page_otp();
        break;
 

    case 'create_reporter':
        $controller->create_reporter();
        break;

    default:
        $controller->pagenotfound();
        break;
}