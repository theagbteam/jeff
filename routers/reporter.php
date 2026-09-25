 <?php
require_once ROOT_PATH ."/controllers/UserController.php";
require_once ROOT_PATH ."/controllers/ReporterController.php";
require_once   ROOT_PATH ."/middleware/AuthMiddleware.php";

// $Controller = new UserController();
$Reportercontroller = new ReporterController();
 $SearchForMiddleware = new AuthMiddleware();
$userid = $_SESSION['userid'] ?? null;
 $action = $_GET['action'] ?? 'login';


switch ($action) {
      case 'login':
       $UserController->page_login();
        break;
case 'dashboard':
        $Reportercontroller->page_dashboard(); 
        break;
  case 'create_reporter':
          $Usercontroller->create_reporter();
        break;
  
    case 'logout':
        $UserController->logout();
        break;
    
    default:
         $UserController->pagenotfound();
}
