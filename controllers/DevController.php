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







public function updateCompanyDetails(): array{

    $CallDevModel = new ModelDev();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        $_SESSION['error'] = 'Invalid request method.';

        header("Location: index?action=settings");

        exit;

    }

    $data = [

        'company_url' => trim($_POST['company_url'] ?? ''),

        'company_logfile_url' => trim($_POST['company_logfile_url'] ?? ''),

        'company_userid' => $_POST['company_userid'] ?? '',

        'company_signup' => $_POST['company_signup'] ?? 0,

        'company_status' => $_POST['company_status'] ?? 0,

        'company_acct_approval' => $_POST['company_acct_approval'] ?? 0,

        'company_auto_ticketing' => $_POST['company_auto_ticketing'] ?? 0,

        'company_map' => trim($_POST['company_map'] ?? ''),

        'company_name' => trim($_POST['company_name'] ?? ''),

        'company_alias' => trim($_POST['company_alias'] ?? ''),

        'company_email' => trim($_POST['company_email'] ?? ''),

        'company_phone' => trim($_POST['company_phone'] ?? ''),

        'company_phone2' => trim($_POST['company_phone2'] ?? ''),

        'company_address' => trim($_POST['company_address'] ?? ''),

        'company_address2' => trim($_POST['company_address2'] ?? ''),

        'company_care' => trim($_POST['company_care'] ?? ''),

        'company_care2' => trim($_POST['company_care2'] ?? ''),

        'company_copyright' => trim($_POST['company_copyright'] ?? ''),

        'company_copyrightlink' => trim($_POST['company_copyrightlink'] ?? ''),

        'company_poweredby' => trim($_POST['company_poweredby'] ?? ''),

        'company_logo' => null,

        'company_favicon' => null

    ];

    if (

        empty($data['company_url']) ||

        !filter_var($data['company_url'], FILTER_VALIDATE_URL) ||

        !preg_match('/^https?:\/\//i', $data['company_url'])

    ) {

        $_SESSION['error'] = 'Invalid company URL.';

        header("Location: index?action=settings");

        exit;

    }

    if (

        $data['company_userid'] === '' ||

        !ctype_digit((string) $data['company_userid'])

    ) {

        $_SESSION['error'] = 'Invalid company user ID.';

        header("Location: index?action=settings");

        exit;

    }

    $data['company_userid'] = (int) $data['company_userid'];

    if ($data['company_userid'] > 2147483647) {

        $_SESSION['error'] = 'Invalid company user ID.';

        header("Location: index?action=settings");

        exit;

    }

    $booleanFields = [

        'company_signup',

        'company_status',

        'company_acct_approval',

        'company_auto_ticketing'

    ];

    foreach ($booleanFields as $field) {

        if (!in_array((string) $data[$field], ['0', '1'], true)) {

            $_SESSION['error'] = 'Invalid value supplied for ' . $field . '.';

            header("Location: index?action=settings");

            exit;

        }

        $data[$field] = (int) $data[$field];

    }

    if (

        empty($data['company_email']) ||

        !filter_var($data['company_email'], FILTER_VALIDATE_EMAIL)

    ) {

        $_SESSION['error'] = 'Invalid company email address.';

        header("Location: index?action=settings");

        exit;

    }

    if (

        empty($data['company_phone']) ||

        !preg_match('/^\+?[0-9]{7,15}$/', $data['company_phone'])

    ) {

        $_SESSION['error'] = 'Invalid company phone number.';

        header("Location: index?action=settings");

        exit;

    }

    if (

        $data['company_phone2'] !== '' &&

        !preg_match('/^\+?[0-9]{7,15}$/', $data['company_phone2'])

    ) {

        $_SESSION['error'] = 'Invalid alternative phone number.';

        header("Location: index?action=settings");

        exit;

    }

    if (

        $data['company_copyrightlink'] !== '' &&

        (

            !filter_var(

                $data['company_copyrightlink'],

                FILTER_VALIDATE_URL

            ) ||

            !preg_match(

                '/^https?:\/\//i',

                $data['company_copyrightlink']

            )

        )

    ) {

        $_SESSION['error'] = 'Invalid copyright link.';

        header("Location: index?action=settings");

        exit;

    }

    /*

     * COMPANY LOGO

     */

    if (

        isset($_FILES['user_image']) &&

        $_FILES['user_image']['error'] !== UPLOAD_ERR_NO_FILE

    ) {

        if ($_FILES['user_image']['error'] !== UPLOAD_ERR_OK) {

            $_SESSION['error'] = 'Failed to upload company logo.';

            header("Location: index?action=settings");

            exit;

        }

        if ($_FILES['user_image']['size'] > 2 * 1024 * 1024) {

            $_SESSION['error'] = 'Company logo must not exceed 2MB.';

            header("Location: index?action=settings");

            exit;

        }

        $allowedLogoTypes = [

            'image/png' => 'png',

            'image/jpeg' => 'jpg',

            'image/webp' => 'webp'

        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $mimeType = $finfo->file(

            $_FILES['user_image']['tmp_name']

        );

        if (!isset($allowedLogoTypes[$mimeType])) {

            $_SESSION['error'] = 'Invalid company logo file type.';

            header("Location: index?action=settings");

            exit;

        }

        $uploadDirectory = __DIR__ . '/../views/uploads/img/';

        if (!is_dir($uploadDirectory)) {

            if (!mkdir($uploadDirectory, 0755, true)) {

                $_SESSION['error'] = 'Unable to create logo upload directory.';

                header("Location: index?action=settings");

                exit;

            }

        }

        try {

            $logoName =

                'company_logo_' .

                bin2hex(random_bytes(8)) .

                '.' .

                $allowedLogoTypes[$mimeType];

        } catch (Exception $e) {

            $_SESSION['error'] = 'Unable to generate logo filename.';

            header("Location: index?action=settings");

            exit;

        }

        $logoPath = $uploadDirectory . $logoName;

        if (

            !move_uploaded_file(

                $_FILES['user_image']['tmp_name'],

                $logoPath

            )

        ) {

            $_SESSION['error'] = 'Unable to save company logo.';

            header("Location: index?action=settings");

            exit;

        }

        $data['company_logo'] = $logoName;

    }

    /*

     * FAVICON

     */

    if (

        isset($_FILES['favicon_image']) &&

        $_FILES['favicon_image']['error'] !== UPLOAD_ERR_NO_FILE

    ) {

        if ($_FILES['favicon_image']['error'] !== UPLOAD_ERR_OK) {

            $_SESSION['error'] = 'Failed to upload favicon.';

            header("Location: index?action=settings");

            exit;

        }

        if ($_FILES['favicon_image']['size'] > 1 * 1024 * 1024) {

            $_SESSION['error'] = 'Favicon must not exceed 1MB.';

            header("Location: index?action=settings");

            exit;

        }

        $allowedFaviconTypes = [

            'image/png' => 'png',

            'image/x-icon' => 'ico',

            'image/vnd.microsoft.icon' => 'ico',

            'image/jpeg' => 'jpg',

            'image/webp' => 'webp'

        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $mimeType = $finfo->file(

            $_FILES['favicon_image']['tmp_name']

        );

        if (!isset($allowedFaviconTypes[$mimeType])) {

            $_SESSION['error'] = 'Invalid favicon file type.';

            header("Location: index?action=settings");

            exit;

        }

        $uploadDirectory = __DIR__ . '/../views/uploads/img/';

        if (!is_dir($uploadDirectory)) {

            if (!mkdir($uploadDirectory, 0755, true)) {

                $_SESSION['error'] = 'Unable to create favicon upload directory.';

                header("Location: index?action=settings");

                exit;

            }

        }

        try {

            $faviconName =

                'favicon_' .

                bin2hex(random_bytes(8)) .

                '.' .

                $allowedFaviconTypes[$mimeType];

        } catch (Exception $e) {

            $_SESSION['error'] = 'Unable to generate favicon filename.';

            header("Location: index?action=settings");

            exit;

        }

        $faviconPath = $uploadDirectory . $faviconName;

        if (

            !move_uploaded_file(

                $_FILES['favicon_image']['tmp_name'],

                $faviconPath

            )

        ) {

            $_SESSION['error'] = 'Unable to save favicon.';

            header("Location: index?action=settings");

            exit;

        }

        $data['company_favicon'] = $faviconName;

    }

    $result = $CallDevModel->updateCompanyDetails($data);

    if (

        isset($result['success']) &&

        $result['success'] === true

    ) {

        $_SESSION['success'] = $result['message'];

        unset($_SESSION['error']);

    } else {

        $_SESSION['error'] =

            $result['message'] ??

            'Failed to update company details.';

        unset($_SESSION['success']);

    }

    header("Location: index?action=settings");

    exit;

}





public function updateMailerDetails(): array

{

    $CallDevModel = new ModelDev();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        $_SESSION['error'] = 'Invalid request method.';

        header("Location: index?action=settings");

        exit;

    }

    $data = [

        'company_mailer_host' => trim(

            $_POST['company_mailer_host'] ?? ''

        ),

        'company_mailer_email' => trim(

            $_POST['company_mailer_email'] ?? ''

        ),

        'company_mailer_port' => trim(

            $_POST['company_mailer_port'] ?? ''

        ),

        'company_mailer_password' => $_POST['company_mailer_password'] ?? '',

        'company_mailer_secure' => strtolower(

            trim($_POST['company_mailer_secure'] ?? '')

        ),

        'company_banner' => trim(

            $_POST['company_banner_text'] ?? ''

        )

    ];

    if (

        isset($_FILES['company_banner']) &&

        $_FILES['company_banner']['error'] === UPLOAD_ERR_OK

    ) {

        $banner = $_FILES['company_banner'];

        $allowedTypes = [

            'image/png',

            'image/jpeg',

            'image/webp'

        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $mimeType = finfo_file($finfo, $banner['tmp_name']);

        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes, true)) {

            $_SESSION['error'] = 'Invalid banner file. Please select a PNG, JPG, JPEG or WEBP image.';

            header("Location: index?action=settings");

            exit;

        }

        $imageSize = getimagesize($banner['tmp_name']);

        if (

            $imageSize === false ||

            $imageSize[0] !== 1400 ||

            $imageSize[1] !== 370

        ) {

            $_SESSION['error'] = 'Invalid banner dimensions. Please select an image exactly 1400px X 370px.';

            header("Location: index?action=settings");

            exit;

        }

        $extension = strtolower(

            pathinfo($banner['name'], PATHINFO_EXTENSION)

        );

        $bannerName = 'banner.' . $extension;

        $uploadDirectory = __DIR__ . '/../views/uploads/img/';

        if (!is_dir($uploadDirectory)) {

            mkdir($uploadDirectory, 0755, true);

        }

        if (!move_uploaded_file(

            $banner['tmp_name'],

            $uploadDirectory . $bannerName

        )) {

            $_SESSION['error'] = 'Failed to upload mail banner.';

            header("Location: index?action=settings");

            exit;

        }

        $data['company_banner'] = $bannerName;

    }

    if ($data['company_mailer_host'] === '') {

        $_SESSION['error'] = 'Mailer host is required.';

        header("Location: index?action=settings");

        exit;

    }

    if (

        !filter_var(

            $data['company_mailer_email'],

            FILTER_VALIDATE_EMAIL

        )

    ) {

        $_SESSION['error'] = 'Invalid mailer email address.';

        header("Location: index?action=settings");

        exit;

    }

    if (

        !ctype_digit((string)$data['company_mailer_port']) ||

        (int)$data['company_mailer_port'] < 1 ||

        (int)$data['company_mailer_port'] > 65535

    ) {

        $_SESSION['error'] = 'Invalid mailer port.';

        header("Location: index?action=settings");

        exit;

    }

    if ($data['company_mailer_password'] === '') {

        $_SESSION['error'] = 'Mailer password is required.';

        header("Location: index?action=settings");

        exit;

    }

    if (

        $data['company_mailer_secure'] !== 'tls' &&

        $data['company_mailer_secure'] !== 'ssl'

    ) {

        $_SESSION['error'] = 'Mailer security must be TLS or SSL.';

        header("Location: index?action=settings");

        exit;

    }

    $result = $CallDevModel->updateMailerDetails($data);

    if ($result['success'] === true) {

        $_SESSION['success'] = $result['message'];

        unset($_SESSION['error']);

    } else {

        $_SESSION['error'] = $result['message'];

        unset($_SESSION['success']);

    }

    header("Location: index?action=settings");

    exit;

}


