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





public function createTicket(array $post, array $files): array{
    $uploadDir       = ROOT_PATH . "/views/uploads/ticket_library/";
    $uploadUrlPrefix = 'views/uploads/ticket_library/';
    $maxFileSize     = 992097152;
    $allowedExt      = ['gif','jpg','jpeg','png','zip','rar','csv','doc','docx','xls','xlsx','txt','pdf','mp4'];

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ticketId   = !empty($post['ticket_id']) ? $post['ticket_id'] : 'TKT-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
    $now        = date('Y-m-d H:i:s');
    $ticketDesc = trim($post['subject'] ?? 'Ticket attachments');
    $notify     = isset($post['notify']) ? 1 : 0;
    $show       = isset($post['show'])   ? 1 : 0;
    $uploads    = [];

    try {
        $this->conn->beginTransaction();

        // ---- ticket_reports ----
        $sql = "INSERT INTO ticket_reports (
                    ticket_id, date_created, date_updated, category, name, email,
                    priority, subject, message, phone_no, incidence_date,
                    incidence_source, state, community, local_government,
                    operator, zone, corridor, number_of_arrested_suspects,
                    vehicle_arrested_destroyed, wooden_boat_speed_boat_arrested_destroyed,
                    vessel_arrested_destroyed, location_coordinate_latitude,
                    location_coordinate_longitude,
                    quantity_of_crude_recovered_destroyed_ltr,
                    quantity_of_ago_recovered_destroyed_ltr,
                    quantity_of_pms_recovered_destroyed_ltr,
                    description_of_reported_incidence, notify, show, due_date
                ) VALUES (
                    :ticket_id, :date_created, :date_updated, :category, :name, :email,
                    :priority, :subject, :message, :phone_no, :incidence_date,
                    :incidence_source, :state, :community, :local_government,
                    :operator, :zone, :corridor, :n_suspects,
                    :veh, :boat, :vessel, :lat, :lng,
                    :qty_crude, :qty_ago, :qty_pms,
                    :description, :notify, :show, :due_date
                )";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ticket_id'        => $ticketId,
            ':date_created'     => $now,
            ':date_updated'     => 'Nil',
            ':category'         => $post['category']         ?? '',
            ':name'             => $post['name']             ?? '',
            ':email'            => $post['email']            ?? '',
            ':priority'         => $post['priority']         ?? '0',
            ':subject'          => $post['subject']          ?? '',
            ':message'          => $post['message']          ?? '',
            ':phone_no'         => $post['phone_no']         ?? null,
            ':incidence_date'   => $post['incidence_date']   ?? null,
            ':incidence_source' => $post['incidence_source'] ?? null,
            ':state'            => $post['state']            ?? null,
            ':community'        => $post['community']        ?? null,
            ':local_government' => $post['local_government'] ?? null,
            ':operator'         => $post['operator']         ?? null,
            ':zone'             => $post['zone']             ?? null,
            ':corridor'         => $post['corridor']         ?? null,
            ':n_suspects'       => (int)($post['number_of_arrested_suspects'] ?? 0),
            ':veh'              => (int)($post['vehicle_arrested_destroyed'] ?? 0),
            ':boat'             => (int)($post['wooden_boat_speed_boat_arrested_destroyed'] ?? 0),
            ':vessel'           => (int)($post['vessel_arrested_destroyed'] ?? 0),
            ':lat'              => $post['location_coordinate_latitude']  ?? '0',
            ':lng'              => $post['location_coordinate_longitude'] ?? '0',
            ':qty_crude'        => (float)($post['quantity_of_crude_recovered_destroyed_ltr'] ?? 0),
            ':qty_ago'          => (float)($post['quantity_of_ago_recovered_destroyed_ltr']   ?? 0),
            ':qty_pms'          => (float)($post['quantity_of_pms_recovered_destroyed_ltr']   ?? 0),
            ':description'      => $post['description_of_reported_incidence'] ?? null,
            ':notify'           => $notify,
            ':show'             => $show,
            ':due_date'         => !empty($post['due_date']) ? $post['due_date'] : null,
        ]);

        // ---- process uploads ----
        if (!empty($files['attachment']['name'])) {
            $names = $files['attachment']['name'];
            $tmps  = $files['attachment']['tmp_name'];
            $sizes = $files['attachment']['size'];
            $errs  = $files['attachment']['error'];

            for ($i = 1; $i <= 8; $i++) {
                if (empty($names[$i]) || $errs[$i] === UPLOAD_ERR_NO_FILE) continue;
                if ($errs[$i] !== UPLOAD_ERR_OK) throw new RuntimeException("Upload error on attachment #{$i}.");
                if ($sizes[$i] > $maxFileSize)   throw new RuntimeException("Attachment #{$i} too large.");

                $ext = strtolower(pathinfo($names[$i], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExt, true)) {
                    throw new RuntimeException("Attachment #{$i} extension .{$ext} not allowed.");
                }

                $base     = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($names[$i], PATHINFO_FILENAME));
                $filename = $ticketId . '_' . $i . '_' . substr($base, 0, 60) . '.' . $ext;
                $dest     = $uploadDir . $filename;

                if (!move_uploaded_file($tmps[$i], $dest)) {
                    throw new RuntimeException("Failed to save attachment #{$i}.");
                }

                $uploads[$i] = $uploadUrlPrefix . $filename;
            }
        }

        // ---- upload_library ----
        $stmtUp = $this->conn->prepare(
            "INSERT INTO upload_library (
                ticket_id, ticket_desc,
                upload1, upload2, upload3, upload4,
                upload5, upload6, upload7, upload8, status
            ) VALUES (
                :ticket_id, :ticket_desc,
                :u1, :u2, :u3, :u4, :u5, :u6, :u7, :u8, 1
            )"
        );
        $stmtUp->execute([
            ':ticket_id'   => $ticketId,
            ':ticket_desc' => $ticketDesc,
            ':u1' => $uploads[1] ?? '',
            ':u2' => $uploads[2] ?? '',
            ':u3' => $uploads[3] ?? '',
            ':u4' => $uploads[4] ?? '',
            ':u5' => $uploads[5] ?? '',
            ':u6' => $uploads[6] ?? '',
            ':u7' => $uploads[7] ?? '',
            ':u8' => $uploads[8] ?? '',
        ]);

        $this->conn->commit();

        return ['success' => true, 'ticket_id' => $ticketId, 'message' => 'Ticket created successfully.'];
    } catch (Throwable $e) {
        if ($this->conn->inTransaction()) {
            $this->conn->rollBack();
        }
        foreach ($uploads as $path) {
            if ($path && is_file($uploadDir . basename($path))) {
                @unlink($uploadDir . basename($path));
            }
        }
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}










