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


    /* ==========================
       LOGIN
    ========================== */
   public function login(){
    if (session_status() === PHP_SESSION_NONE) {
session_start();
}
$callCompanyModel = new CompanyModel();
$CallMailerModel = new Mailer;
$company_settings = $callCompanyModel->web_settings();
$company_logfile_url = $company_settings['company_logfile_url'] ?? '';
$GetTheModelClassCalledUser = new User();
$AuthMiddlewareModel = new AuthMiddleware();

$userid = $_SESSION['userid'] ?? null;

$AbrvName = "";
$user_details = "";
$role_name = "";
$role = "";

if (isset($_POST['forgot_password'])) {
    $forgot_email = $_POST['forgot_email'] ?? '';
    $security_answer = $_POST['security_answer'] ?? '';
}


if (isset($_POST['login'])) {

    $action = "Login failed";

    $userid = trim($_POST['userid'] ?? '');
    $password = $_POST['password'] ?? '';

    $loginResult = $GetTheModelClassCalledUser->login($userid, $password);

    $role = $loginResult['user']['role'] ?? '';

    $logData = $AuthMiddlewareModel->SelectloginTableForOne($userid);

    if (!empty($logData['user'])) {
        $user = $logData['user'];
        $role_name = $user['role_name'] ?? $role;
    } else {
        $role_name = $role ?: 'Unrecorded';
    }

    if (!empty($loginResult['success'])) {

        $userResult = $GetTheModelClassCalledUser->SelectUserTableForOne($userid);

        if (!empty($userResult['success']) && !empty($userResult['user'])) {

            $user = $userResult['user'];

            $AbrvName = $user['fullname'] ?? '';

            $parts = preg_split('/\s+/', trim($AbrvName));

            $first = array_shift($parts);

            if (!empty($first)) {

                $initials = [];

                foreach ($parts as $part) {
                    if ($part !== '') {
                        $initials[] = strtoupper($part[0]);
                    }
                }

                $AbrvName = $first;

                if (!empty($initials)) {
                    $AbrvName .= ' ' . implode('.', $initials);
                }

            } else {
                $AbrvName = '';
            }

            $user_details = $AbrvName . "  " . $userid;
        } else {
            $user_details = "  " . $userid;
        }

        $action = "Login successful";

       
        $_SESSION['userid'] = $userid;
        $_SESSION['role'] = $role;
  $logResult = $AuthMiddlewareModel->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);
//   Send email  
  $SendEmail = $CallMailerModel->sendmail($receiveraddress, $subject, $message);
        $_SESSION['success'] =
            "Welcome, you are logged in as a " . ucfirst($role_name);

        header("Location: index?action=dashboard");
        exit;
    }

    $user_details = " " . $userid;

    $logResult = $AuthMiddlewareModel->writelog($userid, $role_name,$role, $user_details, $action,$company_logfile_url);

    $_SESSION['error'] = $loginResult['message'] ?? 'Invalid login credentials.';

    header("Location: index?action=login");
    exit;
}

$page_name = "Login";


$company_copyright = $company_settings['company_copyright'] ?? '2025';


$company_poweredby =  $company_settings['company_poweredby'] ?? 'AgbTeam';

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
require ROOT_PATH . "/views/login.php";


}

    /* ==========================
       Create Reporter
    ========================== */

