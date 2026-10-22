<?php

require_once ROOT_PATH . '/models/admin.php';

require_once ROOT_PATH . '/models/company.php';

require_once ROOT_PATH . '/models/User.php';
require_once ROOT_PATH . '/models/State.php';

require_once ROOT_PATH . '/models/Lga.php';

// require_once ROOT_PATH . '/models/StateModel.php';

// require_once ROOT_PATH . '/models/PhotoPassword_Update.php';

require_once ROOT_PATH . '/middleware/AuthMiddleware.php';

require_once ROOT_PATH . '/services/mailer.php';

class Admincontroller {

    private $db;
    private $stateModel;
    private $lgaModel;
    private $photoPasswordModel;

    private $userid;

    public string $deviceType = 'pc'; // default



    public function __construct() {

        // $this->userid= $_SESSION['userid'] ?? $_SESSION['userid'] ?? null;

        $this->db = (new Database())->getConnection();
        $this->stateModel = new State();
        $this->lgaModel   = new Lga();
        // $this->photoPasswordModel = new PhotoPassword_Update($this->db);

    }

 public function getLgas() {
        header('Content-Type: application/json');

        $stateId = isset($_GET['state_id']) ? (int)$_GET['state_id'] : 0;

        if ($stateId <= 0) {
            echo json_encode(['success' => false, 'data' => []]);
            return;
        }

        $lgas = $this->lgaModel->getByState($stateId);
        echo json_encode(['success' => true, 'data' => $lgas]);
    }














public function page_dashboard() {
    
  if (session_status() === PHP_SESSION_NONE) session_start();
   $template_mode = "auto";
    $userid =$_SESSION['userid']; 
   $role_name = $role = $_SESSION['role'] ;
    $LoadAllNigeriaStates = $this->stateModel->getAll();
   $callUserModel = new User();
  $CallModelAdmin = new ModelAdmin;
  
  $wellhead_status_counts = $CallModelAdmin->GetWellheadStatusCounts();
 
  $CallMailerModel = new Mailer;

        $callAuthMiddlewareClass = new AuthMiddleware;
        $callCompanyModel = new CompanyModel() ;
         $company_settings = $callCompanyModel->web_settings();

// Get user  status counts
$statusCounts = $CallModelAdmin->StatusCount();

$totalUsers         = (int) ($statusCounts['total'] ?? 0);
$totalInactiveUsers = (int) ($statusCounts['inactive'] ?? 0);
$totalActiveUsers   = (int) ($statusCounts['active'] ?? 0);
$totalDeletedUsers  = (int) ($statusCounts['deleted'] ?? 0);


  if (isset($_GET['token_edit'])) { 
    $token = $_GET['token_edit']; 
    $user_id = base64_decode($token, true);
    $LoadAParticularUsersAndLoginTableForAdmin=$callUserModel->SelectUsersAndLoginTableforOnePersonAfterLogin($user_id);
        }
  if (isset($_GET['viewtoken'])) { 
    $token = $_GET['viewtoken']; 
    $ticket_token = base64_decode($token, true);
       $the_tablename="ticket_reports"; $column_name="ticket_id"; $column_value=$ticket_token  ;
 $ViewTicketListing = $callUserModel->GeneralSelectAnyTableWhereColumnValueEquals($the_tablename, $column_name, $column_value);

       }
 
        
  if (isset($_GET['token_userdetails'])) { 
    $token = $_GET['token_userdetails']; 
    $user_id = base64_decode($token, true);
    $LoadAParticularUsersAndLoginTableForAdmin=$callUserModel->SelectUsersAndLoginTableforOnePersonAfterLogin($user_id);
    
    }
 
         $CheifAdminCrown ="";
           $company_adminseniorman  = $company_settings['company_adminseniorman'] ;
         $LoadAllUsersAndLoginTableForAdmin = $CallModelAdmin-> SelectAllCategoryOfUsersAndLoginTableForAdmin($userid);
   $tb_name = "request"; $LoadAllRequest =  $callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "corridor"; $LoadCorridorColumnForSelect =  $callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "audit_trail"; $LoadAuditTrail =  $callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "transfer_history"; $LoadTransferHistory =  $callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "priority"; $LoadPriorityColumnForSelect =  $callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "incidence_source";$LoadIncidenceSourceColumnForSelect=$callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "operator";$LoadOperatorColumnForSelect=$callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "zone";$LoadZoneColumnForSelect=$callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "pipeline";$LoadPipelineColumnForSelect=$callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "pipeline_type";$LoadPipelineTypeColumnForSelect=$callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "ticket_reports";$LoadAllTickets=$callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "ticket_replies";$LoadAllReplies=$callUserModel->GeneralSelectAnyTable($tb_name);
   $tb_name = "wellhead_status";$LoadAllTicketCategories=$callUserModel->GeneralSelectAnyTable($tb_name);
   $ticket_id = $callUserModel->generateTicketId();
   if ($ticket_id === null) { $ticket_id="Undefined"; }
$page_link_title = $_GET['action'] ?? 'tickets';
if ($page_link_title =="run_reports") {
$page_name ="Run Reports";
}elseif ($page_link_title =="audit_trail") {
$page_name ="Audit Trail";
}elseif ($page_link_title =="cr_ticket") {
    $Crt_sn = isset($_GET['sn']) ? (int) $_GET['sn'] : 0; 
    if ($Crt_sn <= 0) {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
}

    $the_tablename="ticket_category"; $column_name="sn"; $column_value=$Crt_sn  ;
 $checkIfCrSn = $callUserModel->GeneralSelectAnyTableWhereColumnValueEquals($the_tablename, $column_name, $column_value);
if (empty($checkIfCrSn)) {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
}


$checkIfCrSn = $checkIfCrSn[0] ?? null; // because ORDER BY sn DESC

if ($checkIfCrSn) {
    $Tk_RowSearchValue = $checkIfCrSn['name']; // e.g. $row['report_title']
    // do something with $row
}



 $page_name ="Create Tickets";
}elseif ($page_link_title =="export_tickets") {
$page_name ="Export Tickets";
}elseif ($page_link_title =="edit_user") {
$page_name ="View user";
}elseif ($page_link_title =="myprofile") {
$page_name ="My profile";
}elseif ($page_link_title =="manage_users"|| $page_link_title =="create_admin_user"|| $page_link_title =="user_details") {
$page_name ="Manage Users";
}elseif ($page_link_title =="user_requests") {
$page_name ="All Request";
}elseif ($page_link_title =="transfers" || $page_link_title =="tr_employee") {
$page_name ="Transfer History";
}elseif ($page_link_title =="user_library") {
$page_name ="Upload Library";
}elseif ($page_link_title =="audit_trail") {
$page_name ="Audit Trail";
}elseif ($page_link_title =="viewticket") {
$page_name ="View ticket";
}else{
   $page_link_title="tickets";
  $page_name ="Tickets";
$tb_name = "ticket_reports";$LoadAllTickets =  $callUserModel->GeneralSelectAnyTable($tb_name);
}   
    
       
          $CF_VerificationSiteUrl = $company_settings['cloudfare_verifyurl'] ?? '';
        $CF_SecretKey = $company_settings['cloudfare_secretkey'] ?? '';
        $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';
           // $LoadCorridorsAndItLikes = $callUserModel->SelecttableForSelectOptionsFormField($tb_name);
         $callAuthMiddlewareClass->IfSessionDeactiveAutologout();
   if ($callAuthMiddlewareClass->IsThisAfirstTimeLogin()) {
header("Location: index?action=compulsory_cp");
   }
   $search_tb_name ="ticket_category";
  $LoadTicketcategories= $callUserModel->GeneralSelectAnyTable($search_tb_name);
   
   $TotalNoTickets = $callUserModel->CountAllTickets();
            // $isConnected = $callAuthMiddlewareClass->checkConnection();
//    $roleCounts = $CallModelAdmin->getRoleCounts();

//    $CountTickets = $CallModelAdmin->TicketCount();

//   $totalrequests = $CallModelAdmin->GetRequestSum();
// $totalreporters = $roleCounts['reporters'];$totaladmin = $roleCounts['administrators'];$totalsupervisor = $roleCounts['supervisors'];

// $Ticket = $CallDevModel->TicketCount();

//  $counttickets = $CountTickets['total'];

// $ticketCounts['status_0']

// $ticketCounts['status_1']

// $ticketCounts['status_2']

// Admin personal records
 $LoadUsersAndLoginTableForAdmin = $callUserModel->SelectUsersAndLoginTableforOnePersonAfterLogin($userid);
         if ($LoadUsersAndLoginTableForAdmin['success']) {
            $user = $LoadUsersAndLoginTableForAdmin['user'];
           $user_corridor = $user['user_corridor']; 
 $template_mode = ($user['login_TemplateMode'] ?? '') !== '' ? $user['login_TemplateMode'] : 'auto';
          $admin_e= $user_email  = $user['user_email']; 
           $user_phone  = $user['user_phone']; 
          $admin_fn= $fullname = $user['user_fullname']; 
         $admin_lr=  $role = $_SESSION['role'] = $user['login_role']; 
          $admin_lrn= $role_name  = $user['login_role_name']; 
          $admin_abr= $AbrvName = $user['AbrvName'];
           $last_login = $user['login_last_login'];
// user roles
$login_delete_report = $user['login_delete_report'];
$login_approve_report = $user['login_approve_report'];
$login_edit_report = $user['login_edit_report'];
$login_approve_report = $user['login_approve_report'];
$login_create_report = $user['login_create_report'];
$login_approve_user = $user['login_approve_user'];
$login_delete_user = $user['login_delete_user'];
$login_create_user = $user['login_create_user'];
$login_edit_user = $user['login_edit_user'];






            $user_image = ($user['user_image'] ?? "") === "" ? "noimage2.png" : $user['user_image'];
if ($user['user_msg_notification']==1){
    $_SESSION['msg_notification'] = 1;
$_SESSION['msg'] = $user['user_msg'];
$callUserModel->clearMsgNotification($userid);
}
             } else {

            $_SESSION['error'] = $LoadUsersAndLoginTableForAdmin['error'];
              header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;

        }

  
    

      $company_logfile_url  = $company_settings['company_logfile_url'] ;

      $company_userid  = $company_settings['company_userid'] ;

       $company_copyright  = $company_settings['company_copyright'] ?? '2025';

       $company_poweredby  = $company_settings['company_poweredby'] ?? 'AgbTeam';

       $company_copyrightlink  = $company_settings['company_copyrightlink'] ?? 'https://www.agbng.com';

      
 $company_logo =     $company_settings['company_logo'] ?? '';
      $company_online = $company_settings['company_online'] ?? 0;

      $company_Allow_signup = $company_settings['company_signup'] ?? 0;
      if ($company_Allow_signup==0){
        $company_Allow_signup_text="Disallow";
      }else{
       $company_Allow_signup_text="Allow";

      }
      $company_acct_approval = $company_settings['company_acct_approval'] ?? 0;
      if ($company_acct_approval==0){
        $company_acct_approval_text="Disallow";
      }else{
       $company_acct_approval_text="Allow";

      }
      $company_allownotification = $company_settings['company_allownotification'] ?? 0;
      if ($company_allownotification==0){
        $company_allownotification_text="Disallow";
      }else{
       $company_allownotification_text="Allow";

      }
      $company_name = $company_settings['company_name'] ?? 'ACISS';
      $company_alias = $company_settings['company_alias'] ?? 'Page';

       $company_logo = $company_settings['company_logo'] ?? '';

       $company_favicon = $company_settings['company_favicon'] ?? '';

         $company_url = $company_settings['company_url'] ?? '';

            $loginurl = $company_url."/index.php?action=login" ;






 if (isset($_GET['token_reset'])) {
    // 1. Decode the token properly
    $userrefid = base64_decode(urldecode($_GET['token_reset']), true);

    // 2. Validate
    if ($userrefid === false || !is_numeric($userrefid)) {
        $_SESSION['error'] = "Invalid activation token.";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=index'));
        exit;
    }

    $userrefid = (int) $userrefid;
    $user_details = $admin_abr . " - " . $_SESSION['userid'];

    // 3. Call model
    $UpdateStatues = $CallModelAdmin->updateStatus($userrefid);

    if (!$UpdateStatues) {
        $_SESSION['error'] = "Failed to activate account. User not found.";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=index'));
        exit;
    }

    $fullname      = $UpdateStatues['fullname'];
    $email         = $UpdateStatues['email'];
    $plainPassword = $UpdateStatues['plain_password'];

    $_SESSION['success'] = "Account activated successfully";

    $subject = "Account activated successfully";
    $action  = "You activated " . $fullname . "'s account";

    $message = "Hello $fullname,<br><br>"
             . "Your account has been activated successfully.<br><br>"
             . "Your registration/activation has been completed, and your account is now ready for use.<br><br>"
             . "<strong>Reference ID:</strong> $userrefid<br>"
             . "<strong>Reference PASSWORD:</strong> $plainPassword<br>"
             . "Please use your Reference ID and default password to log in to your account. For your security, we strongly recommend changing your default password after your first successful login.<br><br>"
             . "<div style='text-align:center; margin:25px 0;'>"
             . "<a href='$loginurl' style='display:inline-block; padding:12px 25px; background-color:#0d6efd; color:#ffffff; text-decoration:none; border-radius:5px; font-weight:bold;'>"
             . "Login to Your Account"
             . "</a>"
             . "</div>"
             . "If you did not register for this account, please contact the Support Team immediately.<br><br>"
             . "Best regards,<br>"
             . "The Support Team";

    $SendEmail = $CallMailerModel->sendmail($email, $subject, $message);

    $logResult = $callAuthMiddlewareClass->writelog(
        $_SESSION['userid'], $_SESSION['role'], $_SESSION['role'],
        $user_details, $action, $company_logfile_url
    );

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=index'));
    exit;
}





if (isset($_POST['delete_selected_tickets'])) {

    $ticketIds = $_POST['ticket_ids'] ?? [];

    if (!is_array($ticketIds) || empty($ticketIds)) {
        $_SESSION['error'] = 'No tickets selected for deletion.';
        header('Location: index.php?action=tickets');
        exit;
    }

    $ticketIds = array_values(array_filter(array_map(function ($v) {
        return trim((string) $v);
    }, $ticketIds), function ($v) {
        return $v !== '';
    }));

    if (empty($ticketIds)) {
        $_SESSION['error'] = 'No valid tickets selected for deletion.';
        header('Location: index.php?action=tickets');
        exit;
    }

    $deleteResult = $CallModelAdmin->DeleteTicketsByIds($ticketIds);

    if (!empty($deleteResult['success']) && (int)$deleteResult['deleted'] > 0) {

        $_SESSION['success'] = $deleteResult['deleted'] . ' ticket(s) deleted successfully.';

        $user_details = $admin_abr . " - " . $_SESSION['userid'];
        $action = 'Deleted ' . $deleteResult['deleted'] . ' ticket(s): ' . implode(', ', $ticketIds);

        $callAuthMiddlewareClass->writelog(
            $_SESSION['userid'],
            $admin_lrn,
            $admin_lr,
            $user_details,
            $action,
            $company_logfile_url
        );

    } else {
        $_SESSION['error'] = $deleteResult['message'] ?? 'Unable to delete selected tickets.';
    }

    header('Location: index.php?action=tickets');
    exit;
}


// Assign users

   
if (isset($_POST['assign_owner'])) {$ticketId    = trim($_POST['ticket_id'] ?? '');
    $ownerUserId = trim($_POST['owner']     ?? '');

    if ($ticketId === '' || $ownerUserId === '') {
        $_SESSION['error'] = "Ticket ID and owner are required.";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=dashboard'));
        exit;
    }

    $OwnerUserResult = $callUserModel->SelectUsersAndLoginTableforOnePersonAfterLogin($ownerUserId);

    if (empty($OwnerUserResult['success']) || empty($OwnerUserResult['user'])) {
        $_SESSION['error'] = "Could not find the selected owner. Please try again.";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=dashboard'));
        exit;
    }

    $ownerUser     = $OwnerUserResult['user'];
    $ownerFullName = trim($ownerUser['user_fullname'] ?? '');
    $ownerAbrvName = trim($ownerUser['AbrvName']      ?? '');
    $ownerEmail    = trim($ownerUser['user_email']    ?? '');

    if ($ownerFullName === '') {
        $_SESSION['error'] = "Selected owner has no name on record. Please update the user first.";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=dashboard'));
        exit;
    }

    $ticketRows     = $callUserModel->GeneralSelectAnyTableWhereColumnValueEquals('ticket_reports', 'ticket_id', $ticketId);
    $ticketRow      = $ticketRows[0] ?? [];
    $ticketSubject  = trim($ticketRow['subject']  ?? '');
    $ticketCategory = trim($ticketRow['category'] ?? '');
    $ticketPriority = trim($ticketRow['priority'] ?? '');

    $data = [
        'the_tablename' => "ticket_reports",
        'column_value'  => $ownerFullName,
        'column_name'   => "owner",
        'where_column'  => "ticket_id",
        'where_value'   => $ticketId
    ];

    $UpdateTicketOwner = $callUserModel->GeneralUpdateAnyTableColumnWithThisValue($data);

    if ($UpdateTicketOwner) {

        $dataOwnerUserId = [
            'the_tablename' => "ticket_reports",
            'column_value'  => $ownerUserId,
            'column_name'   => "owner_userid",
            'where_column'  => "ticket_id",
            'where_value'   => $ticketId
        ];

        $callUserModel->GeneralUpdateAnyTableColumnWithThisValue($dataOwnerUserId);

        $_SESSION['success'] = "New owner assigned successfully";

        $user_details = $admin_abr . " - " . $_SESSION['userid'];
        $action       = "Assigned ticket " . $ticketId . " to " . $ownerFullName . " (Ref ID: " . $ownerUserId . ")";

        $logResult = $callAuthMiddlewareClass->writelog(
            $_SESSION['userid'],
            $admin_lrn,
            $admin_lr,
            $user_details,
            $action,
            $company_logfile_url
        );

        if ($ownerEmail !== '' && filter_var($ownerEmail, FILTER_VALIDATE_EMAIL)) {

            $subject = "Ticket Assigned To You: " . $ticketId;

            $safeFullName = htmlspecialchars($ownerFullName, ENT_QUOTES, 'UTF-8');
            $safeTicketId = htmlspecialchars($ticketId,     ENT_QUOTES, 'UTF-8');
            $safeSubject  = htmlspecialchars($ticketSubject,  ENT_QUOTES, 'UTF-8');
            $safeCategory = htmlspecialchars($ticketCategory, ENT_QUOTES, 'UTF-8');
            $safePriority = htmlspecialchars($ticketPriority, ENT_QUOTES, 'UTF-8');
            $assignedBy   = htmlspecialchars($admin_fn ?? '', ENT_QUOTES, 'UTF-8');

            $message =
                "Hello $safeFullName,<br><br>"
              . "A ticket has been assigned to you.<br><br>"
              . "<strong>Ticket ID:</strong> $safeTicketId<br>"
              . "<strong>Subject:</strong> $safeSubject<br>"
              . "<strong>Category:</strong> $safeCategory<br>"
              . "<strong>Priority:</strong> $safePriority<br>"
              . "<strong>Assigned By:</strong> $assignedBy<br><br>"
              . "Please log in to review the ticket and take the necessary action.<br><br>"
              . "<div style='text-align:center; margin:25px 0;'>"
              . "<a href='" . htmlspecialchars($loginurl, ENT_QUOTES, 'UTF-8') . "' "
              . "style='display:inline-block; padding:12px 25px; background-color:#0d6efd; "
              . "color:#ffffff; text-decoration:none; border-radius:5px; font-weight:bold;'>"
              . "Login to Your Account"
              . "</a>"
              . "</div>"
              . "Best regards,<br>"
              . "The Support Team";

            $CallMailerModel->sendmail($ownerEmail, $subject, $message);
        }

    } else {
        $_SESSION['error'] = "Error assigning owner, please try again later";
    }

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=dashboard'));
    exit;}
 if (isset($_POST['updateuserpwd'])) {


        $userid = $_SESSION['userid'];
        $role_name = $role = $_SESSION['role'];

        $subject = $action = "Your Password was updated";

        $data = [
            'userid' => $userid,
            'old_password' => trim($_POST['old_password'] ?? ''),
            'new_password' => trim($_POST['new_password'] ?? ''),
            'verify_password' => trim($_POST['verify_password'] ?? '')
        ];

        if (
            $data['new_password'] === '' ||
            $data['verify_password'] === ''
        ) {
            $_SESSION['error'] = "Empty fields are not allowed";

            header(
                "Location: " .
                ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=index')
            );

            exit;
        }

        $result = $callUserModel->updateuserpwd($data);

        if ($result === "Password updated successfully.") {

            $_SESSION['success'] = $result;

            $userResult = $callUserModel->SelectUserTableForOne($userid);

            if (
                !empty($userResult['success']) &&
                !empty($userResult['user'])
            ) {

                $user = $userResult['user'];

                $user_fullname = $user['fullname'] ?? 'User';

                $parts = explode(' ', trim($user_fullname));

                $first = array_shift($parts);

                $AbrvName = !empty($first)
                    ? $first .
                        (!empty($parts)
                            ? ' ' .
                                implode(
                                    '.',
                                    array_map(
                                        fn($p) => strtoupper($p[0]),
                                        $parts
                                    )
                                )
                            : '')
                    : 'User';

                $receiveraddress = $user['email'] ?? '';

                $user_details = $AbrvName . "  " . $userid;
            }

            $message =
                "Hello $user_fullname,<br><br>" .
                "Your account password has been changed successfully.<br><br>" .
                "<strong>Reference ID:</strong> $userid<br><br>" .
                "If you made this change, no further action is required.<br><br>" .
                "If you did not change your password, please contact the Support Team immediately.<br><br>" .
                "Best regards,<br>" .
                "The Support Team";

            $logResult = $callAuthMiddlewareClass->writelog(
                $userid,
                $role_name,
                $role,
                $user_details,
                $action,
                $company_logfile_url
            );

            $SendEmail = $CallMailerModel->sendmail(
                $receiveraddress,
                $subject,
                $message
            );

  
            // header("Location: index?action=dashboard");

            // exit;
             header("Location: " .($_SERVER['HTTP_REFERER'] ?? 'index.php?action=dashboard')); exit;

        } else {

            $_SESSION['error'] = $result;

            header("Location: " .($_SERVER['HTTP_REFERER'] ?? 'index.php?action=dashboard')); exit;
        }
    
}








if (isset($_POST['initiate_transfer'])) {
$action_token = trim($_POST['action_token'] ?? '');
$session_token = $_SESSION['action_token'] ?? '';

if (
    $action_token === '' ||
    $session_token === '' ||
    !hash_equals($session_token, $action_token)
) {
    $_SESSION['error'] = "Invalid authorization token.";
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit;
}
$employee_userid= trim($_POST['employee_userid'] ?? '');
 $userResult=$callUserModel->SelectUsersAndLoginTableforOnePersonAfterLogin($employee_userid);
    if ($userResult['success']) {
   $current_corridor = $userResult['user']['user_corridor'];
    $user_fn = $userResult['user']['user_fullname'] ?? '';
    $user_AbrvName= $userResult['user']['AbrvName'] ?? '';
     $receiveraddress = $userResult['user']['user_email'] ?? '';
$TrRef_ID = 'TRF' . date('YmdHis') . random_int(1000, 9999);


   $data = [
        'refid' => $TrRef_ID,
        'user_transfered'           => $user_fn,
        'from_corridor'             => $current_corridor, // Fetch employee's current corridor
        'to_corridor'               => trim($_POST['to_corridor'] ?? ''),
        'transfer_initilizer'       => $admin_fn, // Current logged-in user
        'date_transfered'            => date('Y-m-d H:i:s'),
        'expected_resumption_date'  => trim($_POST['effective_date'] ?? ''),
        'reason'                     => trim($_POST['transfer_reason'] ?? ''),
        'status'                     => '1'
    ];


if ($current_corridor == $_POST['to_corridor']) {
    
      $_SESSION['error'] = $user_fn . " is already stationed at " . $_POST['to_corridor'] . " corridor";
 header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;

}

    $resultadmin = $CallModelAdmin->InsertTransferHistory($data);

    if ($resultadmin) {
         $_SESSION['success'] = "Transfer initiated successfully";

$user_details = $admin_abr . " - " . $_SESSION['userid'];
$action = "Initiated the transfer of ". $user_fn . " to " . $_POST['to_corridor'] . " corridor";
  
    $data = [
        'the_tablename' => "users",
        'column_value'  =>$_POST['to_corridor'],
        'column_name'   => "corridor",
        'where_column'  => "userid",
        'where_value'   => $employee_userid
    ];

    $UpdateTransferedUserCorridor = $callUserModel->GeneralUpdateAnyTableColumnWithThisValue($data);
 $logResult = $callAuthMiddlewareClass->writelog($_SESSION['userid'], $admin_lrn,$admin_lr, $user_details, $action,$company_logfile_url);
$subject = "You Have Been Transferred";

$message = "Hello $user_fn,<br><br>"

         . "This is to inform you that you have been transferred from <strong>$current_corridor</strong> corridor to <strong>" . htmlspecialchars($_POST['to_corridor'] ?? '', ENT_QUOTES, 'UTF-8') . "</strong> corridor.<br><br>"

         . "<strong>Reference ID:</strong> " . htmlspecialchars($TrRef_ID, ENT_QUOTES, 'UTF-8') . "<br>"
         . "<strong>Date of Transfer:</strong> " . date('Y-m-d H:i:s') . "<br>"
         . "<strong>Effective Date of Resumption:</strong> " . htmlspecialchars($_POST['effective_date'] ?? '', ENT_QUOTES, 'UTF-8') . "<br>"
         . "<strong>Reason for Transfer:</strong> " . htmlspecialchars($_POST['transfer_reason'] ?? '', ENT_QUOTES, 'UTF-8') . "<br><br>"

         . "Please take note of your new corridor assignment and resume your duties on the effective resumption date stated above.<br><br>"

         . "If you have any questions regarding this transfer, please contact your administrator or supervisor.<br><br>"

         . "Best regards,<br>"
         . "The Support Team";
      $SendEmail = $CallMailerModel->sendmail($receiveraddress,$subject, $message);









    } else {
        $_SESSION['error'] = "Error initiating transfer";
    }


}else{
    $_SESSION['error'] = "There was an error processing  this request";
  }

  header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;

}



// Update acount settings
if (isset($_POST['update_settings'])) {
    $data = [
        'template_mode' => trim($_POST['template_mode'] ?? ''),
        'company_allownotification' => trim($_POST['company_allownotification'] ?? $company_allownotification),
        'allow_signup' => trim($_POST['allow_signup'] ?? $company_Allow_signup),
        'auto_approval' => trim($_POST['auto_approval'] ?? $company_acct_approval),
        'userid'        => (int) $_SESSION['userid'],
    ];
if (in_array('', $data, true)) {
        $_SESSION['error'] = 'All fields are required.';
}else{

    if ($callUserModel->updateSettings($data)) {
        $_SESSION['success'] = 'Account settings updated successfully';
        $action = "Updated account settings";
        $user_details = $admin_abr . " - " . $_SESSION['userid'];
          $logResult = $callAuthMiddlewareClass->writelog($_SESSION['userid'], $_SESSION['role'],$_SESSION['role'], $user_details, $action,$company_logfile_url);

        
    } else {
         $_SESSION['error']  = 'Could not update settings.';
    }
}
     header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
}


// create ticket

 if (isset($_POST['CreateNewTicket'])) {

    $userid = $_SESSION['userid'];
  $status_text="new";
    $data = [
      'ticket_id' => 'TKT' . date('YmdHis') . substr(str_replace('.', '', (string) microtime(true)), -6),
        'date_created'                              => date('Y-m-d H:i:s'),
        'status_text'                              => $status_text,
        'date_updated'                              => 'Nil',
        'category'                                  => trim($_POST['category'] ?? ''),
        'priority'                                  => trim($_POST['priority'] ?? ''),
        'pipeline'                                  => trim($_POST['pipeline'] ?? ''),
        'pipeline_type'                             => trim($_POST['pipeline_type'] ?? ''),
        'subject'                                   => trim($_POST['subject'] ?? ''),
        'message'                                   => trim($_POST['message'] ?? ''),
        'name'                                      => trim($_POST['name'] ?? ''),
        'email'                                     => trim($_POST['email'] ?? ''),
        'phone_no'                                  => trim($_POST['phone_no'] ?? ''),
        'incidence_date'                            => trim($_POST['incidence_date'] ?? ''),
        'incidence_source'                          => trim($_POST['incidence_source'] ?? ''),
        'state'                                     => trim($_POST['state'] ?? ''),
        'community'                                 => trim($_POST['community'] ?? ''),
        'local_government'                          => trim($_POST['local_government'] ?? ''),
        'operator'                                  => trim($_POST['operator'] ?? ''),
        'zone'                                      => trim($_POST['zone'] ?? ''),
        'corridor'                                  => trim($_POST['corridor'] ?? ''),
        'number_of_arrested_suspects'               => trim($_POST['number_of_arrested_suspects'] ?? '0'),
        'vehicle_arrested_destroyed'                => trim($_POST['vehicle_arrested_destroyed'] ?? '0'),
        'wooden_boat_speed_boat_arrested_destroyed' => trim($_POST['wooden_boat_speed_boat_arrested_destroyed'] ?? '0'),
        'vessel_arrested_destroyed'                 => trim($_POST['vessel_arrested_destroyed'] ?? '0'),
        'location_coordinate_latitude'              => trim($_POST['location_coordinate_latitude'] ?? ''),
        'location_coordinate_longitude'             => trim($_POST['location_coordinate_longitude'] ?? ''),
        'quantity_of_crude_recovered_destroyed_ltr' => trim($_POST['quantity_of_crude_recovered_destroyed_ltr'] ?? '0'),
        'quantity_of_ago_recovered_destroyed_ltr'   => trim($_POST['quantity_of_ago_recovered_destroyed_ltr'] ?? '0'),
        'quantity_of_pms_recovered_destroyed_ltr'   => trim($_POST['quantity_of_pms_recovered_destroyed_ltr'] ?? '0'),
        'dpk_recovered_destroyed_ltr'               => trim($_POST['dpk_recovered_destroyed_ltr'] ?? '0'),
        'illegal_storage_dump_sites'                => trim($_POST['illegal_storage_dump_sites'] ?? '0'),
        'description_of_reported_incidence'         => trim($_POST['description_of_reported_incidence'] ?? ''),
        'notify'                                    => isset($_POST['notify']) ? 1 : 0,
        'show'                                      => isset($_POST['show']) ? 1 : 0,
        'due_date'                                  => trim($_POST['due_date'] ?? ''),
    ];



$raw = trim($_POST['incidence_date'] ?? '');

if ($raw === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) {
    // reject — don't insert
    $_SESSION['error'] =$errors[] = 'Incident date is required.';
     header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit;
} 



    /*
    |--------------------------------------------------------------------------
    | Fields that are allowed to be empty
    |--------------------------------------------------------------------------
    | 'community', 'phone_no', 'due_date', 'description_of_reported_incidence'
    */

    $optional_fields = [
        'due_date',
        'date_updated',
        'due_date',
        'description_of_reported_incidence'
    ];

    /*
    |--------------------------------------------------------------------------
    | Human readable labels for each field (used in error messages)
    |--------------------------------------------------------------------------
    */

    $field_labels = [
        'ticket_id'                                 => 'Ticket ID',
        'date_created'                              => 'Date Created',
        'category'                                  => 'Category',
        'priority'                                  => 'Priority',
        'pipeline'                                  => 'Pipeline',
        'pipeline_type'                             => 'Pipeline Type',
        'subject'                                   => 'Subject',
        'message'                                   => 'Message',
        'name'                                      => 'Name',
        'email'                                     => 'Email',
        'phone_no'                                  => 'Phone No',
        'incidence_date'                            => 'Incident Date',
        'incidence_source'                          => 'Incident Source',
        'state'                                     => 'State',
        'community'                                 => 'Community',
        'local_government'                          => 'Local Government',
        'operator'                                  => 'Operator',
        'zone'                                      => 'Zone',
        'corridor'                                  => 'Corridor',
        'number_of_arrested_suspects'               => 'Number of Arrested Suspects',
        'vehicle_arrested_destroyed'                => 'Vehicle Arrested/Destroyed',
        'wooden_boat_speed_boat_arrested_destroyed' => 'Wooden Boat / Speed Boat Arrested/Destroyed',
        'vessel_arrested_destroyed'                 => 'Vessel Arrested/Destroyed',
        'location_coordinate_latitude'              => 'Latitude',
        'location_coordinate_longitude'             => 'Longitude',
        'quantity_of_crude_recovered_destroyed_ltr' => 'Quantity of Crude Recovered/Destroyed (Ltr)',
        'quantity_of_ago_recovered_destroyed_ltr'   => 'Quantity of AGO Recovered/Destroyed (Ltr)',
        'quantity_of_pms_recovered_destroyed_ltr'   => 'Quantity of PMS Recovered/Destroyed (Ltr)',
        'dpk_recovered_destroyed_ltr'               => 'DPK Recovered/Destroyed (Ltr)',
        'illegal_storage_dump_sites'                => 'Illegal Storage/Dump Sites',
        'description_of_reported_incidence'         => 'Description of Reported Incidence',
        'due_date'                                  => 'Due Date',
    ];

    $missing_fields = [];

    foreach ($data as $key => $value) {

        if (in_array($key, $optional_fields, true)) {
            continue;
        }

        if ($value === '') {
            $missing_fields[] = $field_labels[$key] ?? $key;
        }
    }

    if (!empty($missing_fields)) {
        $_SESSION['error'] = 'The following required fields are empty: ' . implode(', ', $missing_fields) . '.';
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email address.';
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }

    if (!is_numeric($data['location_coordinate_latitude']) ||
        $data['location_coordinate_latitude'] < -90 ||
        $data['location_coordinate_latitude'] > 90) {
        $_SESSION['error'] = 'Latitude must be between -90 and 90.';
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }

    if (!is_numeric($data['location_coordinate_longitude']) ||
        $data['location_coordinate_longitude'] < -180 ||
        $data['location_coordinate_longitude'] > 180) {
        $_SESSION['error'] = 'Longitude must be between -180 and 180.';
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }

    $result = $callUserModel->createTicket($data, $_FILES, $userid);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header("Location: index.php?action=tickets");
        exit;
    }

    $_SESSION['error'] = $result['message'];
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit;}





// create request for admin



if (isset($_POST['create_request']) ){
$tb_name = "request";

$priority = trim($_POST['priority'] ?? '');
$subject  = trim($_POST['subject']  ?? '');
$complain = trim($_POST['complain'] ?? '');

if ($priority === '' || $subject === '' || $complain === '') {
    $_SESSION['error'] = 'Priority, subject and complain are required.';
    header('Location: index?action=user_requests');
    exit;
}

if (!in_array($priority, ['0', '1', '2'], true)) {
    $_SESSION['error'] = 'Invalid priority value.';
    header('Location: index?action=user_requests');
    exit;
}



$request_id = 'URQ' . date('YmdHis') . substr((string) microtime(true), -6);

$data = [
    'request_id' => 'RQ' . date('YmdHis') . substr((string) microtime(true), -6) ,
    'requester_id'   => $_SESSION['userid'],
    'requester_name' => $admin_fn,
    'subject'        => $subject,
    'complain'       => $complain,
    'priority'       => (int) $priority,
    'date'           => date('Y-m-d H:i:s'),
    'requester_role' => $_SESSION['role'],
    'status'         => 0,
];

$inserted = $callUserModel->Create_request($data);

if ($inserted) {
    $_SESSION['success'] = 'Request ' . $request_id . ' created successfully.';
} else {
    $_SESSION['error'] = 'Failed to create request. Please try again.';
}

header('Location: index?action=user_requests');
exit;
}









// create user account

if (isset($_POST['create_user_account'])) {
  
 $action_token= trim($_POST['action_token'] ?? '');
 if ($action_token!=$_SESSION['action_token']){
   $_SESSION['error']= "Bots are not allowed";

  header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
 }

 $title= trim($_POST['title'] ?? '');

    $fullname = trim($_POST['name'] ?? '');
    $parts = explode(' ', trim($AbrvName));$first = array_shift($parts);$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';
    $phone    = trim($_POST['phone'] ?? '');
    $receiveraddress =  $email    = trim($_POST['email'] ?? '');
    $role =   trim($_POST['role'] ?? '');
$data = [
        'company_userid' => $company_userid,
        'title'          => trim($_POST['title'] ?? ''),
        'fullname'       => trim($_POST['fullname'] ?? ''),
        'phone'          => trim($_POST['phone'] ?? ''),
        'role'           => trim($_POST['role'] ?? ''),
        'role_name'      => trim($_POST['role'] ?? ''),
        'email'          => trim($_POST['email'] ?? ''),
        'user_corridor'  => trim($_POST['user_corridor'] ?? '')
    ];

$result = $callUserModel-> CreateUserAccount($data) ;

    if (!empty($result['success'])) {

          $userrefid = $result['userid'];

$user_details = $admin_abr . " - " . $_SESSION['userid'];

  $action = "Created a new "  . $role  ." account for " . $_POST['fullname'] ;

   
 $logResult = $callAuthMiddlewareClass->writelog($_SESSION['userid'], $admin_lrn,$admin_lr, $user_details, $action,$company_logfile_url);

       $subject = "Account created successfully" ;             

$message = "Hello $fullname,<br><br>"

         . "Your administrator account has been created successfully.<br><br>"

         . "Your registration has been completed, and your account is now ready for use.<br><br>"

         . "<strong>Reference ID:</strong> $userrefid<br>"

         . "<strong>Default Password:</strong> Your phone number used during registration<br><br>"

         . "Please use your Reference ID and default password to log in to your account. For your security, we strongly recommend changing your default password after your first successful login.<br><br>"

         . "<div style='text-align:center; margin:25px 0;'>"

         . "<a href='$loginurl' style='display:inline-block; padding:12px 25px; background-color:#0d6efd; color:#ffffff; text-decoration:none; border-radius:5px; font-weight:bold;'>"

         . "Login to Your Account"

         . "</a>"

         . "</div>"

         . "If you did not register for this account, please contact the Support Team immediately.<br><br>"

         . "Best regards,<br>"

         . "The Support Team";

      $SendEmail = $CallMailerModel->sendmail($receiveraddress,$subject, $message);
      $_SESSION['success']= "New " . $role. " account created successfully";

  header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;

}  }




//update replies
// ============================================================
// SUBMIT TICKET REPLY  +  UPDATE TICKET PRIORITY & STATUS
// ============================================================
if (isset($_POST['submit_reply'])) {

    $ticketId     = trim($_POST['orig_id']   ?? '');
    $comment      = trim($_POST['message']   ?? '');
    $newStatus    = trim($_POST['submit_as'] ?? '');      // '' means no status change
    $changePrio   = isset($_POST['set_priority']) ? 1 : 0;
    $newPriority  = trim($_POST['priority']  ?? '');
    $noNotify     = isset($_POST['no_notify']) ? 1 : 0;

    if ($ticketId === '' || $comment === '') {
        $_SESSION['error'] = 'Ticket ID and message are required.';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
    }

    // Load the parent ticket so we can fill ticketcreator_userid / ticket_date
    $ticketRows = $callUserModel->GeneralSelectAnyTableWhereColumnValueEquals(
        'ticket_reports', 'ticket_id', $ticketId
    );
    $ticketRow = $ticketRows[0] ?? [];

    if (empty($ticketRow)) {
        $_SESSION['error'] = 'Ticket not found.';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
    }

    /* ---------- Handle attachments (up to 8) ---------- */
    $savedAttachments = [];
    $uploadDir = __DIR__ . '/../views/uploads/attachments/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    if (!empty($_FILES['attachment']['name']) && is_array($_FILES['attachment']['name'])) {
        foreach ($_FILES['attachment']['name'] as $i => $origName) {
            if ($_FILES['attachment']['error'][$i] !== UPLOAD_ERR_OK) continue;
            if ($origName === '') continue;

            $tmp  = $_FILES['attachment']['tmp_name'][$i];
            $size = (int) $_FILES['attachment']['size'][$i];
            if ($size <= 0 || $size > 10 * 1024 * 1024) continue; // 10MB cap

            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
            $safe = preg_replace('/[^A-Za-z0-9._-]/', '_', pathinfo($origName, PATHINFO_FILENAME));
            $newName = $ticketId . '_' . time() . '_' . $i . '_' . $safe . ($ext ? '.' . $ext : '');

            if (move_uploaded_file($tmp, $uploadDir . $newName)) {
                $savedAttachments[] = $newName;
            }
        }
    }