public function CountAllTickets()
{
    try {
        $sql = "SELECT COUNT(*) AS total FROM tickets";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    } catch (PDOException $e) {
        return 0;
    }
}



public function UpdateUserMessage($data)
{
    try {

        $query = "UPDATE users 
                  SET msg = 1, 
                      msg_notification = :themessage 
                  WHERE userid = :userid";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':themessage', $data['themessage'], PDO::PARAM_STR);
        $stmt->bindParam(':userid', $data['userid'], PDO::PARAM_STR);

        return $stmt->execute();

    } catch (PDOException $e) {

        error_log("UpdateUserMessage Error: " . $e->getMessage());
        return false;

    }
}


public function updateuserpwd($data){
    try {

        $userid = $data['userid'];
        $old_password = $data['old_password'];
        $new_password = $data['new_password'];
        $verify_password = $data['verify_password'];

        if (empty($userid) || empty($new_password) || empty($verify_password)) {
            return "All password fields are required.";
        }

        if ($new_password !== $verify_password) {
            return "New password and verify password do not match.";
        }

        // Only check the old password if it was provided
        if ($old_password !== "") {

            $sql = "SELECT password FROM login WHERE userid = :userid LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return "User account not found.";
            }

            if (!password_verify($old_password, $user['password'])) {
                return "Old password is incorrect.";
            }
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql = "UPDATE login
                SET password = :password,
                    login_counts = CASE
                        WHEN login_counts = 0 THEN 1
                        ELSE login_counts
                    END
                WHERE userid = :userid
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Password updated successfully.";
        }

        return "Password could not be updated.";

    } catch (PDOException $e) {

        return $e->getMessage();

    }
}








