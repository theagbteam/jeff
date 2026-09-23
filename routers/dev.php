 <?php
 
 require_once ROOT_PATH . "/controllers/UserController.php";
require_once   ROOT_PATH ."/middleware/AuthMiddleware.php";
$Usercontroller = new UserController();
$Devcontroller = new DevController();
 $SearchForMiddleware = new AuthMiddleware();
// $userid = $_SESSION['userid'] ?? null;
 $action = $_GET['action'] ?? 'login';


switch ($action) {
        case 'dashboard':
        $Devcontroller->dashboard();
        break;
        case 'create_reporter':
          $Usercontroller->create_reporter();
        break;
        case 'create_admin_user':
        $Devcontroller->create_admin_user();
        break;
        case 'Er':
        $Devcontroller->EraseRecord();
        break;
        case 'create_corridor':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'incidence_source':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'pipelines':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'pipeline_types':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'zones':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'wellhead_status':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'report_types':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'operator':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'priority':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'owners':
        $Devcontroller->corridorsAndItlikes();
        break;
        case 'corridors':
        $Devcontroller->corridorsAndItlikes();
        break;
         case 'viewlog':
            $Devcontroller->viewlog();
            break;
         case 'clearlog':
            $Devcontroller->clearlog();
            break;
        case 'edit_user':
            $Devcontroller->edit_user();
            break;
        $Usercontroller->updatepassword();
        break;
        case 'restore_user':
        $Usercontroller->restoreuser();
        break;
        case 'users':
        $Devcontroller->users();
        break;
        case 'updateCompanyDetails':
        $Devcontroller->updateCompanyDetails();
        break;
        case 'updateMailerDetails':
        $Devcontroller->updateMailerDetails();
        break;
        case 'settings':
        $Devcontroller->settings();
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