    /* ---------- Build reply row ---------- */
    $now = date('Y-m-d H:i:s');

    $replyData = [
        'ticket_id'            => $ticketId,
        'role'                 => $admin_lrn ?? $_SESSION['role'], // replyer role label
        'replyer_userid'       => $_SESSION['userid'],
        'replyer_name'         => $admin_fn ?? '',
        'ticketcreator_userid' => $ticketRow['ticketcreator_userid'] ?? 0,
        'comment'              => $comment,
        'date'                 => $now,
        'ticket_date'          => $ticketRow['date_created'] ?? '',
        'attachments'          => implode(',', $savedAttachments), // store as comma list
        'status'               => ($newStatus !== '' ? $newStatus : 'replied'),
    ];

    $insertReply = $CallModelAdmin->InsertTicketReply($replyData);

    if (!$insertReply['success']) {
        $_SESSION['error'] = $insertReply['message'];
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
    }

    /* ---------- Update parent ticket (priority + status) ---------- */
    $updateData = [
        'ticket_id'    => $ticketId,
        'date_updated' => $now,
    ];
    if ($changePrio && $newPriority !== '') {
        $updateData['priority'] = $newPriority;
    }
    if ($newStatus !== '') {
        $updateData['status_text'] = $newStatus;
    }

    $updateTicket = $CallModelAdmin->UpdateTicketPriorityAndStatus($updateData);