public function GeneralSelectAnyTable($tb_name){
    try {
         $allowed_tables = [
        'audit_trail','company','corridor','incidence_source','lgas',
        'local_government_areas','login','operator','owner','pipeline',
        'pipeline_type','priority','report_type','request','states',
        'tickets','ticket_category','users','ticket_reports','wellhead_status','zone'
    ];


        if (!in_array($tb_name, $allowed_tables, true)) {
            return [];
        }

        $sql = "SELECT * FROM `{$tb_name}` ORDER BY sn DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log('SelecttableForSelectOptions error: ' . $e->getMessage());
        return [];
    }
}







public function GeneralUpdateAnyTableColumnWithThisValue($data)
{
    try {

        $the_tablename = $data['the_tablename'];
        $column_value  = $data['column_value'];
        $column_name   = $data['column_name'];
        $where_column  = $data['where_column'];
        $where_value   = $data['where_value'];

        $sql = "UPDATE `{$the_tablename}`
                SET `{$column_name}` = :column_value
                WHERE `{$where_column}` = :where_value";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':column_value', $column_value, is_int($column_value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        $stmt->bindValue(':where_value',  $where_value,  is_int($where_value)  ? PDO::PARAM_INT : PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }

        return false;

    } catch (PDOException $e) {
        error_log('GeneralUpdateAnyTable error: ' . $e->getMessage());
        return false;
    }
}




public function GeneralSelectAnyTableWhereColumnValueEquals($the_tablename, $column_name, $column_value)
{
    try {
        $allowed_tables = [
            'audit_trail','company','corridor','incidence_source','lgas',
            'local_government_areas','login','operator','owner','pipeline',
            'pipeline_type','priority','report_type','request','states',
            'tickets','ticket_category','ticket_reports','users','wellhead_status','zone'
        ];

        if (!in_array($the_tablename, $allowed_tables, true)) {
            return [];
        }

        // ✅ Validate column name: letters, numbers, underscore only
        if (!preg_match('/^[A-Za-z0-9_]+$/', $column_name)) {
            return [];
        }

        // ✅ Optional but stronger: check it exists in the table
        $check = $this->conn->prepare("SHOW COLUMNS FROM `{$the_tablename}` LIKE :col");
        $check->execute([':col' => $column_name]);
        if (!$check->fetch()) {
            return [];
        }

        $sql = "SELECT * FROM `{$the_tablename}` WHERE `{$column_name}` = :column_value ORDER BY sn DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':column_value', $column_value);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log('GeneralSelectAnyTable error: ' . $e->getMessage());
        return [];
    }
}





public function generateTicketId()
{
    try {
        $sql = "SELECT COALESCE(MAX(sn), 0) + 10234 AS ticket_id FROM `ticket_reports`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return 'tid-' . (int) $row['ticket_id'];

    } catch (PDOException $e) {
        error_log('generateTicketId error: ' . $e->getMessage());
        return null;
    }
}



public function updateLoginCount($userid)
{
    try {

        $sql = "UPDATE login 
                SET login_counts = COALESCE(login_counts, 0) + 1 
                WHERE userid = :userid";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);

        return $stmt->execute();

    } catch (PDOException $e) {
        return false;
    }
}






public function getLastLogin($userid)
{
    try {

        $sql = "SELECT last_login
                FROM login
                WHERE userid = :userid
                ORDER BY last_login DESC
                LIMIT 1 ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':userid' => $userid
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['last_login'] ?? null;

    } catch (PDOException $e) {

        return null;
    }
}