public function viewlog() {
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

     $CallMailerModel = new Mailer;



 $LoadUsersAndRequestTable  = $CallDevModel->SelectUsersAndrequestTable();





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

   $user_details = $AbrvName . " - " . $userid;

  $role_name = $role = $_SESSION['role'] ;

$result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);

if ($result['success']) {

    $user = $result['user'];

    $role_name = $user['role_name'];



}

     $callCompanyModel = new CompanyModel() ;

      $company_settings = $callCompanyModel ->web_settings();
     $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';

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

        $loginurl = $company_settings['company_url'] ."/index.php?action=login" ;



if (isset($_POST['requestreply'])) {

    // Check that ALL required fields were posted

    $requiredFields = [

        'sn',

        'table_name',

        'ticketer_email',

        'ticket_no',

        'ticketer_name',

        'ticket_status',

        'status'

    ];

    $allPosted = true;

    foreach ($requiredFields as $field) {

        if (!isset($_POST[$field]) || $_POST[$field] === '') {

            $allPosted = false;

            break;

        }

    }

    if (!$allPosted) {

       $_SESSION['error'] = "Error receiving the fields, please try again";

 header("Location: index?action=totalrequest");

 exit;

    } else {

  // Get posted values

        $ticketer_email = $_POST['ticketer_email'];

        $ticket_no      = $_POST['ticket_no'];
        $ticket_new_status      = $_POST['status'];
        

if ($ticket_new_status == 0) {

    $ticket_status_text = "NEW";

} elseif ($ticket_new_status == 1) {

    $ticket_status_text = "OPENED";

} elseif ($ticket_new_status == 2) {

    $ticket_status_text = "IN PROGRESS";

} elseif ($ticket_new_status == 3) {

    $ticket_status_text = "REPLIED";

} elseif ($ticket_new_status == 4) {

    $ticket_status_text = "RESOLVED";

}


        $ticketer_name  = $_POST['ticketer_name'];

               // All fields are posted, execute model

        $result = $CallDevModel->requestReply($_POST);

        if ($result) {

            $_SESSION['success'] = "Updated successfully";

$action = "Updated ticket ". $ticketer_name . " - " . $ticket_no ;

$logResult = $callAuthMiddlewareClass->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);

$subject = "Ticket complain updated" ;             

$message = "Hello $ticketer_name,<br><br>"

         . "There has been an update regarding your complaint.<br><br>"

         . "<strong>Complaint ID:</strong> $ticket_no<br>"

         . "<strong>New Status:</strong>$ticket_status_text<br>"

         . "<strong>Email:</strong> $ticketer_email<br><br>"

         . "Our Support Team has reviewed your complaint and there is a new update available. "

         . "Please log in to your account to view the latest information and any further instructions regarding your complaint.<br><br>"

         . "<div style='text-align:center; margin:25px 0;'>"

         . "<a href='$loginurl' style='display:inline-block; padding:12px 25px; background-color:#0d6efd; color:#ffffff; text-decoration:none; border-radius:5px; font-weight:bold;'>"

         . "View Complaint Update"

         . "</a>"

         . "</div>"

         . "If you have any questions or require further assistance, please contact the Support Team and reference your Complaint ID: <strong>$ticket_no</strong>.<br><br>"

         . "Best regards,<br>"

         . "The Support Team";



      $SendEmail = $CallMailerModel->sendmail(

                        $ticketer_email,

                        $subject,

                        $message

                    );

 header("Location: index?action=totalrequest");

 exit;

        } else {

           $_SESSION['error'] ="Model was executed, but the update failed.";

 header("Location: index?action=totalrequest");

 exit;

        }

    }

}





 $page_name = "total request";

       require ROOT_PATH . "/views/users/dev/totalrequest.php";

 }






