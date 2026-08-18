<?php
require_once ROOT_PATH . '/models/User.php';
require_once ROOT_PATH . '/models/StateModel.php';
require_once ROOT_PATH . '/models/PhotoPassword_Update.php';
require_once ROOT_PATH . '/middleware/AuthMiddleware.php';

class UserController {

    private $db;
    private $photoPasswordModel;
    private $userid;
    public string $deviceType = 'pc'; // default
    public $web_settings;

    public function __construct() {
        $this->userid= $_SESSION['userid'] ?? $_SESSION['userid'] ?? null;
        $this->db = (new Database())->getConnection();
        $this->photoPasswordModel = new PhotoPassword_Update($this->db);
    }
    
 /* ==========================
       LOGIN
    ========================== */
    public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $GetTheModelClassCalledUser = new User();
        $AuthMiddlewareModel = new AuthMiddleware();
        // $AuthMiddlewareModel->IsLoginSessionActive();

        if (isset($_POST['login'])) {
            $userid = $_POST['userid'];
            $password = $_POST['password'];
            $role     = $_POST['role'];

            $logData = $AuthMiddlewareModel->writelog($userid, $role);
            $logFile = $logData['logFile'];
            $date    = $logData['date'];
            $ip      = $logData['ip'];

            $result = $GetTheModelClassCalledUser->login($userid, $password, $role);

            if ($result['success'] === true) {
                $_SESSION['success'] = "Welcome, you are logged in as " . $role;
                //  $_SESSION['userid'] = $result['user']['userid'];
                 $_SESSION['userid'] = $userid ;
                  $_SESSION['role'] = $role;
                  $_SESSION['level'] = $result['user']['level'];
                  if ($_SESSION['level']>=2 ) {
                    $_SESSION['success'] = "Welcome, you are logged in as Super " . $role;
                 }
               

                  // $_SESSION['state_code'] = $result['user']['state_code'];
                // $_SESSION['stateoforigin'] = $result['user']['stateoforigin'];
              

                $message = "Action: Login success | User: {$userid} | Role: {$role}";
                $line = "[{$date}] {$message} | IP: {$ip}" . PHP_EOL;
                file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

                header("Location: index?action=dashboard");
                exit;
            } else {
                $error = $result['error'];
                $message = "Action: Login failed, {$error} | User: {$userid} | Role: {$role}";
                $line = "[{$date}] {$message} | IP: {$ip}" . PHP_EOL;
                file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
                 $_SESSION['error'] = $error ;
                 }
        }

        $page_name = "Login";
       
        $web_settings = $GetTheModelClassCalledUser->web_settings();
        // var_dump($web_setings);
        
        require ROOT_PATH . "/views/login.php";
    }

    /* ==========================
       DASHBOARD
    ========================== */
    public function dashboard() {
        $page_name = "Dashboard";
        $GetThisModel = new User();
        
        $userid = $_SESSION['userid'] ?? null;

          $page_name = "Dashboard";
        $web_settings = $GetThisModel->web_settings();
       
     if ($userid && isset($_SESSION['role']) && isset($_SESSION['level'])) {
    require ROOT_PATH . "/views/users/" . $_SESSION['role'] . "/dashboard.php";
} else {
    exit;
}
    }


    
    /* ==========================
       NEW PERSONNEL PAGE
    ========================== */