public function restorerecord()
{
    $status_value = 1;

    $restore_token = $_GET['token'] ?? '';

    $restore_data = json_decode(
        base64_decode($restore_token),
        true
    );

    $sn = $restore_data['sn'] ?? '';
    $table_name = $restore_data['table_name'] ?? '';
    $page_controller = $restore_data['page_controller'] ?? '';
    $user_name = $restore_data['user_name'] ?? '';

    $sql = "UPDATE `$table_name` SET status = :status_value WHERE sn = :sn";

    $stmt = $this->conn->prepare($sql);

    if ($stmt->execute([
        'status_value' => $status_value,
        'sn' => $sn
    ])) {
        return [
            'success' => true,
            'page_controller' => $page_controller,
            'user_name' => $user_name
        ];
    }

    return [
        'success' => false,
        'page_controller' => $page_controller,
        'user_name' => $user_name
    ];
}




public function SelectUsersAndLoginTableforOnePersonAfterLogin($user_id)
{
    try {

        $sql = "SELECT
            users.sn AS user_sn,
            users.corridor AS user_corridor,
            users.date AS user_date,
            users.title AS user_title,
            users.user_image AS user_image,
            users.userid AS user_userid,
            users.otp_request AS user_otp_request,
            users.email AS user_email,
            users.phone AS user_phone,
            users.msg AS user_msg,
            users.fullname AS user_fullname,
            users.status AS user_status,
            users.msg_notification AS user_msg_notification,

            login.sn AS login_sn,
            login.userid AS login_userid,
            login.password AS login_password,
            login.last_login AS login_last_login,
            login.login_counts AS login_counts,
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

        WHERE users.userid = :userid

        ORDER BY users.sn DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':userid' => $user_id
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {

            /*
             * Safely create abbreviated name.
             *
             * preg_split() removes empty elements, so names
             * containing multiple spaces will not cause
             * "Uninitialized string offset 0".
             */
            $user_fullname = trim($user['user_fullname'] ?? '');

            if ($user_fullname === '') {

                $AbrvName = 'User';

            } else {

                $parts = preg_split(
                    '/\s+/',
                    $user_fullname,
                    -1,
                    PREG_SPLIT_NO_EMPTY
                );

                $first = array_shift($parts);

                $AbrvName = $first ?: 'User';

                if (!empty($parts)) {

                    $initials = array_map(
                        fn($p) => strtoupper(mb_substr($p, 0, 1)),
                        $parts
                    );

                    $AbrvName .= ' ' . implode('.', $initials);
                }
            }

            $user['AbrvName'] = $AbrvName;

            return [
                'success' => true,
                'user' => $user
            ];
        }

        return [
            'success' => false,
            'user' => [],
            'error' => 'User not found.'
        ];

    } catch (PDOException $e) {

        return [
            'success' => false,
            'user' => [],
            'error' => $e->getMessage()
        ];
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









public function login($userid, $password) {
    $table_login = "login";

    $stmt = $this->conn->prepare(
        "SELECT * FROM {$table_login} WHERE userid = :userid LIMIT 1"
    );

    $stmt->bindParam(":userid", $userid);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return [
            'success' => false,
            'error'   => 'User ID does not exist'
        ];
    }

    if (!password_verify($password, $user['password'])) {
        return [
            'success' => false,
            'error'   => 'Incorrect password'
        ];
    }

    if ($user['status'] == 0) {
        return [
            'success' => false,
            'error'   => 'Your account is not active yet'
        ];
    }

    if ($user['status'] == 1) {

        $current_login_count = $user['login_counts'] ;

        if ($current_login_count > 0) {

            $new_login_count = $current_login_count + 1;

            $updateStmt = $this->conn->prepare(
                "UPDATE {$table_login}
                 SET login_counts = :login_counts
                 WHERE userid = :userid"
            );

            $updateStmt->execute([
                ':login_counts' => $new_login_count,
                ':userid'       => $userid
            ]);

            $user['login_counts'] = $new_login_count;
        }

        $lastLoginStmt = $this->conn->prepare(
            "UPDATE {$table_login}
             SET last_login = :last_login
             WHERE userid = :userid"
        );

        $lastLoginStmt->execute([
            ':last_login' => date('Y-m-d H:i:s'),
            ':userid'     => $userid
        ]);

        $user['last_login'] = date('Y-m-d H:i:s');

        return [
            'success' => true,
            'user'    => $user
        ];
    }

    return [
        'success' => false,
        'error'   => 'This account has been archived and is currently unavailable'
    ];
}






public function UserAddRequest($data)
{
    $sql = "INSERT INTO request 
            (ticket_no, response_department, ticket_userid, subject, complain, priority, date, ticketer_role, status) 
            VALUES 
            (:ticket_no, :response_department, :ticket_userid, :subject, :complain, :priority, :date, :ticketer_role, :status)";
    
    try {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ticket_no'           => $data['ticket_no'],
            ':response_department' => $data['response_department'],
            ':ticket_userid'       => $data['ticket_userid'],
            ':subject'             => $data['subject'],
            ':complain'            => $data['complain'],
            ':priority'            => $data['priority'],
            ':date'                => $data['date'],
            ':ticketer_role'       => $data['ticketer_role'],
            ':status'              => $data['status'],
        ]);
        
        return $this->conn->lastInsertId();
    } catch (PDOException $e) {
        // log or handle error
        return false;
    }
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



