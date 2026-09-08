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
    
 


public function updateCompanyDetails(): array
{
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
 $page_name = "total request";
       require ROOT_PATH . "/views/users/dev/totalrequest.php";
  
  }



public function dashboard() {
  if (session_status() === PHP_SESSION_NONE) session_start();
//    $_SESSION['msg']  = "";
//     $_SESSION['msg_notification']=0;
  $userid =$_SESSION['userid']; 
   $callUserModel = new User();
    $CallDevModel = new ModelDev;
   $LoadUsersAndLoginTable = $callUserModel->SelectUsersAndLoginTable($userid);
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
         $company_url = $company_settings['company_url'] ?? '';
            $loginurl = $company_url."/index.php?action=login" ;

if (isset($_POST['dev_create_admin'])) {
    $CallMailerModel = new Mailer;
    $title= trim($_POST['title'] ?? '');
    $fullname = trim($_POST['name'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
   $receiveraddress =  $email    = trim($_POST['email'] ?? '');
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

    
     header("Location: index?action=dashboard");
            exit;
        // Successfully created

    } else {

        $_SESSION['error']= $result['error'];

    }
}

       require ROOT_PATH . "/views/users/dev/dashboard.php";
  
  }





















public function users() {
  if (session_status() === PHP_SESSION_NONE) session_start();

//    $_SESSION['msg']  = "";
//     $_SESSION['msg_notification']=0;
  $userid =$_SESSION['userid']; 
   $callUserModel = new User();
    $CallDevModel = new ModelDev;
   $LoadUsersAndLoginTable = $callUserModel->SelectUsersAndLoginTable($userid);
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

if (isset($_POST['dev_create_admin'])) {
    $CallMailerModel = new Mailer;
    $title= trim($_POST['title'] ?? '');
    $fullname = trim($_POST['name'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
   $receiveraddress =  $email    = trim($_POST['email'] ?? '');
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

    
     header("Location: index?action=users");
            exit;
        // Successfully created

    } else {

        $_SESSION['error']= $result['error'];

    }
}
        $page_name = "users";
       require ROOT_PATH . "/views/users/dev/users.php";
  
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

if (isset($_POST['dev_create_admin'])) {
    $CallMailerModel = new Mailer;
    $title= trim($_POST['title'] ?? '');
    $fullname = trim($_POST['name'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
   $receiveraddress =  $email    = trim($_POST['email'] ?? '');
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

    
     header("Location: index?action=settings");
            exit;
        // Successfully created

    } else {

        $_SESSION['error']= $result['error'];

    }
}

       require ROOT_PATH . "/views/users/dev/settings.php";
  
  }


}