 <?php
session_start();
// header('Content-Type: application/json');
// define('ROOT_PATH', dirname(__DIR__));
define('ROOT_PATH', 'C:\\xampp\\htdocs\\jeff');
// require_once ROOT_PATH . '/core/database.php';
require_once ROOT_PATH ."/controllers/UserController.php";
require_once   ROOT_PATH ."/middleware/AuthMiddleware.php";

$controller = new UserController();
 $SearchForMiddleware = new AuthMiddleware();
$userid = $_SESSION['userid'] ?? null;
 $action = $_GET['action'] ?? 'login';


switch ($action) {
      case 'login':
        //    $SearchForMiddleware->IsLoginSessionActive() ;
        $controller->login();
        break;

 case 'dashboard':

    //  $SearchForMiddleware->IsLoginSessionActive() ;
        $controller->dashboard();
      
      
        break;


    case 'getLGAs':

       $controller->getLGAs();
      
      
        break;
    case 'update_password':

   $controller->updatePassword();
      
      
        break;
    case 'update_photo':

       $controller->updatePhoto();
      
      
        break;

    case 'staffdisposition':
         $SearchForMiddleware->IsLoginSessionActive() ;
       $controller->staffdisposition();
      
      
        break;

   
    case 'monthlyreport_view':

     $SearchForMiddleware->IsLoginSessionActive() ;
        $controller->viewmonthlyreport();
      
        break;
    
 case 'newpersonnel':
     $SearchForMiddleware->IsLoginSessionActive() ;
        $controller->newpersonnel();
      
        break;
 case 'norminalrole':
     $SearchForMiddleware->IsLoginSessionActive() ;
        $controller->norminalrole();
      
        break;

  
    case 'logout':
        $controller->logout();
        break;
    
    default:
         $controller->pagenotfound();
}
