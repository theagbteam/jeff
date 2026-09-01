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







 public function SelectUsersTable() {
        try {

            $sql = "SELECT *
                    FROM users
                    ORDER BY sn DESC
                    LIMIT 10";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

            return [];
        }
    }




public function clearMsgNotification($userid) {
    $stmt = $this->conn->prepare(
        "UPDATE users 
         SET msg_notification = 0 
         WHERE userid = :userid"
    );

    $stmt->bindParam(":userid", $userid);
    return $stmt->execute();
}







public function SelectUsersAndLoginTable()
{
    try {

        $sql = "SELECT
                    users.sn AS user_sn,
                    users.date AS user_date,
                    users.title AS user_title,
                    users.user_image AS user_image,
                    users.userid AS user_userid,
                    users.email AS user_email,
                    users.phone AS user_phone,
                    users.msg AS user_msg,
                    users.fullname AS user_fullname,
                    users.status AS user_status,

                    login.sn AS login_sn,
                    login.userid AS login_userid,
                    login.password AS login_password,
                    login.last_login AS login_last_login,
                    login.level AS login_level,
                    login.role AS login_role,
                    login.role_name AS login_role_name,
                    login.Role_edit_user AS login_edit_user,
                    login.Role_create_user AS login_create_user,
                    login.Role_delete_user AS login_delete_user,
                    login.Role_approve_user AS login_approve_user,
                    login.Role_create_report AS login_create_report,
                    login.Role_approve_report AS login_approve_report,
                    login.Role_edit_report AS login_edit_report,
                    login.Role_delete_report AS login_delete_report,
                    login.Role_comment AS login_comment,
                    login.status AS login_status

                FROM users
                LEFT JOIN login
                    ON users.userid = login.userid

                ORDER BY users.sn DESC
                ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        return [];
    }
}








