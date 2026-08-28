<?php
require_once ROOT_PATH . '/models/dev.php';
require_once ROOT_PATH . '/models/company.php';
require_once ROOT_PATH . '/models/User.php';
// require_once ROOT_PATH . '/models/StateModel.php';
// require_once ROOT_PATH . '/models/PhotoPassword_Update.php';
// require_once ROOT_PATH . '/middleware/AuthMiddleware.php';
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
       LOGIN
    ========================== */
    public function dashboard() {
  if (session_status() === PHP_SESSION_NONE) session_start();
   $callUserModel = new User();
   $roleCounts = $callUserModel->getRoleCounts();
   $CountTickets = $callUserModel->TicketCount();

$totaldev = $roleCounts['developers'];
$totalreporters = $roleCounts['reporters'];
$totaladmin = $roleCounts['administrators'];
$totalsupervisor = $roleCounts['supervisors'];

// $Ticket = $CountTickets->TicketCount();
 $counttickets = $CountTickets['total'];
// $ticketCounts['status_0']
// $ticketCounts['status_1']
// $ticketCounts['status_2']
  
 $result = $callUserModel->SelectOneUserAllData();

        if ($result['success']) {
            $user = $result['user'];

            $AbrvName = $user['fullname'];
            $user_image = $user['user_image'];
           
        } else {
            echo $result['error'];
        }
    
$parts = explode(' ', trim($AbrvName));
$first = array_shift($parts);

$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';



  $page_name = "dashboard";
  
  $role = $_SESSION['role'] ;
      $callCompanyModel = new CompanyModel() ;
      $company_settings = $callCompanyModel ->web_settings();
       $company_copyright  = $company_settings['company_copyright'] ?? '2025';
       $company_poweredby  = $company_settings['company_poweredby'] ?? 'AgbTeam';
       $company_copyrightlink  = $company_settings['company_copyrightlink'] ?? 'https://www.agbng.com';
       $company_settings = $callCompanyModel->web_settings();
      $company_online = $company_settings['company_online'] ?? 0;
      $company_Allow_signup = $company_settings['company_signup'] ?? 0;
      $company_alias = $company_settings['company_alias'] ?? 'Page';
       $company_logo = $company_settings['company_logo'] ?? '';
       $company_favicon = $company_settings['company_favicon'] ?? '';
       require ROOT_PATH . "/views/users/dev/dashboard.php";
  
  }

}



        
        

