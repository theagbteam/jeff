 <?php
session_start();
define('ROOT_PATH', 'C:\\xampp\\htdocs\\jeff');
require_once ROOT_PATH ."/controllers/UserController.php";
require_once   ROOT_PATH ."/middleware/AuthMiddleware.php";

$controller = new UserController();
 $SearchForMiddleware = new AuthMiddleware();
$userid = $_SESSION['userid'] ?? null;
 $action = $_GET['action'] ?? 'login';


switch ($action) {
       case 'compulsory_cp':
        $Usercontroller->updatepassword();
        break;
      case 'login':
        //    $SearchForMiddleware->IsLoginSessionActive() ;
        $controller->page_login();
        break;

 case 'create_report':
        $controller->create_report();
      
      
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