public function login($userid, $password) {
    $table_login = "login";

    $stmt = $this->conn->prepare(
        "SELECT * FROM {$table_login} WHERE userid = :userid LIMIT 1"
    );

    $stmt->bindParam(":userid", $userid);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // User not found
    if (!$user) {
        return [
            'success' => false,
            'error'   => 'User ID does not exist'
        ];
    }

    // Wrong password
    if (!password_verify($password, $user['password'])) {
        return [
            'success' => false,
            'error'   => 'Incorrect password'
        ];
    }

    // Account status
    if ($user['status'] == 0) {
        return [
            'success' => false,
            'error'   => 'Your account is not active yet'
        ];
    }

    if ($user['status'] == 1) {
        // Account is active, proceed with login
        return [
            'success' => true,
            'user'    => $user
        ];
    }

    // Any other status = deleted
    return [
        'success' => false,
        'error'   => 'This account has been archived and is currently unavailable'
    ];
}




   public function SelectUserTableForOne($userid){
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




function getAParticularLoginUser($userid){
    $sql = "SELECT * FROM login WHERE userid = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $userid);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result->fetch_assoc();
}


   
    public function CreateUserAccount(
        $company_userid,
        $title,
        $fullname,
        $phone,
        $role,
        $role_name,
        $email
    ) {
        try {

            $status = 1;

            $Role_comment =
            $Role_create_user =
            $Role_approve_user =
            $Role_delete_user =
            $Role_edit_user =
            $Role_create_report =
            $Role_delete_report =
            $Role_edit_report =
            $Role_approve_report = 0;


            // =====================================================
            // SET ROLE PERMISSIONS
            // =====================================================

            if ($role == "administrator") {

                $Role_comment =
                $Role_create_user =
                $Role_approve_user =
                $Role_delete_user =
                $Role_edit_user =
                $Role_create_report =
                $Role_delete_report =
                $Role_edit_report =
                $Role_approve_report = 1;

            } elseif ($role == "supervisor") {

                $Role_comment = 1;
                $Role_create_report = 1;
                $Role_approve_report = 1;

            } else {

                // Reporter
                $Role_comment = 1;
                $Role_create_report = 1;
            }


            // =====================================================
            // CHECK IF PHONE ALREADY EXISTS
            // =====================================================

            $sql = "
                SELECT userid
                FROM users
                WHERE phone = :phone
                LIMIT 1
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':phone' => $phone
            ]);

            $phoneExists = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($phoneExists) {

                return [
                    'success'     => false,
                    'password'    => null,
                    'phone_exists' => true,
                    'email_exists' => false,
                    'error'       => null
                ];
            }


            // =====================================================
            // CHECK IF EMAIL ALREADY EXISTS
            // =====================================================

            $sql = "
                SELECT userid
                FROM users
                WHERE email = :email
                LIMIT 1
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':email' => $email
            ]);

            $emailExists = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($emailExists) {

                return [
                    'success'      => false,
                    'password'     => null,
                    'phone_exists' => false,
                    'email_exists' => true,
                    'error'        => null
                ];
            }


            // =====================================================
            // GET LAST SN FROM LOGIN TABLE
            // =====================================================

            $sql = "SELECT MAX(sn) AS last_sn FROM login";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);


            $lastSn = $result['last_sn'] ?? 0;

            $userid = $company_userid + $lastSn;


            // =====================================================
            // START TRANSACTION
            // =====================================================

            $this->conn->beginTransaction();


            // =====================================================
            // GENERATE PASSWORD
            // 2 LETTERS + 4 NUMBERS
            // =====================================================

            $password =
                chr(rand(65, 90)) .
                chr(rand(65, 90)) .
                rand(1000, 9999);


            // =====================================================
            // HASH PASSWORD
            // =====================================================

            $hashedPassword = password_hash(
                $phone,
                PASSWORD_DEFAULT
            );


            // =====================================================
            // INSERT INTO LOGIN TABLE
            // =====================================================

            $sql = "
                INSERT INTO login (
                    userid,
                    password,
                    role,
                    role_name,
                    status,
                    Role_comment,
                    Role_create_user,
                    Role_approve_user,
                    Role_delete_user,
                    Role_edit_user,
                    Role_create_report,
                    Role_delete_report,
                    Role_edit_report,
                    Role_approve_report
                )
                VALUES (
                    :userid,
                    :password,
                    :role,
                    :role_name,
                    :status,
                    :Role_comment,
                    :Role_create_user,
                    :Role_approve_user,
                    :Role_delete_user,
                    :Role_edit_user,
                    :Role_create_report,
                    :Role_delete_report,
                    :Role_edit_report,
                    :Role_approve_report
                )
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':userid'              => $userid,
                ':password'            => $hashedPassword,
                ':role'                => $role,
                ':role_name'           => $role_name,
                ':status'              => $status,
                ':Role_comment'        => $Role_comment,
                ':Role_create_user'    => $Role_create_user,
                ':Role_approve_user'   => $Role_approve_user,
                ':Role_delete_user'    => $Role_delete_user,
                ':Role_edit_user'      => $Role_edit_user,
                ':Role_create_report'  => $Role_create_report,
                ':Role_delete_report'  => $Role_delete_report,
                ':Role_edit_report'    => $Role_edit_report,
                ':Role_approve_report' => $Role_approve_report
            ]);


            // =====================================================
            // INSERT INTO USERS TABLE
            // =====================================================

            $sql = "
                INSERT INTO users (
                    status,
                    title,
                    fullname,
                    phone,
                    email,
                    userid,
                    date
                )
                VALUES (
                    1,
                    :title,
                    :fullname,
                    :phone,
                    :email,
                    :userid,
                    :date
                )
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':fullname' => $fullname,
                ':title' => $title,
                ':phone'    => $phone,
                ':email'    => $email,
                ':userid'   => $userid,
                ':date'     => date('Y-m-d H:i:s')
            ]);


            // =====================================================
            // COMMIT TRANSACTION
            // =====================================================

            $this->conn->commit();


            // =====================================================
            // SUCCESS
            // =====================================================

            return [
                'success'      => true,
                'password'     => $password,
                'phone_exists' => false,
                'email_exists' => false,
                'error'        => null
            ];


        } catch (PDOException $e) {


            // =====================================================
            // ROLLBACK IF TRANSACTION IS ACTIVE
            // =====================================================

            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }


            // =====================================================
            // RETURN DATABASE ERROR
            // =====================================================

            return [
                'success'      => false,
                'password'     => null,
                'phone_exists' => false,
                'email_exists' => false,
                'error'        => $e->getMessage()
            ];
        }
    }
}






















