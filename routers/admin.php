 <?php
require_once ROOT_PATH ."/controllers/AdminController.php";
require_once ROOT_PATH ."/controllers/UserController.php";
require_once   ROOT_PATH ."/middleware/AuthMiddleware.php";
$Admincontroller = new Admincontroller();
$Usercontroller = new UserController();
$userid = $_SESSION['userid'] ?? null;
 $action = $_GET['action'] ?? 'login';


switch ($action) {
     case 'updateuserpwd':
        $Usercontroller->updatepassword();
        break;
        case 'get_lgas':
        $Admincontroller->getLgas();
        break;
         case 'dashboard':
        case 'cr_ticket':
        case 'tickets':
        case 'run_reports':
        case 'audit_trail':
        case 'user_library':
        case 'transfers':
        case 'user_requests':
        case 'manage_users':
        case 'export_tickets':
       $Admincontroller->page_dashboard();
        break;    
       case 'compulsory_cp':
        $Usercontroller->updatepassword();
        break;
      case 'login':
         $Usercontroller->page_login();
        break;
           
    case 'logout':
        $Usercontroller->logout();
        break;
    
    default:
         $Usercontroller->pagenotfound();
}
