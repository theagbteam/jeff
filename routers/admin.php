 <?php
require_once ROOT_PATH ."/controllers/AdminController.php";
require_once ROOT_PATH ."/controllers/UserController.php";
require_once   ROOT_PATH ."/middleware/AuthMiddleware.php";
$Admincontroller = new Admincontroller();
$Usercontroller = new UserController();
$userid = $_SESSION['userid'] ?? null;
 $action = $_GET['action'] ?? 'login';


switch ($action) {
             
        case 'get_lgas':
        $Admincontroller->getLgas();
        break;
        case 'delete_user':
        $Admincontroller->delete_user();
        break;
         case 'dashboard':
         case 'assignowner':
         case 'reset_user':
         case 'viewticket':
         case 'updateaccountsettings':
         case 'create_ticket':
         case 'create_request':
         case 'myprofile':
         case 'user_details':
         case 'updateuserpwd':
         case 'tr_employee':
         case 'create_admin_user':
         case 'edit_user':
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
