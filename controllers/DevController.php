<?php
require_once ROOT_PATH . '/models/dev.php';
require_once ROOT_PATH . '/models/company.php';
require_once ROOT_PATH . '/models/User.php';
// require_once ROOT_PATH . '/models/StateModel.php';
// require_once ROOT_PATH . '/models/PhotoPassword_Update.php';
require_once ROOT_PATH . '/middleware/AuthMiddleware.php';
require_once ROOT_PATH . '/services/mailer.php';

class DevController {

    private $db;

    private $photoPasswordModel;
    private $userid;
    public string $deviceType = 'pc'; // default
   

    public function __construct() {
        $this->userid= $_SESSION['userid'] ?? $_SESSION['userid'] ?? null;
        $this->db = (new Database())->getConnection();
        $this->photoPasswordModel = new PhotoPassword_Update($this->db);
    }
    
 

 /* ==========================
       totalrequest
    ========================== */

    public function totalrequest() {
  if (session_status() === PHP_SESSION_NONE) session_start();
    //  $_SESSION['msg']  = "";
    // $_SESSION['msg_notification']=0;
  $userid =$_SESSION['userid']; 
   $callUserModel = new User();
    $CallDevModel = new ModelDev;
   $callAuthMiddlewareClass = new AuthMiddleware;
   $roleCounts = $CallDevModel->getRoleCounts();
   $CountTickets = $CallDevModel->TicketCount();

 $totalrequests = $CallDevModel->GetRequestSum();

   
// $totaldev = $roleCounts['developers'];
$totalreporters = $roleCounts['reporters'];
$totaladmin = $roleCounts['administrators'];
$totalsupervisor = $roleCounts['supervisors'];

// $Ticket = $CountTickets->TicketCount();
 $counttickets = $CountTickets['total'];
// $ticketCounts['status_0']
// $ticketCounts['status_1']
// $ticketCounts['status_2']
  
 $result = $callUserModel->SelectUserTableForOne($userid);

        if ($result['success']) {
            $user = $result['user'];
     if ($user['msg_notification']==1){
                $_SESSION['msg_notification'] = 1;
                 $_SESSION['msg'] = $user['msg'];
              $callUserModel->clearMsgNotification($userid);
            }
            $AbrvName = $user['fullname'];
     $user_image = ($user['user_image'] ?? "") === "" ? "noimage2.png" : $user['user_image'];
          
        } else {
            echo $result['error'];
        }
    
$parts = explode(' ', trim($AbrvName));
$first = array_shift($parts);

$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';
  $page_name = "total request";
  $role_name = $role = $_SESSION['role'] ;

$result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);

if ($result['success']) {
    $user = $result['user'];
    $role_name = $user['role_name'];

    
}