public function create_reporter()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_POST['signup_reporter'])) {

        $callCompanyModel = new CompanyModel();

        $company_settings = $callCompanyModel->web_settings();

        $company_userid = $company_settings['company_userid'] ?? 50001;
        $company_acct_approval = $company_settings['company_acct_approval'] ?? 0;


        // =====================================================
        // GET FORM DATA
        // =====================================================

        $fullname = trim($_POST['fullname'] ?? '');
        $title = trim($_POST['title'] ?? '');

        $phone = trim($_POST['phone'] ?? '');

        $email = trim($_POST['email'] ?? '');

        $password = $_POST['password'] ?? '';

        $affirmation = isset($_POST['affirmation']) ? 1 : 0;


        // =====================================================
        // VALIDATE FULL NAME
        // =====================================================

        if ($fullname === '') {

            $_SESSION['error'] = 'Full name is required.';

            header("Location: index?action=login");

            exit;
        }
        // =====================================================
        // VALIDATE Title
        // =====================================================

        if ($title === '') {

            $_SESSION['error'] = 'Title  is required.';

            header("Location: index?action=login");

            exit;
        }


        // =====================================================
        // VALIDATE PHONE
        // =====================================================

        if ($phone === '') {

            $_SESSION['error'] = 'Phone number is required.';

            header("Location: index?action=login");

            exit;
        }


        // =====================================================
        // VALIDATE EMAIL
        // =====================================================

        if ($email === '') {

            $_SESSION['error'] = 'Email address is required.';

            header("Location: index?action=login");

            exit;
        }


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $_SESSION['error'] = 'Please enter a valid email address.';

            header("Location: index?action=login");

            exit;
        }


        // =====================================================
        // VALIDATE PASSWORD
        // =====================================================

        if ($password === '') {

            $_SESSION['error'] = 'Password is required.';

            header("Location: index?action=login");

            exit;
        }


        // =====================================================
        // VALIDATE AFFIRMATION
        // =====================================================

        if ($affirmation !== 1) {

            $_SESSION['error'] = 'You must accept the declaration.';

            header("Location: index?action=login");

            exit;
        }


        // =====================================================
        // CREATE REPORTER
        // =====================================================

        $userModel = new User();

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


        // =====================================================
        // SUCCESS
        // =====================================================

        if (!empty($result['success'])) {
            if ($company_acct_approval ==1) {
             $_SESSION['success'] = "Account created successfully, please check your email box for details";
// send email
            }else{
                    $_SESSION['success'] = "Request submitted. You will receive an email upon approval";

            }

        
            unset($_SESSION['error']);

            unset($_SESSION['errors']);
        }


        // =====================================================
        // PHONE ALREADY EXISTS
        // =====================================================

        else {

            unset($_SESSION['error']);

            unset($_SESSION['errors']);

            $_SESSION['errors'] = [];


            if (!empty($result['phone_exists'])) {

                $_SESSION['error'] =
                    'This phone number is already registered.';
            }


            // =================================================
            // EMAIL ALREADY EXISTS
            // =================================================

            elseif (!empty($result['email_exists'])) {

                $_SESSION['error'] =
                    'This email address is already registered.';
            }


            // =================================================
            // GENERAL DATABASE/SYSTEM ERROR
            // =================================================

            elseif (!empty($result['error'])) {

                $_SESSION['error'] =
                    "Unable to create your account. Please try again";

                // For debugging only:
                // $_SESSION['error'] = $result['error'];
            }
        }


        // =====================================================
        // REDIRECT
        // =====================================================

        header("Location: index?action=login");

        exit;


    } else {


        // =====================================================
        // NO FORM SUBMISSION
        // =====================================================

        header("Location: index?action=login");

        exit;
    }
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

        $newName = "profile_{$serviceNo}_" . time() . "." . $ext;

        $dir = ROOT_PATH . "/app/views/uploads/img/profile/";

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $dest = $dir . $newName;

        if (
            move_uploaded_file($file['tmp_name'], $dest) &&
            $this->photoPasswordModel->updatePhoto($serviceNo, $newName)
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
       UPDATE PASSWORD
    ========================== */
    public function updatePassword(): void {

        $serviceNo = $this->serviceNo;

        if (!$serviceNo) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            exit;
        }

        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if (
            !$password ||
            $password !== $confirm ||
            strlen($password) < 6
        ) {

            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid password'
            ]);

            exit;
        }

        $hashed = password_hash(
            $password,
            PASSWORD_BCRYPT
        );

        if ($this->photoPasswordModel->updatePassword($serviceNo, $hashed)) {

            echo json_encode([
                'status' => 'success'
            ]);

        } else {

            echo json_encode([
                'status' => 'error',
                'message' => 'Password update failed'
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

        $company_copyright = $company_settings['company_copyright'] ?? '2025';
        $company_poweredby = $company_settings['company_poweredby'] ?? 'AgbTeam';
        $company_copyrightlink = $company_settings['company_copyrightlink'] ?? 'https://www.agbng.com';
        $company_online = $company_settings['company_online'] ?? 0;
        $company_Allow_signup = $company_settings['company_signup'] ?? 0;
        $company_alias = $company_settings['company_alias'] ?? 'Page';
        $company_logo = $company_settings['company_logo'] ?? '';

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