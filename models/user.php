<?php

// define('ROOT_PATH', dirname(__DIR__));


require_once ROOT_PATH . '/core/database.php';
require_once ROOT_PATH . '/models/company.php';

class User {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
       
    }



    public function login($userid,$password) {
        $table_login = "login";
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$table_login} WHERE userid = :userid LIMIT 1"
        );
        $stmt->bindParam(":userid", $userid);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        // ❌ user not found
        if (!$user) {
            return [
                'success' => false,
                'error'   => 'User ID does not exist'
            ];
        }

        // ❌ wrong password
        if (!password_verify($password, $user['password'])) {
            return [
                'success' => false,
                'error'   => 'Incorrect password'
            ];
        }

              // ✅ login success
        return [
            'success' => true,
            'user'    => $user
        ];
    }

   public function SelectOneUserAllData()
{
    if (!isset($_SESSION['userid'])) {
        return [
            'success' => false,
            'error'   => 'User is not logged in'
        ];
    }

    $userid = $_SESSION['userid'];

    $stmt = $this->conn->prepare(
        "SELECT * FROM users WHERE userid = :userid LIMIT 1"
    );

    $stmt->execute([
        ':userid' => $userid
    ]);

    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        return [
            'success' => false,
            'error'   => 'User ID does not exist'
        ];
    }

    return [
        'success' => true,
        'user'    => $userData
    ];
}



public function getRoleCounts()
{
    $sql = "SELECT
                SUM(role = 'developer') AS developers,
                SUM(role = 'reporter') AS reporters,
                SUM(role = 'supervisor') AS supervisors,
                SUM(role = 'administrator') AS administrators
            FROM login";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function TicketCount()
{
    $sql = "SELECT
                COUNT(*) AS total,
                SUM(status = 0) AS status_0,
                SUM(status = 1) AS status_1,
                SUM(status = 2) AS status_2
            FROM tickets";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getAParticularLoginUser($userid){
    $sql = "SELECT * FROM login WHERE userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userid);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result->fetch_assoc();
}


    
public function create_reporter($name, $email, $password, $phone, $affirmation)
{
    try {
  $callCompanyModel = new CompanyModel() ;
        // Get website/company settings
        $web_settings = $callCompanyModel->web_settings();
         //Reporter
         $Login_acess=1;

        $company_approvalstatus = $web_settings['company_acct_approval'];
        $company_userid  = $web_settings['company_userid'];

        $today = date('Y-m-d');

        $reporter_name        = trim($name);
        $reporter_email       = trim($email);
        $reporter_password    = $password;
        $reporter_phone       = trim($phone);
        $reporter_affirmation = (int) $affirmation;


        // =====================================================
        // CHECK IF PHONE OR EMAIL ALREADY EXISTS
        // =====================================================

        $sql = "SELECT phone, email
                FROM users
                WHERE phone = :phone
                   OR email = :email
                LIMIT 2";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':phone' => $reporter_phone,
            ':email' => $reporter_email
        ]);

        $existingRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $phoneExists = false;
        $emailExists = false;

        foreach ($existingRecords as $record) {

            if ($record['phone'] === $reporter_phone) {
                $phoneExists = true;
            }

            if ($record['email'] === $reporter_email) {
                $emailExists = true;
            }
        }


        // =====================================================
        // RETURN ERRORS IF PHONE OR EMAIL EXISTS
        // =====================================================

        if ($phoneExists || $emailExists) {

            return [
                'success'       => false,
                'phone_exists'  => $phoneExists,
                'email_exists'  => $emailExists
            ];
        }


        // =====================================================
        // GET LAST SERIAL NUMBER
        // =====================================================

        $sql = "SELECT MAX(sn) AS last_sn FROM users";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastSn = (int) ($result['last_sn'] ?? 0);

        // Generate new user ID
        $new_userid = $lastSn + (int) $company_userid;


        // =====================================================
        // START TRANSACTION
        // =====================================================

        $this->conn->beginTransaction();


        // =====================================================
        // INSERT USER
        // =====================================================

        $sql = "INSERT INTO users
                (userid, `date`, fullname, phone, email, affirmation)
                VALUES
                (:userid, :date, :fullname, :phone, :email, :affirmation)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':userid'      => $new_userid,
            ':date'        => $today,
            ':fullname'    => $reporter_name,
            ':phone'       => $reporter_phone,
            ':email'       => $reporter_email,
            ':affirmation' => $reporter_affirmation
        ]);


        // =====================================================
        // INSERT LOGIN CREDENTIALS
        // =====================================================

        $sql = "INSERT INTO login
                (userid, password, reporter, status)
                VALUES
                (:userid, :password, :reporter, :status)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':userid'   => $new_userid,
            ':password' => password_hash($reporter_password,PASSWORD_DEFAULT),
            ':reporter' => $Login_acess,
            ':status'   => $company_approvalstatus
        ]);


        // =====================================================
        // COMMIT
        // =====================================================

        $this->conn->commit();

        return [
            'success'       => true,
            'phone_exists'  => false,
            'email_exists'  => false
        ];


    } catch (PDOException $e) {

        if ($this->conn->inTransaction()) {
            $this->conn->rollBack();
        }

        error_log(
            "create_reporter error: " . $e->getMessage()
        );

        return [
            'success' => false,
            'error'   => true
        ];
    }
}


}
