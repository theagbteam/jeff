 <?php
session_start();
define('ROOT_PATH', 'C:\\xampp\\htdocs\\jeff');
// require_once ROOT_PATH . "/controllers/UserController.php";
require_once ROOT_PATH . "/middleware/AuthMiddleware.php";
$userid = $_SESSION['userid'] ?? null;
$SearchForMiddleware = new AuthMiddleware();
 $entryroles = $_SESSION['role'] ?? "guest";
//  $action = $_GET['action'] ?? 'login';


switch ($entryroles) {
      case 'guest':
    require_once   ROOT_PATH ."/routers/guest.php";
        break;

          case 'reporter':
    require_once   ROOT_PATH ."/routers/reporter.php";
        break;

          case 'admin':
    require_once   ROOT_PATH ."/routers/admin.php";
        break;

          case 'dev':
            //  $SearchForMiddleware->IsLoginSessionActive() ;
    require_once   ROOT_PATH ."/routers/dev.php";
        break;


    case 'logout':
        $controller->logout();
        break;
    
    default:
         $controller->pagenotfound();
}