    if (!$updateTicket['success']) {
        $_SESSION['error'] = 'Reply saved, but ticket update failed: ' . $updateTicket['message'];
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
    }

    /* ---------- Audit log ---------- */
    $user_details = ($admin_abr ?? '') . ' - ' . $_SESSION['userid'];
    $action       = 'Replied to ticket ' . $ticketId
                  . ($newStatus !== '' ? ', status → ' . $newStatus : '')
                  . ($changePrio && $newPriority !== '' ? ', priority → ' . $newPriority : '');

    $callAuthMiddlewareClass->writelog(
        $_SESSION['userid'], $admin_lrn, $admin_lr,
        $user_details, $action, $company_logfile_url
    );

    /* ---------- Optional email notify to reporter ---------- */
    if (!$noNotify && !empty($ticketRow['email']) && filter_var($ticketRow['email'], FILTER_VALIDATE_EMAIL)) {
        $subject = 'Re: Ticket ' . $ticketId . ' - ' . ($ticketRow['subject'] ?? '');
        $message = 'Hello ' . htmlspecialchars($ticketRow['name'] ?? '') . ',<br><br>'
                 . 'A new reply has been added to your ticket.<br><br>'
                 . '<strong>Ticket ID:</strong> ' . htmlspecialchars($ticketId) . '<br>'
                 . '<strong>Reply:</strong><br>' . nl2br(htmlspecialchars($comment)) . '<br><br>'
                 . 'Best regards,<br>The Support Team';
        $CallMailerModel->sendmail($ticketRow['email'], $subject, $message);
    }