public function newpersonnel(){

    echo '
    <script src="app/views/inc/sweetalert/jquery-3.6.4.min.js"></script>
    <script src="app/views/inc/sweetalert/sweetalert2@11.js"></script>
    <link rel="stylesheet" href="app/views/inc/sweetalert/sweetalert2.min.css">
    ';

    $page_name = "personnel";

    $GetThisModel = new User();
    $StateModel   = new StateModel();

    $formation_id = $_SESSION['state_code'] ?? null;

    $states                    = $StateModel->GetAllStates();
    $state_id                  = $_SESSION['state_code'] ?? null;
    $AstateLGAs                = $StateModel->GetAstateLGAs($state_id);
    $formation_list            = $StateModel->GetAllNisFormations();
    $AllPensionCompanies       = $GetThisModel->GetAllNigerianPensionCompanies();
    $SectionUnit               = $GetThisModel->Section_unit();
    $rank_lising               = $GetThisModel->getAllRanks();
    $nis_qualification_listing = $GetThisModel->GetNisQualifications();
    $banking_lising            = $GetThisModel->GetAllNigerianBanks();
    $web_settings              = $GetThisModel->web_settings();

    $serviceNo = $_SESSION['user_id'] ?? null;

    $Personnel_details = $GetThisModel->getPersonnelDetailsByServiceNo($serviceNo);

    $seniority       = $Personnel_details['seniority'] ?? '';
    $officer_details = $Personnel_details['personnel_data'] ?? '';
    $officers_name   = $Personnel_details['officers_name'] ?? '';



    /*
    |--------------------------------------------------------------------------
    | FORM SUBMISSION
    |--------------------------------------------------------------------------
    */
    if (isset($_POST['Personel_enrolment'])) {

        /*
        |--------------------------------------------------------------------------
        | GET FORM DATA
        |--------------------------------------------------------------------------
        */
        $data = User::createpersonnel();

        $personneldata = $data['bio_data'];
        $promotiondata = $data['promotion_data'];
        $postingdata   = $data['posting_data'];
        $nokdata       = $data['next_of_kin'];
        // $NewUserServiceNo =$personneldata['service_no'];



        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $errors = [];



        /*
        |--------------------------------------------------------------------------
        | VALIDATE REQUIRED FIELDS
        |--------------------------------------------------------------------------
        */
        $validateRequired = function (array $data, array $fields, array &$errors) {

            foreach ($fields as $field) {

                if (is_array($data[$field] ?? null)) {
                    continue;
                }

                if (
                    !isset($data[$field]) ||
                    trim((string)$data[$field]) === ''
                ) {
                    $errors[] = ucfirst(str_replace('_', ' ', $field)) . " is required";
                }
            }
        };



        /*
        |--------------------------------------------------------------------------
        | VALIDATE INTEGER FIELDS
        |--------------------------------------------------------------------------
        */
        $validateIntegers = function (array $data, array $fields, array &$errors) {

            foreach ($fields as $field) {

                if (
                    isset($data[$field]) &&
                    $data[$field] !== '' &&
                    filter_var($data[$field], FILTER_VALIDATE_INT) === false
                ) {
                    $errors[] = ucfirst(str_replace('_', ' ', $field)) . " must be an integer";
                }
            }
        };



        /*
        |--------------------------------------------------------------------------
        | VALIDATE DATE FIELDS
        |--------------------------------------------------------------------------
        */
        $validateDates = function (array $data, array $fields, array &$errors) {

            foreach ($fields as $field) {

                if (!empty($data[$field])) {

                    $date = DateTime::createFromFormat('Y-m-d', $data[$field]);

                    if (!$date || $date->format('Y-m-d') !== $data[$field]) {
                        $errors[] = ucfirst(str_replace('_', ' ', $field)) . " must be a valid date";
                    }
                }
            }
        };



        /*
        |--------------------------------------------------------------------------
        | VALIDATE EMAIL
        |--------------------------------------------------------------------------
        */
        $validateEmail = function ($email, array &$errors) {

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email address";
            }
        };



        /*
        |--------------------------------------------------------------------------
        | VALIDATE FILES
        |--------------------------------------------------------------------------
        */
        $validateFile = function ($file, $name, array &$errors) {

            if (empty($file['tmp_name'])) {
                $errors[] = "$name file is required";
                return;
            }

            $allowed = ['jpg', 'jpeg', 'png'];

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $errors[] = "$name must be JPG, JPEG or PNG";
            }

            // 2MB MAX
            if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
                $errors[] = "$name size must not exceed 2MB";
            }
        };



        /*
        |--------------------------------------------------------------------------
        | REQUIRED FIELD CHECK
        |--------------------------------------------------------------------------
        */
        $validateRequired($personneldata, [

            'surname',
            'firstname',
            'dob',
            'gender',
            'marital_status',
            'qualification',
            'discipline',
            'complexion',
            'eye_color',
            'blood_group',
            'genotype',
            'height',
            'weight',
            'stateoforigin',
            'LgaOfOrigin',
            'hometown',
            'email',
            'phone',
            'address',
            'service_no',
            'rank',
            'salary_scale',
            'bank',
            'acct_number',
            'pension_name',
            'pen_number',
            'ippis_no',
            'tin_no',
            'stateofduty',
            'current_dept',
            'dofa',
            'docf',
            'dor'

        ], $errors);



        $validateRequired($promotiondata, [

            'service_no',
            'dopa'

        ], $errors);



        $validateRequired($postingdata, [

            'service_no',
            'last_cmd_fmt1',
            'fmt1_from',
            'fmt1_to'

        ], $errors);



        $validateRequired($nokdata, [

            'service_no',
            'nok1_name',
            'nok1_relationship',
            'nok1_gender',
            'nok1_dob',
            'nok1_phone',
            'nok1_address'

        ], $errors);



        /*
        |--------------------------------------------------------------------------
        | INTEGER VALIDATION
        |--------------------------------------------------------------------------
        */
        $validateIntegers($personneldata, [

            'qualification',
            'chest',
            'disability',
            'stateoforigin',
            'rank',
            'bank',
            'pension_name',
            'stateofduty',
            'current_dept'

        ], $errors);



        /*
        |--------------------------------------------------------------------------
        | DATE VALIDATION
        |--------------------------------------------------------------------------
        */
        $validateDates($personneldata, [

            'dob',
            'dofa',
            'docf',
            'dor'

        ], $errors);



        $validateDates($promotiondata, [

            'dopa'

        ], $errors);



        $validateDates($postingdata, [

            'fmt1_from',
            'fmt1_to',
            'fmt2_from',
            'fmt2_to'

        ], $errors);



        $validateDates($nokdata, [

            'nok1_dob',
            'nok2_dob'

        ], $errors);



        /*
        |--------------------------------------------------------------------------
        | EMAIL VALIDATION
        |--------------------------------------------------------------------------
        */
        $validateEmail($personneldata['email'] ?? '', $errors);



        /*
        |--------------------------------------------------------------------------
        | FILE VALIDATION
        |--------------------------------------------------------------------------
        */
        $validateFile($_FILES['passport'] ?? [], 'Passport', $errors);

        $validateFile($_FILES['signature'] ?? [], 'Signature', $errors);



        /*
        |--------------------------------------------------------------------------
        | SHOW VALIDATION ERRORS
        |--------------------------------------------------------------------------
        */
        if (!empty($errors)) {

            $errorList = "";

            foreach ($errors as $error) {
                $errorList .= $error . "<br>";
            }

            echo '
            <script>

                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    html: `' . $errorList . '`,
                    confirmButtonColor: "#d33"
                });

            </script>
            ';

        } else {

            /*
            |--------------------------------------------------------------------------
            | FILE UPLOADS
            |--------------------------------------------------------------------------
            */
            $NewUserServiceNo = $personneldata['service_no'];



            // Upload Passport
            if (!empty($_FILES['passport']['tmp_name'])) {

                $ext = strtolower(pathinfo($_FILES['passport']['name'], PATHINFO_EXTENSION));

                $passportName = "p_" . $NewUserServiceNo  . "." . $ext;

                move_uploaded_file(
                    $_FILES['passport']['tmp_name'],
                    ROOT_PATH . "/app/views/uploads/img/profile/" . $passportName
                );

                $personneldata['img'] = $passportName;
            }



            // Upload Signature
            if (!empty($_FILES['signature']['tmp_name'])) {

                $ext = strtolower(pathinfo($_FILES['signature']['name'], PATHINFO_EXTENSION));

                $signatureName = "s_" . $NewUserServiceNo  . "." . $ext;

                move_uploaded_file(
                    $_FILES['signature']['tmp_name'],
                    ROOT_PATH . "/app/views/uploads/img/signature/" . $signatureName
                );

                $personneldata['signature'] = $signatureName;
            }



            /*
            |--------------------------------------------------------------------------
            | DATABASE INSERTION
            |--------------------------------------------------------------------------
            */
            try {

                $this->db->beginTransaction();



                /*
                |--------------------------------------------------------------------------
                | INSERT INTO personnel
                |--------------------------------------------------------------------------
                */
                $columns      = implode(',', array_keys($personneldata));
                $placeholders = ':' . implode(',:', array_keys($personneldata));

                $sql = "INSERT INTO personnel ($columns)
                        VALUES ($placeholders)";

                $stmt = $this->db->prepare($sql);

                foreach ($personneldata as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }

                $stmt->execute();



                /*
                |--------------------------------------------------------------------------
                | INSERT INTO promotions
                |--------------------------------------------------------------------------
                */
                $columns      = implode(',', array_keys($promotiondata));
                $placeholders = ':' . implode(',:', array_keys($promotiondata));

                $sql = "INSERT INTO promotions ($columns)
                        VALUES ($placeholders)";

                $stmt = $this->db->prepare($sql);

                foreach ($promotiondata as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }

                $stmt->execute();



                /*
                |--------------------------------------------------------------------------
                | INSERT INTO posting_history
                |--------------------------------------------------------------------------
                */
                $columns      = implode(',', array_keys($postingdata));
                $placeholders = ':' . implode(',:', array_keys($postingdata));

                $sql = "INSERT INTO posting_history ($columns)
                        VALUES ($placeholders)";

                $stmt = $this->db->prepare($sql);

                foreach ($postingdata as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }

                $stmt->execute();



                /*
                |--------------------------------------------------------------------------
                | INSERT INTO nok
                |--------------------------------------------------------------------------
                */
                $columns      = implode(',', array_keys($nokdata));
                $placeholders = ':' . implode(',:', array_keys($nokdata));

                $sql = "INSERT INTO nok ($columns)
                        VALUES ($placeholders)";

                $stmt = $this->db->prepare($sql);

                foreach ($nokdata as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }

                $stmt->execute();



                /*
                |--------------------------------------------------------------------------
                | COMMIT TRANSACTION
                |--------------------------------------------------------------------------
                */
                $this->db->commit();



                /*
                |--------------------------------------------------------------------------
                | SUCCESS MESSAGE
                |--------------------------------------------------------------------------
                */
                echo '
                <script>

                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Personnel Record Created Successfully!",
                        confirmButtonColor: "#3085d6"
                    }).then(() => {

                        window.location.href = "";

                    });

                </script>
                ';

            } catch (Exception $e) {

                $this->db->rollBack();



                /*
                |--------------------------------------------------------------------------
                | DATABASE ERROR
                |--------------------------------------------------------------------------
                */
                echo '
                <script>

                    Swal.fire({
                        icon: "error",
                        title: "Database Error",
                        html: `' . addslashes($e->getMessage()) . '`,
                        confirmButtonColor: "#d33"
                    });

                </script>
                ';
            }
        }
    }



    /*
    |--------------------------------------------------------------------------
    | LOAD VIEW
    |--------------------------------------------------------------------------
    */
    if ($serviceNo && isset($_SESSION['role'])) {

        require ROOT_PATH . "/app/views/users/" . $_SESSION['role'] . "/norminalrole_newuser.php";

    } else {

        exit;
    }
}





   public function norminalrole() {
        $page_name = "Norminal role";
         $GetThisModel = new User();
         $GetStateModelClass = new StateModel();
         $formation_id = $_SESSION['stateoforigin'];
    
          $serviceNo = $_SESSION['user_id'] ?? null;
            $web_settings = $GetThisModel->web_settings();
            $Personnel_details = $GetThisModel->getPersonnelDetailsByServiceNo($serviceNo);
        $seniority = $Personnel_details['seniority'];
        $officer_details = $Personnel_details['personnel_data'];
        $officers_name = $Personnel_details['officers_name'];
        
        if ($formation_id==911) {
            $stateoforiginname = "All";
        }else {
      $stateoforiginname = $GetStateModelClass->GetaParticularFormation($formation_id);
      $stateoforiginname = $stateoforiginname['name'];
        }
       
  if ($serviceNo && isset($_SESSION['role'])) {
            require ROOT_PATH . "/app/views/users/" . $_SESSION['role'] . "/norminalrole.php";
        } else {
            exit;
        }
   }
   public function staffdisposition() {
        $page_name = "Staff Disposition";
         $GetThisModel = new User();
         $GetStateModelClass = new StateModel();
         $formation_id = $_SESSION['stateoforigin'];
    
          $serviceNo = $_SESSION['user_id'] ?? null;
            $web_settings = $GetThisModel->web_settings();
            $Personnel_details = $GetThisModel->getPersonnelDetailsByServiceNo($serviceNo);
        $seniority = $Personnel_details['seniority'];
        $officer_details = $Personnel_details['personnel_data'];
        $officers_name = $Personnel_details['officers_name'];
        
        if ($formation_id==911) {
            $stateoforiginname = "All";
        }else {
      $stateoforiginname = $GetStateModelClass->GetaParticularFormation($formation_id);
      $stateoforiginname = $stateoforiginname['name'];
        }
       
  if ($serviceNo && isset($_SESSION['role'])) {
            require ROOT_PATH . "/app/views/users/" . $_SESSION['role'] . "/staffdisposition.php";
        } else {
            exit;
        }
   }











    /* ==========================
       UPDATE PROFILE PHOTO
    ========================== */
    public function updatePhoto(): void {
        $serviceNo = $this->serviceNo;
        if (!$serviceNo) {
            echo json_encode(['status'=>'error','message'=>'Unauthorized']);
            exit;
        }

        if (!isset($_FILES['photo'])) {
            echo json_encode(['status'=>'error','message'=>'No file uploaded']);
            exit;
        }

        $file = $_FILES['photo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status'=>'error','message'=>'Invalid file type']);
            exit;
        }

        $newName = "profile_{$serviceNo}_" . time() . "." . $ext;
        $dir = ROOT_PATH . "/app/views/uploads/img/profile/";
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $dest = $dir . $newName;

        if (move_uploaded_file($file['tmp_name'], $dest) &&
            $this->photoPasswordModel->updatePhoto($serviceNo, $newName)) {
            echo json_encode(['status'=>'success','filename'=>$newName]);
        } else {
            echo json_encode(['status'=>'error','message'=>'Upload failed']);
        }
        exit;
    }

    /* ==========================
       UPDATE PASSWORD
    ========================== */
    public function updatePassword(): void {
        $serviceNo = $this->serviceNo;
        if (!$serviceNo) {
            echo json_encode(['status'=>'error','message'=>'Unauthorized']);
            exit;
        }

        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if (!$password || $password !== $confirm || strlen($password)<6) {
            echo json_encode(['status'=>'error','message'=>'Invalid password']);
            exit;
        }

        $hashed = password_hash($password, PASSWORD_BCRYPT);

        if ($this->photoPasswordModel->updatePassword($serviceNo, $hashed)) {
            echo json_encode(['status'=>'success']);
        } else {
            echo json_encode(['status'=>'error','message'=>'Password update failed']);
        }
        exit;
    }

    /* ==========================
       GET LGAs
    ========================== */
    public function getLGAs() {
        $model = new StateModel();
        $lgas = $model->getLGAs($_GET['state_id'] ?? 0);
        echo json_encode($lgas);
    }

    /* ==========================
       VIEW MONTHLY REPORT
    ========================== */
    public function viewmonthlyreport() {
        $page_name = "Monthly report";
        $GetThisModel = new User();
        $reports = $GetThisModel->getAllReports();
        $allReports = $reports['all_records'] ?? [];

        $serviceNo = $_SESSION['user_id'] ?? null;
        $Personnel_details = $GetThisModel->getPersonnelDetailsByServiceNo($serviceNo);
        $seniority = $Personnel_details['seniority'] ?? '';
        $officer_details = $Personnel_details['personnel_data'] ?? '';
        $officers_name = $Personnel_details['officers_name'] ?? '';

        $web_settings = $GetThisModel->web_settings();

        if ($serviceNo && isset($_SESSION['role'])) {
            require ROOT_PATH . "/app/views/users/" . $_SESSION['role'] . "/monthlyreport_view.php";
        } else {
            exit;
        }
    }

    /* ==========================
       PAGE NOT FOUND
    ========================== */
    public function pagenotfound() {
        $page_name = "404 Error";
        require ROOT_PATH . "/app/views/pagenotfound.php";
    }

   
    /* ==========================
       LOGOUT
    ========================== */
    public function logout() {
        session_start();
        session_destroy();
        header("Location: index?action=login");
        exit;
    }

}