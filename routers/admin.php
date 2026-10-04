 <?php
require_once ROOT_PATH ."/controllers/Admincontroller.php";
require_once ROOT_PATH ."/controllers/UserController.php";
require_once   ROOT_PATH ."/middleware/AuthMiddleware.php";

$Usercontroller = new UserController();
$Admincontroller = new Admincontroller();
 $SearchForMiddleware = new AuthMiddleware();
$userid = $_SESSION['userid'] ?? null;
 $action = $_GET['action'] ?? 'login';


switch ($action) {
        case 'lgas':
        $Usercontroller->lgas();
        break;
    case 'submit':
        $Usercontroller->submit();
        break;
         case 'dashboard':
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
