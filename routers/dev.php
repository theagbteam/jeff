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
        $Devcontroller->page_dashboard();
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
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'incidence_source':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'pipelines':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'pipeline_types':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'zones':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'wellhead_status':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'report_types':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'operator':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'priority':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'owners':
        $Devcontroller->page_corridorsAndItlikes();
        break;
        case 'corridors':
        $Devcontroller->page_corridorsAndItlikes();
        break;
         case 'viewlog':
            $Devcontroller->page_viewlog();
            break;
         case 'clearlog':
            $Devcontroller->clearlog();
            break;
        case 'edit_user':
            $Devcontroller->page_edit_user();
            break;
         case 'updateuserpwd':
        $Usercontroller->updatepassword();
        break;
        case 'restore_user':
        $Usercontroller->restoreuser();
        break;
        case 'users':
        $Devcontroller->page_users();
        break;
        case 'updateCompanyDetails':
        $Devcontroller->CompanyDetails();
        break;
        case 'updateMailerDetails':
        $Devcontroller->updateMailerDetails();
        break;
        case 'settings':
        $Devcontroller->page_settings();
        break;
        case 'totalrequest':
    //  $SearchForMiddleware->IsLoginSessionActive() ;
        $Devcontroller->page_totalrequest();
        break;
    case 'logout':
        $Usercontroller->logout();
        break;
    
    default:
           
        $Usercontroller->page_login();
}
