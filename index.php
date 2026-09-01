 <?php
session_start();
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . "/controllers/UserController.php";
require_once ROOT_PATH . "/controllers/DevController.php";
require_once ROOT_PATH . "/middleware/AuthMiddleware.php";
$userid = $_SESSION['userid'] ?? null;
$SearchForMiddleware = new AuthMiddleware();
// $UserController = new UserController();
  $entryroles = $_SESSION['role'] ?? "guest";
//  $action = $_GET['action'] ?? 'login';


switch ($entryroles) {
      case 'guest':
    require_once   ROOT_PATH ."/routers/guest.php";
        break;

          case 'reporter':
    require_once   ROOT_PATH ."/routers/reporter.php";
        break;
          case 'supervisor':
    require_once   ROOT_PATH ."/routers/supervisor.php";
        break;

          case 'administrator':
    require_once   ROOT_PATH ."/routers/admin.php";
        break;

          case 'developer':
            //  $SearchForMiddleware->IsLoginSessionActive() ;
    require_once   ROOT_PATH ."/routers/dev.php";
        break;

    default:
         $UserController->pagenotfound();
}