    $_SESSION['success'] = 'Reply submitted successfully.';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? ('index.php?action=viewticket&viewtoken=' . base64_encode($ticketId))));
    exit;
}



 if (isset($_POST['dev_update_user'])) {// $callAuthMiddlewareClass->ValidateTurnstile($CF_SecretKey,$CF_VerificationSiteUrl);


    $user_id =  trim($_POST['user_id']) ;
   
       $LoadUsersAndLoginTableForThisUser = $callUserModel->SelectUsersAndLoginTableforOnePersonAfterLogin($user_id);
  $data = [
    'userid'            => trim($_POST['user_id'] ?? ''),
    'title'             => trim($_POST['title'] ?? ''),
    'fullname'          => trim($_POST['fullname'] ?? ''),
    'email'             => trim($_POST['email'] ?? ''),
    'phone'             => trim($_POST['phone'] ?? ''),
    'corridor'          => trim($_POST['corridor'] ?? ''),
    'msg_notification'  => $_POST['msg_notification'] ?? '',
    'msg'               => trim($_POST['msg'] ?? ''),
   
    'role'              => trim($_POST['role'] ?? ''),
    'Role_edit_user'    => $_POST['Role_edit_user'] ?? '',
    'Role_create_user'  => $_POST['Role_create_user'] ?? '',
    'Role_delete_user'  => $_POST['Role_delete_user'] ?? '',
    'Role_approve_user' => $_POST['Role_approve_user'] ?? '',
    'Role_create_report'=> $_POST['Role_create_report'] ?? '',
    'Role_approve_report'=> $_POST['Role_approve_report'] ?? '',
    'Role_edit_report'  => $_POST['Role_edit_report'] ?? '',
    'Role_delete_report'=> $_POST['Role_delete_report'] ?? '',
    'Role_comment'      => $_POST['Role_comment'] ?? '',
    'status'            => $_POST['status'] ?? '',
    'user_image'        => ''
];

/*
|--------------------------------------------------------------------------
| Fields that are allowed to be empty
|--------------------------------------------------------------------------
| 'msg'      -> optional by design
| 'corridor' -> now allowed to be empty
*/
$optional_fields = ['msg', 'corridor', 'user_image'];

foreach ($data as $key => $value) {

    if (in_array($key, $optional_fields, true)) {
        continue;
    }

    if ($value === '') {
        $_SESSION['error'] = 'All fields are required.';
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }
}

    if (
        isset($_FILES['user_image']) &&
        $_FILES['user_image']['error'] === UPLOAD_ERR_OK
    ) {

        $image = $_FILES['user_image'];

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/webp'
        ];

        if (!in_array($image['type'], $allowedTypes, true)) {
            $_SESSION['error'] = 'Invalid image format.';
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
            exit;
        }

        $extension = strtolower(
            pathinfo($image['name'], PATHINFO_EXTENSION)
        );

        $imageName = $data['userid'] . '_' . time() . '.' . $extension;

        $uploadDirectory = __DIR__ . '/../views/uploads/img/profile/';

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        if (!move_uploaded_file(
            $image['tmp_name'],
            $uploadDirectory . $imageName
        )) {
            $_SESSION['error'] = 'Unable to upload user image.';
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
            exit;
        }

        $data['user_image'] = $imageName;
    }

    $result = $callUserModel->UpdateUserAccount($data);

    if ($result) {
        $_SESSION['success'] = 'User information updated successfully.';
        header("Location: index.php?action=manage_users");exit;

    } else {
        $_SESSION['error'] = 'Unable to update user information.';

        if (
            isset($imageName) &&
            isset($uploadDirectory) &&
            file_exists($uploadDirectory . $imageName)
        ) {
            unlink($uploadDirectory . $imageName);
        }
    }

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));exit;}


       require ROOT_PATH . "/views/users/admin/dashboard.php";
  
  }














 









