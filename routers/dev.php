 <?php
 
 require_once ROOT_PATH . "/controllers/UserController.php";
// require_once   ROOT_PATH ."/middleware/AuthMiddleware.php";
$Usercontroller = new UserController();
$Devcontroller = new DevController();
 $SearchForMiddleware = new AuthMiddleware();
// $userid = $_SESSION['userid'] ?? null;
 $action = $_GET['action'] ?? 'login';


switch ($action) {
        case 'dashboard':
        $Devcontroller->dashboard();
        break;
        case 'totalrequest':
    //  $SearchForMiddleware->IsLoginSessionActive() ;
        $Devcontroller->totalrequest();
        break;
    case 'logout':
        $Usercontroller->logout();
        break;
    
    default:
        $Usercontroller->login();
}