public function edit_user(){  
  if (session_status() === PHP_SESSION_NONE) session_start();
  $token = $_GET['token'] ?? '';
    $user_id = base64_decode($token, true);
    $userid =$_SESSION['userid']; 

   $callUserModel = new User();
$callAuthMiddlewareClass = new AuthMiddleware;
    $CallDevModel = new ModelDev;

//Update user record code starts here
if (isset($_POST['dev_update_user'])) {
    $user_id =  trim($_POST['user_id']) ;
       $LoadUsersAndLoginTableForThisUser = $callUserModel->SelectUsersAndLoginTableforOnePerson($user_id);
    $data = [
        'userid' => trim($_POST['user_id'] ?? ''),
        'title' => trim($_POST['title'] ?? ''),
        'fullname' => trim($_POST['fullname'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'msg_notification' => $_POST['msg_notification'] ?? '',
        'msg' => trim($_POST['msg'] ?? ''),
        'role' => trim($_POST['role'] ?? ''),
        'Role_edit_user' => $_POST['Role_edit_user'] ?? '',
        'Role_create_user' => $_POST['Role_create_user'] ?? '',
        'Role_delete_user' => $_POST['Role_delete_user'] ?? '',
        'Role_approve_user' => $_POST['Role_approve_user'] ?? '',
        'Role_create_report' => $_POST['Role_create_report'] ?? '',
        'Role_approve_report' => $_POST['Role_approve_report'] ?? '',
        'Role_edit_report' => $_POST['Role_edit_report'] ?? '',
        'Role_delete_report' => $_POST['Role_delete_report'] ?? '',
        'Role_comment' => $_POST['Role_comment'] ?? '',
        'status' => $_POST['status'] ?? ''
    ];

    foreach ($data as $key => $value) {
        if ($key === 'msg') {
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

    $result = $CallDevModel->UpdateUserAccount($data);

    if ($result) {
        $_SESSION['success'] = 'User information updated successfully.';
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

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit;
}

//code ends here


  if ($user_id === false || $user_id === '') {
    $_SESSION['error'] = "Invalid token";
    // header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    // exit;
}


//    $_SESSION['msg']  = "";

//     $_SESSION['msg_notification']=0;

  

$result = $callUserModel->SelectUsersAndLoginTableforOnePerson($user_id);


//  $result = $callUserModel->SelectUsersAndLoginTableforOnePerson($user_id);

        if ($result['success']) {

            $user = $result['user'];

            $LoadUsersAndLoginTable = [$user];

            $AbrvName = $user['user_fullname'];

            if ($user['user_msg_notification']==1){

                $_SESSION['msg_notification'] = 1;

                 $_SESSION['msg'] = $user['user_msg'];

              $callUserModel->clearMsgNotification($userid);

            }



     $user_image = ($user['user_image'] ?? "") === "" ? "noimage2.png" : $user['user_image'];

        } else {

            echo $result['error'];

        }

$parts = explode(' ', trim($AbrvName));

$first = array_shift($parts);

$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';

  $role_name = $role = $_SESSION['role'] ;

$result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);

if ($result['success']) {

    $user = $result['user'];

    $role_name = $user['role_name'];



}

     $callCompanyModel = new CompanyModel() ;

      $company_settings = $callCompanyModel ->web_settings();
          $company_logfile_url  = $company_settings['company_logfile_url'] ;

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


        $page_name = "Manage user";

       require ROOT_PATH . "/views/users/dev/manage_user.php";

  }









public function dashboard() {

  if (session_status() === PHP_SESSION_NONE) session_start();

//    $_SESSION['msg']  = "";

//     $_SESSION['msg_notification']=0;

  $userid =$_SESSION['userid']; 

   $callUserModel = new User();

    $CallDevModel = new ModelDev;

   $LoadUsersAndLoginTableForAdmin = $callUserModel->SelectUsersAndLoginTable($userid);

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
       $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';

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



       require ROOT_PATH . "/views/users/dev/dashboard.php";

  }


































public function create_admin_user() {

if (isset($_POST['dev_create_admin'])) {
 if (session_status() === PHP_SESSION_NONE) session_start();
   $userid =$_SESSION['userid']; 
  $callUserModel = new User();
    $callAuthMiddlewareClass = new AuthMiddleware;
    $CallMailerModel = new Mailer;
    $CallDevModel = new ModelDev;
 $role_name = $role = $_SESSION['role'] ;
 

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
//    $_SESSION['msg']  = "";

//     $_SESSION['msg_notification']=0;

 $result = $callUserModel->SelectUserTableForOne($userid);

        if ($result['success']) {

            $user = $result['user'];

            $AbrvName = $user['fullname'];
  
        }
    

   $LoadUsersAndLoginTableForAdmin = $callUserModel->SelectUsersAndLoginTable($userid);

    

    $title= trim($_POST['title'] ?? '');

    $fullname = trim($_POST['name'] ?? '');
    $parts = explode(' ', trim($AbrvName));

$first = array_shift($parts);

$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';


    $phone    = trim($_POST['phone'] ?? '');

   $receiveraddress =  $email    = trim($_POST['email'] ?? '');

    

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

          $userrefid = $result['userid'];

    //    $generatedPassword = $result['phone'];

    $_SESSION['success'] = "Created successfully" ;

  $user_details = $AbrvName . " - " . $userid;

  $action = "Created new administrator";

   $user_details = $AbrvName . "  " . $userid;

 $logResult = $callAuthMiddlewareClass->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);

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

      $SendEmail = $CallMailerModel->sendmail(

                        $receiveraddress,

                        $subject,

                        $message

                    );



  header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;

        // Successfully created

    } else {

        if (!empty($result['phone_exists'])) {

            $_SESSION['error'] = "Phone number already exists.";
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;

        } elseif (!empty($result['email_exists'])) {

            $_SESSION['error'] = "Email address already exists.";
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
        } else {

            $_SESSION['error'] = $result['error'];
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
        }

    }



}

}






public function users() {

  if (session_status() === PHP_SESSION_NONE) session_start();

//    $_SESSION['msg']  = "";

//     $_SESSION['msg_notification']=0;

  $userid =$_SESSION['userid']; 

   $callUserModel = new User();

    $CallDevModel = new ModelDev;

   $LoadUsersAndLoginTableForAdmin = $callUserModel->SelectUsersAndLoginTable($userid);

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

  $role_name = $role = $_SESSION['role'] ;

$result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);

if ($result['success']) {

    $user = $result['user'];

    $role_name = $user['role_name'];



}

     $callCompanyModel = new CompanyModel() ;

      $company_settings = $callCompanyModel ->web_settings();
      $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';

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



        $page_name = "users";

       require ROOT_PATH . "/views/users/dev/users.php";

  }




public function corridorsAndItlikes() {

  if (session_status() === PHP_SESSION_NONE) session_start();
  
   $page_name = $tb_name = $_GET['action'] ?? '';
    if ($tb_name==""){
header('Location: index.php');
 exit;

    }



if ($tb_name == "corridors") {
       $page_name = $tb_name = "corridor";
     } elseif ($tb_name == "owners") {
    $tb_name = $page_name = "owner";
} elseif ($tb_name == "incidence_source") {
    $page_name = "Incidence Source";
} elseif ($tb_name == "operator") {
    $page_name = "operator";
} elseif ($tb_name == "report_types") {
      $page_name = "report types";
    $tb_name = "report_type";
  
} elseif ($tb_name == "wellhead_status") {
    $page_name = "wellhead status";
} elseif ($tb_name == "priority") {
    $page_name = "priority";

} elseif ($tb_name == "zones") {
    $tb_name = $page_name = "zone";
} elseif ($tb_name == "pipelines") {
    $tb_name = $page_name = "pipeline";
} elseif ($tb_name == "pipeline_types") {
   $page_name = "pipeline type";
    $tb_name = "pipeline_type";
}

    

//    $_SESSION['msg']  = "";

//     $_SESSION['msg_notification']=0;

  $userid =$_SESSION['userid']; 

   $callUserModel = new User();

    $CallDevModel = new ModelDev;

   $LoadUsersAndLoginTableForAdmin = $callUserModel->SelectUsersAndLoginTable($userid);

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

  $role_name = $role = $_SESSION['role'] ;

$result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);

if ($result['success']) {

    $user = $result['user'];

    $role_name = $user['role_name'];



}

     $callCompanyModel = new CompanyModel() ;
     $CallMailerModel = new Mailer() ;

      $company_settings = $callCompanyModel ->web_settings();
      $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';

      $ticketer_email  = $company_settings['company_email'] ;
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


if (isset($_POST['create_corridor'])) {
   $the_tb= trim($_POST['tb'] ?? '');
   $corridor_name= trim($_POST['corridor_name'] ?? '');
   $corridor_name = trim($_POST['corridor_name'] ?? ''); if ($corridor_name === '') { $_SESSION['error'] = 'Corridor name is required'; header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit; }
   $create_corridors_result = $CallDevModel->CreateCorridorAndThoseSimilar($corridor_name, $userid,$role,$the_tb);

if ($create_corridors_result['status']) {
 $action = "Created a new " . $page_name . " module";
   $user_details = $AbrvName . "  " . $userid;
 $logResult = $callAuthMiddlewareClass->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);
    $_SESSION['success'] = $create_corridors_result['message'];
     $subject = "New web application module" ;
$message = "Dear Team,<br><br>"
 . "We are pleased to inform you that, as requested, a new <strong>$page_name</strong> module (<strong>$corridor_name</strong>) has been added to the web application to further improve the platform and enhance its functionality.<br><br>"

 . "The new module has been integrated into the ticket creation page to provide additional functionality and improve the efficiency of our existing processes.<br><br>"

 . "When creating a new ticket, reporters will now find a new <strong>$page_name</strong> option within the available listings, allowing them to select the appropriate option when submitting a ticket.<br><br>"

 . "<div style='text-align:center; margin:25px 0;'>"

 . "<a href='$loginurl' style='display:inline-block; padding:12px 25px; background-color:#0d6efd; color:#ffffff; text-decoration:none; border-radius:5px; font-weight:bold;'>"

 . "Access Web Application"

 . "</a>"

 . "</div>"

 . "We encourage everyone to make use of the new module and provide feedback where necessary as we continue to improve the system and its functionality.<br><br>"

 . "For any questions, clarification, or technical assistance, please contact the Support Team.<br><br>"

 . "Best regards,<br>"

 . "The I.T Support Team";


 $SendEmail = $CallMailerModel->sendmail(

                        $ticketer_email,

                        $subject,

                        $message

                    );





header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
} else {

    $_SESSION['error'] = $create_corridors_result['message'];
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php')); exit;
}
}
// $table_name = "corridor";





$LoadCorridorsAndItLikes = $CallDevModel->SelectCorridorsAndThoseSimilar($tb_name);
       require ROOT_PATH . "/views/users/dev/corridors.php";

  }













































public function settings() {

  if (session_status() === PHP_SESSION_NONE) session_start();

  $callCompanyModel = new CompanyModel() ;

      $company_settings = $callCompanyModel ->web_settings();

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

  $page_name = "settings";

  $role_name = $role = $_SESSION['role'] ;

$result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);

if ($result['success']) {

    $user = $result['user'];

    $role_name = $user['role_name'];

}


  $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';
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



       require ROOT_PATH . "/views/users/dev/settings.php";

  }



}