     $callCompanyModel = new CompanyModel() ;
      $company_settings = $callCompanyModel ->web_settings();
      $company_logfile_url  = $company_settings['company_logfile_url'] ;
      $company_userid  = $company_settings['company_userid'] ;
       $company_copyright  = $company_settings['company_copyright'] ?? '2025';
       $company_poweredby  = $company_settings['company_poweredby'] ?? 'AgbTeam';
       $company_copyrightlink  = $company_settings['company_copyrightlink'] ?? 'https://www.agbng.com';
       $company_settings = $callCompanyModel->web_settings();
      $company_online = $company_settings['company_online'] ?? 0;
      $company_Allow_signup = $company_settings['company_signup'] ?? 0;
      $company_alias = $company_settings['company_alias'] ?? 'Page';
       $company_logo = $company_settings['company_logo'] ?? '';
       $company_favicon = $company_settings['company_favicon'] ?? '';

if (isset($_POST['dev_create_admin'])) {

    $fullname = trim($_POST['name'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $role = $role_name = "administrator";
//    $result = $CallDevModel->CreateAdministrator($company_userid, $fullname, $phone, $email);
 $result = $callUserModel->CreateUserAccount(
            $company_userid,
            $title,
            $fullname,
            $phone,
            $role,
            $role_name,
            $email
        );

    if (!empty($result['success'])) {
       $generatedPassword = $result['password'];
    $_SESSION['success'] = "Created successfully" ;
  $user_details = $AbrvName . " - " . $userid;
  $action = "Created new administrator";
   $user_details = $AbrvName . "  " . $userid;
 $logResult = $callAuthMiddlewareClass->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);

    
     header("Location: index?action=totalrequest");
            exit;
        // Successfully created

    } else {

        $_SESSION['error']= $result['error'];

    }
}

       require ROOT_PATH . "/views/users/dev/totalrequest.php";
  
  }



public function dashboard() {
  if (session_status() === PHP_SESSION_NONE) session_start();
//    $_SESSION['msg']  = "";
//     $_SESSION['msg_notification']=0;
  $userid =$_SESSION['userid']; 
   $callUserModel = new User();
   $LoadUsersAndLoginTable = $callUserModel->SelectUsersAndLoginTable();
    $CallDevModel = new ModelDev;
   $callAuthMiddlewareClass = new AuthMiddleware;
   $roleCounts = $CallDevModel->getRoleCounts();
   $CountTickets = $CallDevModel->TicketCount();

 $totalrequests = $CallDevModel->GetRequestSum();

   
// $totaldev = $roleCounts['developers'];
$totalreporters = $roleCounts['reporters'];
$totaladmin = $roleCounts['administrators'];
$totalsupervisor = $roleCounts['supervisors'];

// $Ticket = $CallDevModel->TicketCount();
 $counttickets = $CountTickets['total'];
// $ticketCounts['status_0']
// $ticketCounts['status_1']
// $ticketCounts['status_2']
  
 $result = $callUserModel->SelectUserTableForOne($userid);

        if ($result['success']) {
            $user = $result['user'];

            $AbrvName = $user['fullname'];
             
            if ($user['msg_notification']==1){
                $_SESSION['msg_notification'] = 1;
                 $_SESSION['msg'] = $user['msg'];
              $callUserModel->clearMsgNotification($userid);
            }


     $user_image = ($user['user_image'] ?? "") === "" ? "noimage2.png" : $user['user_image'];
          
        } else {
            echo $result['error'];
        }
    
$parts = explode(' ', trim($AbrvName));
$first = array_shift($parts);

$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';
  $page_name = "dashboard";
  $role_name = $role = $_SESSION['role'] ;

$result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);

if ($result['success']) {
    $user = $result['user'];

    $role_name = $user['role_name'];

    
}

     $callCompanyModel = new CompanyModel() ;
      $company_settings = $callCompanyModel ->web_settings();
      $company_logfile_url  = $company_settings['company_logfile_url'] ;
      $company_userid  = $company_settings['company_userid'] ;
       $company_copyright  = $company_settings['company_copyright'] ?? '2025';
       $company_poweredby  = $company_settings['company_poweredby'] ?? 'AgbTeam';
       $company_copyrightlink  = $company_settings['company_copyrightlink'] ?? 'https://www.agbng.com';
       $company_settings = $callCompanyModel->web_settings();
      $company_online = $company_settings['company_online'] ?? 0;
      $company_Allow_signup = $company_settings['company_signup'] ?? 0;
      $company_alias = $company_settings['company_alias'] ?? 'Page';
       $company_logo = $company_settings['company_logo'] ?? '';
       $company_favicon = $company_settings['company_favicon'] ?? '';

if (isset($_POST['dev_create_admin'])) {

    $title= trim($_POST['title'] ?? '');
    $fullname = trim($_POST['name'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $role = $role_name = "administrator";
//    $result = $CallDevModel->CreateAdministrator($company_userid, $fullname, $phone, $email);
$result = $callUserModel->CreateUserAccount(
            $company_userid,
            $title,
            $fullname,
            $phone,
            $role,
            $role_name,
            $email
        );

    if (!empty($result['success'])) {
       $generatedPassword = $result['password'];
    $_SESSION['success'] = "Created successfully" ;
  $user_details = $AbrvName . " - " . $userid;
  $action = "Created new administrator";
   $user_details = $AbrvName . "  " . $userid;
 $logResult = $callAuthMiddlewareClass->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);

    
     header("Location: index?action=dashboard");
            exit;
        // Successfully created

    } else {

        $_SESSION['error']= $result['error'];

    }
}

       require ROOT_PATH . "/views/users/dev/dashboard.php";
  
  }


}