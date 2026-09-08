
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

                    $user_fullname = $AbrvName = $user['fullname'] ?? 'User';

                    $receiveraddress = $user['email'] ?? '';

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

                    $user_fullname = 'User';

                    $receiveraddress = '';

                }


                $subject = $action = "Login successful";

                $device = $AuthMiddlewareModel->WhatDeviceIsThis();

                $message = "Hello $user_fullname,<br><br>"
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

                $SendEmail = $CallMailerModel->sendmail(
                    $receiveraddress,
                    $subject,
                    $message
                );

                $_SESSION['success'] =
                    "Welcome, you are logged in as a " . ucfirst($role_name);

                header("Location: index?action=dashboard");

                exit;

            }


            $user_details = " " . $userid;

            $logResult = $AuthMiddlewareModel->writelog(
                $userid,
                $role_name,
                $role,
                $user_details,
                $action,
                $company_logfile_url
            );

            $_SESSION['error'] =
                $loginResult['message'] ?? 'Invalid login credentials.';

            header("Location: index?action=login");

            exit;

        }


        $page_name = "Login";


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

            $userModel = new User();

            $callCompanyModel = new CompanyModel();

            $CallMailerModel = new Mailer();

            $company_settings = $callCompanyModel->web_settings();

            $company_logfile_url = $company_settings['company_logfile_url'] ?? '';
            $company_url = $company_settings['company_url'] ?? '';
            $loginurl = $company_url."/index.php?action=login" ;

            $company_userid =
                $company_settings['company_userid'] ?? 50001;

            $company_acct_approval =
                $company_settings['company_acct_approval'] ?? 0;


            // =====================================================
            // GET FORM DATA
            // =====================================================

            $fullname = trim($_POST['fullname'] ?? '');

            $title = trim($_POST['title'] ?? '');

            $phone = trim($_POST['phone'] ?? '');

            $receiveraddress = $email = trim($_POST['email'] ?? '');

            $password = $_POST['password'] ?? '';

            $affirmation = isset($_POST['affirmation']) ? 1 : 0;


            // =====================================================
            // VALIDATE DATA
            // =====================================================

            if ($fullname === '' || $title === '' || $phone === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '' || $affirmation !== 1) {

                $_SESSION['error'] =
                    'Please fill all required fields correctly.';

                header("Location: index?action=login");

                exit;

            }


            // =====================================================
            // END OF VALIDATION, NOW CREATE REPORTER
            // =====================================================

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
            // SEND MAIL
            // =====================================================

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


                    // Corrected variables for the log

                    $userid = $userrefid;

                    $user_details = $fullname . "  " . $userrefid;


                    $AuthMiddlewareModel = new AuthMiddleware();


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

                }


            } else {

                $_SESSION['success'] =
                    "Request submitted. You will receive an email upon approval";

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

        $confirm = $_POST['confirm_password'] ?? '';


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


        if (
            $this->photoPasswordModel->updatePassword(
                $serviceNo,
                $hashed
            )
        ) {

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