public function CreateUserAccount($data) {try {try {
     
    // Set Nigeria timezone (West Africa Time - UTC+1, no DST)
    date_default_timezone_set('Africa/Lagos');

    $company_userid = $data['company_userid'];
    $title          = $data['title'];
    $fullname       = $data['fullname'];
    $phone          = $data['phone'];
    $role           = $data['role'];
    $role_name      = $data['role_name'];
    $email          = $data['email'];
    $user_corridor  = $data['user_corridor'];

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

        $Role_comment = 1;
        $Role_create_report = 1;
    }

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
            'success'      => false,
            'password'     => null,
            'phone_exists' => true,
            'email_exists' => false,
            'error'        => null
        ];
    }

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

    $sql = "SELECT MAX(sn) AS last_sn FROM login";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $lastSn = $result['last_sn'] ?? 0;

    $userid = $company_userid + $lastSn;

    $action_token = bin2hex(random_bytes(5)) . $userid;

    $this->conn->beginTransaction();

    $password =
        chr(rand(65, 90)) .
        chr(rand(65, 90)) .
        rand(1000, 9999);

    $hashedPassword = password_hash(
        $phone,
        PASSWORD_DEFAULT
    );

    $sql = "
        INSERT INTO login (
            userid,
            password,
            role,
            role_name,
            status,
            action_token,
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
            :action_token,
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
        ':action_token'        => $action_token,
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

    $sql = "
        INSERT INTO users (
            status,
            title,
            fullname,
            phone,
            email,
            userid,
            corridor,
            date
        )
        VALUES (
            1,
            :title,
            :fullname,
            :phone,
            :email,
            :userid,
            :corridor,
            :date
        )
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':fullname' => $fullname,
        ':title'    => $title,
        ':phone'    => $phone,
        ':email'    => $email,
        ':userid'   => $userid,
        ':corridor' => $user_corridor,
        ':date'     => date('Y-m-d H:i:s')
    ]);

    $this->conn->commit();

    return [
        'success'      => true,
        'userid'       => $userid,
        'password'     => $password,
        'phone_exists' => false,
        'email_exists' => false,
        'error'        => null
    ];

} catch (PDOException $e) {

    if ($this->conn->inTransaction()) {
        $this->conn->rollBack();
    }

    return [
        'success'      => false,
        'password'     => null,
        'phone_exists' => false,
        'email_exists' => false,
        'error'        => $e->getMessage()
    ];
}} catch (PDOException $e) {

    if ($this->conn->inTransaction()) {
        $this->conn->rollBack();
    }

    return [
        'success'      => false,
        'password'     => null,
        'phone_exists' => false,
        'email_exists' => false,
        'error'        => $e->getMessage()
    ];
}}


}

