public function page_viewlog() {
  if (session_status() === PHP_SESSION_NONE) session_start();

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

         $company_url = $company_settings['company_url'] ?? '';

            $loginurl = $company_url."/index.php?action=login" ;



if (file_exists($company_logfile_url)) {
    $logcontent = file_get_contents($company_logfile_url);
 } else {
 $_SESSION['error'] = "Log file is currently unavailable";
 header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;  
}


//    $_SESSION['msg']  = "";

//     $_SESSION['msg_notification']=0;

  $userid =$_SESSION['userid']; 

   $callUserModel = new User();

    $CallDevModel = new ModelDev;

   $LoadUsersAndLoginTable = $callUserModel->SelectUsersAndLoginTable($userid);

      $callAuthMiddlewareClass = new AuthMiddleware;

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

  $page_name = "log file";

  $role_name = $role = $_SESSION['role'] ;

$result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);

if ($result['success']) {

    $user = $result['user'];

    $role_name = $user['role_name'];

}



     require ROOT_PATH . "/views/users/dev/viewlogfile.php";

  }




public function EraseRecord()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $CallDevModel = new ModelDev;

    $table_name_token = $_GET['tb'] ?? '';
    $sn_token = $_GET['sn'] ?? '';

    if ($table_name_token === '' || $sn_token === '') {

        $_SESSION['error'] = "Invalid delete request";

        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }

    $result = $CallDevModel->EraseRecord(
        $table_name_token,
        $sn_token
    );

    if ($result === true) {

        $_SESSION['success'] = "Record deleted successfully";

    } else {

        $_SESSION['error'] = $result;

    }

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit;
}



