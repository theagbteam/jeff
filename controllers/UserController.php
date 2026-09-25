
<?php

require_once ROOT_PATH . '/models/company.php';

require_once ROOT_PATH . '/models/User.php';

require_once ROOT_PATH . '/models/StateModel.php';

require_once ROOT_PATH . '/models/PhotoPassword_Update.php';

require_once ROOT_PATH . '/middleware/AuthMiddleware.php';

require_once ROOT_PATH . '/services/mailer.php';

class UserController {

    private $db;

    private $photoPasswordModel;

    private $userid;

    public string $deviceType = 'pc';

    public $web_settings;

    public function __construct() {

        $this->userid = $_SESSION['userid'] ?? null;

        $this->userid = $_SESSION['userid'] ?? $this->userid;

        $this->db = (new Database())->getConnection();

        $this->photoPasswordModel = new PhotoPassword_Update($this->db);

    }





 public function page_otp(){
    if (session_status() === PHP_SESSION_NONE) {session_start();}
// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=login'));exit;}
if (!isset( $_SESSION['otp_refid'])) {header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=index')); exit;}
 $user_id = $userid =  $_SESSION['otp_refid'] ;
$page_name = "Otp Login";
$CallMailerModel = new Mailer;
 $callCompanyModel = new CompanyModel();
    $company_settings = $callCompanyModel->web_settings();
     $company_logfile_url = $company_settings['company_logfile_url'] ?? '';
  $AuthMiddlewareModel = new AuthMiddleware();
   $isConnected = $AuthMiddlewareModel->checkConnection();

    if ($isConnected) {
        $IsThereNetwork = "yes";
    } else {
        $IsThereNetwork = "no";
    }
    $GetTheModelClassCalledUser = new User();
  $userResult = $GetTheModelClassCalledUser->SelectUsersAndLoginTableforOnePerson($user_id);
 if ($userResult['success']) {
   $role_name = $role = $userResult['user']['login_role'];
    $otp =$current_otp = $userResult['user']['user_otp_request'] ?? '';
    $user_name = $userResult['user']['user_fullname'] ?? '';
     $receiveraddress = $userResult['user']['user_email'] ?? '';
}
 
if (isset($_POST['otp_code'])) {
     $posted_otp = trim($_POST['otp_code'] ?? '');
    if ($current_otp==$posted_otp ){
   $action = "Login successful using forgot password OTP";
$subject =  "Login successful with OTP";
    $_SESSION['success'] = "Login successful, please change your actual password now";
     $_SESSION['userid'] = $userid;
     $_SESSION['role'] = $role;
      $parts = explode(' ', trim($user_name));
$first = array_shift($parts);
$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';
 $user_details = $AbrvName . "  " . $userid;
            $logResult = $AuthMiddlewareModel->writelog(
                $userid,
                $role_name,
                $role,
                $user_details,
                $action,
                $company_logfile_url
            );

            $device = $AuthMiddlewareModel->WhatDeviceIsThis();

            $message =
                "Hello $user_name,<br><br>"
                . "You successfully used an OTP to log in to your account on "
                . date('l, F j, Y')
                . " at "
                . date('h:i A')
                . ".<br><br>"
                . "<strong>Device:</strong> $device<br><br>"
                . "If this was you, no further action is required.<br><br>"
                . "If you did not perform this login, please let your supervisor know so we can secure your account immediately.<br><br>"
                . "Best regards,<br>"
                . "The Support Team";
           
            if ($IsThereNetwork == "yes") {

                $SendEmail = $CallMailerModel->sendmail(
                    $receiveraddress,
                    $subject,
                    $message
                );
            }


unset($_SESSION['otp_refid']);


            header("Location: index?action=dashboard");
            
    }else{
$_SESSION['error'] = "Incorrect OTP code, please try again";
header("Location: index?action=verify_otp");
exit;
    }

        // $AuthMiddlewareModel->ValidateTurnstile($CF_SecretKey,$CF_VerificationSiteUrl);

  } 





// header("Location: index?action=verify_otp");
  require ROOT_PATH . "/views/verify_otp.php"; 
 

 }










    /* ==========================
       LOGIN
    ========================== */

 public function page_login(){

    if (session_status() === PHP_SESSION_NONE) {
        // $_SESSION=[]; setcookie(session_name(),'',time()-42000,'/'); session_destroy(); 
        session_start();
    }
      
    $callCompanyModel = new CompanyModel();
    $GetTheModelClassCalledUser = new User();
    $AuthMiddlewareModel = new AuthMiddleware();
   $AuthMiddlewareModel->IsLoginSessionActive();
    $isConnected = $AuthMiddlewareModel->checkConnection();

    if ($isConnected) {
        $IsThereNetwork = "yes";
    } else {
        $IsThereNetwork = "no";
    }

    $CallMailerModel = new Mailer;

    $company_settings = $callCompanyModel->web_settings();

    // Corrected: actually assign the copyright value
    $company_copyright =
        $company_settings['company_copyright'] ?? '2025';

    $company_poweredby =
        $company_settings['company_poweredby'] ?? 'AgbTeam';

    $company_copyrightlink =
        $company_settings['company_copyrightlink'] ?? 'https://www.agbng.com';

    $company_online =
        $company_settings['company_online'] ?? 0;

    $company_Allow_signup =
        $company_settings['company_signup'] ?? 0;

    $company_alias =
        $company_settings['company_alias'] ?? 'Page';

    $company_logo =
        $company_settings['company_logo'] ?? '';

    $company_favicon =
        $company_settings['company_favicon'] ?? '';

    $CF_VerificationSiteUrl =
        $company_settings['cloudfare_verifyurl'] ?? '';

    $CF_SecretKey =
        $company_settings['cloudfare_secretkey'] ?? '';

    $CF_SiteKey =
        $company_settings['cloudfare_sitekey'] ?? '';

    $company_logfile_url =
        $company_settings['company_logfile_url'] ?? '';

    $userid = $_SESSION['userid'] ?? null;



  if (isset($_POST['forgot_password'])) {
        // $AuthMiddlewareModel->ValidateTurnstile($CF_SecretKey,$CF_VerificationSiteUrl);
$email = trim($_POST['forgot_email'] ?? '');
$ref_id = trim($_POST['forgot_refid'] ?? '');

$result = $AuthMiddlewareModel->RequestOTP($email, $ref_id);

if ($result['status'] === true) {
   
    $otp = $result['otp'];
   $receiveraddress = $result['email'];
    $user_name = $result['user_name'];
    $_SESSION['otp_refid']  = $ref_id ;

$subject = "New temporary login OTP";

$message =
    "Hello $user_name,<br><br>"
    . "We received a request to help you access your account because you forgot your password.<br><br>"
    . "<strong>Your Temporary Login OTP:</strong> $otp<br><br>"
    . "Use this code to temporarily log in to your account and continue with the password reset process.<br><br>"
    . "<strong>Important:</strong> This OTP is for your account only. Do not share it with anyone. If you did not request a temporary login code, please contact your supervisor or support team immediately.<br><br>"
    . "Best regards,<br>"
    . "The Support Team";



  $SendEmail = $CallMailerModel->sendmail(
                    $receiveraddress,
                    $subject,
                    $message
                );
            $_SESSION['success'] = "Please enter the OTP sent to your email.";

header("Location: index?action=otpr");
exit;
} else {
    unset($_SESSION['otp_refid']);
    $_SESSION['error'] = $result['message'];
     header("Location: index?action=login");
    exit;
            
}

 }

 if (isset($_POST['resend_otp'])) {
    if (!isset( $_SESSION['otp_refid'])) {header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=index')); exit;}
      $resend_otp = $_POST['resend_otp'];
     if ($resend_otp == '38299') {
         $otp_refid =  $_SESSION['otp_refid'] ;
          $userResult = $GetTheModelClassCalledUser->SelectUsersAndLoginTableforOnePerson($otp_refid);
  if ($userResult['success']) {
   $role_name = $role = $userResult['user']['login_role'];
    $otp =$current_otp = $userResult['user']['user_otp_request'] ?? '';
    $user_name = $userResult['user']['user_fullname'] ?? '';
     $receiveraddress = $userResult['user']['user_email'] ?? '';
}
           $_SESSION['success'] = "The OTP has been resent to your email address.";
$message =
    "Hello $user_name,<br><br>"
    . "A request was made to resend the OTP required to access your account and continue with the password reset process.<br><br>"
    . "<strong>Your New Temporary Login OTP:</strong> $otp<br><br>"
    . "Please use this new OTP to temporarily log in to your account and continue with the password reset process.<br><br>"
    . "<strong>Important:</strong> This is a newly generated OTP and replaces any previously issued OTP. For your security, do not share this code with anyone. If you did not request a new OTP, please contact your supervisor or support team immediately.<br><br>"
    . "Best regards,<br>"
    . "The Support Team";

$subject = "Resent Temporary Login OTP";
$SendEmail = $CallMailerModel->sendmail(
    $receiveraddress,
    $subject,
    $message
);


header("Location: index?action=verify_otp");
exit;



 }
 }




    if (isset($_POST['login'])) {

        // $AuthMiddlewareModel->ValidateTurnstile($CF_SecretKey,$CF_VerificationSiteUrl );

        $userid = trim($_POST['userid'] ?? '');

        $password = $_POST['password'] ?? '';

        $loginResult = $GetTheModelClassCalledUser->login($userid,$password);

        if ($loginResult['success']) {

// $GetTheModelClassCalledUser->updateLoginCount($userid);
            $user = $loginResult['user'];

            $role_name = $role = $loginResult['user']['role'] ?? '';

            $_SESSION['success'] ="Welcome, you are logged in as a " . ucfirst($role);
           $_SESSION['action_token'] = bin2hex(random_bytes(32));

            $userResult =
                $GetTheModelClassCalledUser->SelectUserTableForOne($userid);

            if (
                !empty($userResult['success']) &&
                !empty($userResult['user'])
            ) {

                $user = $userResult['user'];

                $user_fullname =
                    $AbrvName = $user['fullname'] ?? 'User';

                $receiveraddress =
                    $user['email'] ?? '';

                $parts = preg_split(
                    '/\s+/',
                    trim($AbrvName)
                );

                $first = array_shift($parts);

                if (!empty($first)) {

                    $initials = [];

                    foreach ($parts as $part) {

                        if ($part !== '') {

                            $initials[] =
                                strtoupper($part[0]);
                        }
                    }

                    $AbrvName = $first;

                    if (!empty($initials)) {

                        $AbrvName .=
                            ' ' . implode('.', $initials);
                    }

                } else {

                    $AbrvName = '';
                }

                $user_details =
                    $AbrvName . "  " . $userid;

            } else {

                $user_details = "  " . $userid;

                $user_fullname = 'User';

                $receiveraddress = '';
            }


            $subject = $action = "Login successful";

            $device = $AuthMiddlewareModel->WhatDeviceIsThis();

            $message =
                "Hello $user_fullname,<br><br>"
                . "You successfully logged in to your account on "
                . date('l, F j, Y')
                . " at "
                . date('h:i A')
                . ".<br><br>"
                . "<strong>Device:</strong> $device<br><br>"
                . "If this was you, no further action is required.<br><br>"
                . "If you did not perform this login, please let your supervisor know so we can secure your account immediately.<br><br>"
                . "Best regards,<br>"
                . "The Support Team";


            $_SESSION['userid'] = $userid;

            $_SESSION['role'] = $role;

            $logResult = $AuthMiddlewareModel->writelog(
                $userid,
                $role_name,
                $role,
                $user_details,
                $action,
                $company_logfile_url
            );

            // Send email
            if ($IsThereNetwork == "yes") {

                $SendEmail = $CallMailerModel->sendmail(
                    $receiveraddress,
                    $subject,
                    $message
                );
            }


            header("Location: index?action=dashboard");

            exit;


        } else {

            // Login failed
            $_SESSION['error'] =
                $loginResult['error'] ?? 'Invalid login details.';

            // Removed exit so the login page can be displayed
        }
    }


    $page_name = "Login";

    require ROOT_PATH . "/views/login.php";
}





    /* ==========================
       UPDATE PASSWORD
    ========================== */
public function updatepassword(){

    $callusermodel = new User();
    $AuthMiddlewareModel = new AuthMiddleware();
    $callCompanyModel = new CompanyModel();
    $company_settings = $callCompanyModel->web_settings();
    $CallMailerModel = new Mailer;

    $company_logfile_url = $company_settings['company_logfile_url'] ?? '';
    $CF_VerificationSiteUrl = $company_settings['cloudfare_verifyurl'] ?? '';
    $CF_SecretKey = $company_settings['cloudfare_secretkey'] ?? '';
    $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';

    if (isset($_POST['update_user_password'])) {

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

        $result = $callusermodel->updateuserpwd($data);

        if ($result === "Password updated successfully.") {

            $_SESSION['success'] = $result;

            $userResult = $callusermodel->SelectUserTableForOne($userid);

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

            $logResult = $AuthMiddlewareModel->writelog(
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

            header("Location: index?action=dashboard");

            exit;

        } else {

            $_SESSION['error'] = $result;

           header("Location: index?action=dashboard");
            exit;
        }
    }

    if ($AuthMiddlewareModel->IsThisAfirstTimeLogin()) {

        require ROOT_PATH . "/views/compulsory_changepassword.php";

    } else {

        // header(
        //     "Location: " .
        //     ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=dashboard')
        // );

        // exit;
    }
}





public function create_reporter()   {
if (session_status() === PHP_SESSION_NONE) { session_start();  }

if (isset($_POST['signup_reporter'])) {
                
    $AuthMiddlewareModel = new AuthMiddleware();
    $userModel = new User();

    // PREVENT MULTIPLE FORM SUBMISSIONS
    // if (!$AuthMiddlewareModel->ValidateAndConsumeActionToken()) {
    //     $_SESSION['error'] = 'This form has already been submitted. Please try again.';
    //     header("Location: index?action=login");
    //     exit;
    // }

    $callCompanyModel = new CompanyModel();

    $CallMailerModel = new Mailer();

    $company_settings = $callCompanyModel->web_settings();
    $CF_VerificationSiteUrl = $company_settings['cloudfare_verifyurl'] ?? '';
    $CF_SecretKey = $company_settings['cloudfare_secretkey'] ?? '';
    $CF_SiteKey = $company_settings['cloudfare_sitekey'] ?? '';
    $company_logfile_url = $company_settings['company_logfile_url'] ?? '';
    $company_url = $company_settings['company_url'] ?? '';
    $loginurl = $company_url."/index.php?action=login" ;
    // $AuthMiddlewareModel->ValidateTurnstile($CF_SecretKey,$CF_VerificationSiteUrl);
    $company_userid =
        $company_settings['company_userid'] ?? 50001;

    $company_acct_approval =
        $company_settings['company_acct_approval'] ?? 0;

    // GET FORM DATA
    $fullname = trim($_POST['fullname'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $receiveraddress = $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $affirmation = isset($_POST['affirmation']) ? 1 : 0;

    // VALIDATE DATA
    if ($fullname === '' || $title === '' || $phone === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '' || $affirmation !== 1) {
        $_SESSION['error'] = 'Please fill all required fields correctly.';
        header("Location: index?action=login");
        exit;
    }

    $role = "reporter";
    $role_name = "reporter";

    $result = $userModel->CreateUserAccount(
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

        if ($company_acct_approval == 1) {

            $_SESSION['success'] =
                "Account created successfully, please check your email login for details";

            $subject = $action =
                "Account created successfully";

            $message = "Hello $fullname,<br><br>"
                     . "Your account has been created successfully.<br><br>"
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

            $_SESSION['userid'] = $userrefid;
            $_SESSION['role'] = $role;

            $userid = $userrefid;
            $user_details = $fullname . "  " . $userrefid;

            $logResult = $AuthMiddlewareModel->writelog(
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

            header("Location: index?action=login");
            exit;

        } else {

            $_SESSION['success'] =
                "Request submitted. You will receive an email upon approval";

            header("Location: index?action=login");
            exit;
        }

    } else {

        unset($_SESSION['error']);
        unset($_SESSION['errors']);

        $_SESSION['errors'] = [];

        if (!empty($result['phone_exists'])) {
            $_SESSION['error'] = 'This phone number is already registered.';
        }
        elseif (!empty($result['email_exists'])) {
            $_SESSION['error'] =
                'This email address is already registered.';
        }
        elseif (!empty($result['error'])) {
            $_SESSION['error'] =
                "Unable to create your account. Please try again";
            // $_SESSION['error'] = $result['error'];
        }

        header("Location: index?action=login");
        exit;
    }

    unset($_SESSION['error']);
    unset($_SESSION['errors']);

}

header("Location: index?action=login");
exit;

}






public function restoreuser(){
    $CallUserModel = new User();
        $callAuthMiddlewareClass = new AuthMiddleware;
             $callCompanyModel = new CompanyModel() ;
      $company_settings = $callCompanyModel ->web_settings();
      $company_logfile_url  = $company_settings['company_logfile_url'] ;
       $company_settings = $callCompanyModel->web_settings();
      $company_online = $company_settings['company_online'] ?? 0;
           $company_url = $company_settings['company_url'] ?? '';
            $loginurl = $company_url."/index.php?action=login" ;
         $userid =$_SESSION['userid']; 
  
     $result = $callAuthMiddlewareClass->SelectloginTableForOne($userid);
if ($result['success']) {
    $user = $result['user'];
    $role_name = $user['role_name'];
    $role = $user['role'];
    $admin_fullname = $user['fullname'];
    $parts = explode(' ', trim($admin_fullname));
$first = array_shift($parts);
$AbrvName = !empty($first)? $first . (!empty($parts) ? ' ' . implode('.', array_map(fn($p) => strtoupper($p[0]), $parts)) : '') : 'User';
  
   }
      $result = $CallUserModel->restorerecord();
    $page_controller = $result['page_controller'];
    $user_fullname = base64_decode($result['user_name']);
    if ($result['success']) {
        $_SESSION['success'] = 'Record restored successfully';

 $user_details = $AbrvName . "  " . $userid;
      $action = "Restored user " . $user_fullname  . " to system";
 $logResult = $callAuthMiddlewareClass->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);

   
       header("Location: index?action=" . base64_decode($page_controller));
exit;
        exit;
    }

    $_SESSION['error'] = 'Failed to restore record.';
   header("Location: index?action=" . base64_decode($page_controller));
    exit;
}
















    /* ==========================
       NEW PERSONNEL PAGE
    ========================== */

    public function updatePhoto(): void {

        $serviceNo = $this->serviceNo;

        if (!$serviceNo) {

            echo json_encode([

                'status' => 'error',

                'message' => 'Unauthorized'

            ]);

            exit;

        }


        if (!isset($_FILES['photo'])) {

            echo json_encode([

                'status' => 'error',

                'message' => 'No file uploaded'

            ]);

            exit;

        }


        $file = $_FILES['photo'];

        $ext = strtolower(

            pathinfo($file['name'], PATHINFO_EXTENSION)

        );


        $allowed = ['jpg', 'jpeg', 'png', 'gif'];


        if (!in_array($ext, $allowed, true)) {

            echo json_encode([

                'status' => 'error',

                'message' => 'Invalid file type'

            ]);

            exit;

        }


        $newName =
            "profile_{$serviceNo}_" . time() . "." . $ext;


        $dir =
            ROOT_PATH . "/app/views/uploads/img/profile/";


        if (!is_dir($dir)) {

            mkdir($dir, 0755, true);

        }


        $dest = $dir . $newName;


        if (

            move_uploaded_file($file['tmp_name'], $dest) &&

            $this->photoPasswordModel->updatePhoto(
                $serviceNo,
                $newName
            )

        ) {

            echo json_encode([

                'status' => 'success',

                'filename' => $newName

            ]);

        } else {

            echo json_encode([

                'status' => 'error',

                'message' => 'Upload failed'

            ]);

        }

        exit;

    }



    /* ==========================
       GET LGAs
    ========================== */

    public function getLGAs() {

        $model = new StateModel();

        $lgas = $model->getLGAs(

            $_GET['state_id'] ?? 0

        );

        echo json_encode($lgas);

    }


    /* ==========================
       PAGE NOT FOUND
    ========================== */

    public function pagenotfound() {

        $page_name = "404 Error";

        $callCompanyModel = new CompanyModel();

        $company_settings = $callCompanyModel->web_settings();

        $company_copyright =
            $company_settings['company_copyright'] ?? '2025';

        $company_poweredby =
            $company_settings['company_poweredby'] ?? 'AgbTeam';

        $company_copyrightlink =
            $company_settings['company_copyrightlink'] ?? 'https://www.agbng.com';

        $company_online =
            $company_settings['company_online'] ?? 0;

        $company_Allow_signup =
            $company_settings['company_signup'] ?? 0;

        $company_alias =
            $company_settings['company_alias'] ?? 'Page';

        $company_logo =
            $company_settings['company_logo'] ?? '';

        require ROOT_PATH . "/views/pagenotfound.php";

    }


    /* ==========================
       LOGOUT
    ========================== */

    public function logout() {

        if (session_status() === PHP_SESSION_NONE) {

            session_start();

        }

        session_destroy();

        header("Location: index?action=login");

        exit;

    }

}
