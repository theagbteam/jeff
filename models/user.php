<?php

// define('ROOT_PATH', dirname(__DIR__));


require_once ROOT_PATH . '/core/database.php';

class User {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
       
    }




// All site settings data
public function web_settings() {
$table_site_settings = "company";
    $stmt = $this->conn->prepare(
        "SELECT * FROM {$table_site_settings}"
    );
    $stmt->execute();

    // return $stmt->fetch(PDO::FETCH_ASSOC);
    $web_settings = $stmt->fetch(PDO::FETCH_ASSOC);
    return $web_settings;
}



    public function login($userid, $password, $role) {
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

        // ❌ invalid role column
        if (!array_key_exists($role, $user)) {
            return [
                'success' => false,
                'error'   => 'Invalid role selected'
            ];
        }

        // ❌ no access for selected role
        if ((int)$user[$role] !== 1) {
            return [
                'success' => false,
                'error'   => "You do not have access as {$role}"
            ];
        }

        // ✅ login success
        return [
            'success' => true,
            'user'    => $user
        ];
    }




    
public function create_reporter($name, $email, $password, $phone, $affirmation)
{
    try {

        // Get website/company settings
        $web_settings = $this->web_settings();
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