public function clearlog(){
  if (isset($_POST['clear_log'])) {
          $callCompanyModel = new CompanyModel() ;
             $callAuthMiddlewareClass = new AuthMiddleware;
             $callUserModel = new User;
$CallDevModel = new ModelDev;
      $company_settings = $callCompanyModel ->web_settings();
      $CF_VerificationSiteUrl = $company_settings['cloudfare_verifyurl'] ?? '';
        $CF_SecretKey = $company_settings['cloudfare_secretkey'] ?? '';
        $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';
        // $callAuthMiddlewareClass->ValidateTurnstile($CF_SecretKey,$CF_VerificationSiteUrl);

      $company_logfile_url  = $company_settings['company_logfile_url'] ;

        $userid = trim($_POST['userid'] ?? '');
        $role_name = $role = $_SESSION['role'] ;
 $result = $callUserModel->SelectUserTableForOne($userid);

        if ($result['success']) {
 $user = $result['user'];
            $AbrvName = $user['fullname'];
            $parts = explode(' ', trim($AbrvName));

$first = array_shift($parts);

$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';

        }


        $password = trim($_POST['password'] ?? '');


  $action = "Cleared all users Logfile and Audit trail";

   $user_details = $AbrvName . "  " . $userid;

       $subject = "Cleared user Log file and Audit Trail" ;   


        if ($userid === '' || $password === '') {
            $_SESSION['error'] = "Password is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $result = $CallDevModel->clearlog(
            $userid,
            $password,
            $company_logfile_url
        );

        if ($result === "Audit trail cleared successfully.") {
            $_SESSION['success'] = $result;
             $logResult = $callAuthMiddlewareClass->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);

        } else {
            $_SESSION['error'] = $result;
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }else{

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
    }
}





























public function delete_user() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $callUserModel = new User();
    $callAuthMiddlewareClass = new AuthMiddleware;
    $callAuthMiddlewareClass->IfSessionDeactiveAutologout();
$token = '';
if (isset($_GET['token'])) {
    $token = $_GET['token'] ?? '';
     if ((!$token) || ($token == "")) {
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
    }


   

    $user_sn_encrypted   = $_GET['user_sn']   ?? '';
    $login_sn_encrypted  = $_GET['login_sn']  ?? '';
    $users_column_name   = $_GET['users_column'] ?? '';
    $login_column_name   = $_GET['login_column'] ?? '';

    $user_sn  = (int) base64_decode($user_sn_encrypted);
    $login_sn = (int) base64_decode($login_sn_encrypted);
    $users_column_name = base64_decode($users_column_name);
    $login_column_name = base64_decode($login_column_name);

    if ($login_sn <= 0 || $user_sn <= 0) {
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
    }

    $column_name  = "status";
    $column_value = -1;
    $where_column = "sn";

    $data = [
        'the_tablename' => $login_column_name,
        'column_value'  => $column_value,
        'column_name'   => $column_name,
        'where_column'  => $where_column,
        'where_value'   => $login_sn
    ];

    $delete_UserInLogin = $callUserModel->GeneralUpdateAnyTableColumnWithThisValue($data);

    if ($delete_UserInLogin) {

        $data = [
            'the_tablename' => $users_column_name,
            'column_value'  => $column_value,
            'column_name'   => $column_name,
            'where_column'  => $where_column,
            'where_value'   => $user_sn
        ];

        $delete_UserInUsers = $callUserModel->GeneralUpdateAnyTableColumnWithThisValue($data);

        $_SESSION['success'] = "Record deleted successfully";
    }

    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php')); exit;

}
    

}

}




