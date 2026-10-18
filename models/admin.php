
<?php

require_once ROOT_PATH . '/core/database.php';

class ModelAdmin
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function web_settings()
    {
        $table_site_settings = "company";

        $stmt = $this->conn->prepare(
            "SELECT * FROM {$table_site_settings}"
        );

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



public function InsertTransferHistory($data)
{
    try {
        $sql = "INSERT INTO transfer_history (
                    refid,
                    user_transfered,
                    from_corridor,
                    to_corridor,
                    transfer_initilizer,
                    date_transfered,
                    expected_resumption_date,
                    reason,
                    status
                ) VALUES (
                    :refid,
                    :user_transfered,
                    :from_corridor,
                    :to_corridor,
                    :transfer_initilizer,
                    :date_transfered,
                    :expected_resumption_date,
                    :reason,
                    :status
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':refid'                   => $data['refid'],
            ':user_transfered'          => $data['user_transfered'],
            ':from_corridor'            => $data['from_corridor'],
            ':to_corridor'              => $data['to_corridor'],
            ':transfer_initilizer'      => $data['transfer_initilizer'],
            ':date_transfered'          => $data['date_transfered'],
            ':expected_resumption_date' => $data['expected_resumption_date'],
            ':reason'                   => $data['reason'],
            ':status'                   => $data['status']
        ]);

    } catch (PDOException $e) {
        error_log("InsertTransferHistory Error: " . $e->getMessage());
        return false;
    }
}




public function GetWellheadStatusCounts()
{
    try {
        $sql = "SELECT
                    ws.sn,
                    ws.name,
                    ws.color,
                    COUNT(t.status_name) AS total
                FROM wellhead_status ws
                LEFT JOIN tickets t
                    ON t.status_name = ws.name
                GROUP BY ws.sn, ws.name, ws.color
                ORDER BY ws.sn ASC
                LIMIT 6";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return [];
    }
}






    

public function UpdateUserAccount($data){
try {

    $this->conn->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | USERS TABLE
    |--------------------------------------------------------------------------
    */

    $sqlUsers = "
        UPDATE users SET
            title = :title,
            fullname = :fullname,
            email = :email,
            phone = :phone,
            msg_notification = :msg_notification,
            msg = :msg,
            user_image = :user_image,
            status = :status
        WHERE userid = :userid
        LIMIT 1
    ";

    $stmtUsers = $this->conn->prepare($sqlUsers);

    $stmtUsers->bindValue(':title', $data['title'], PDO::PARAM_STR);
    $stmtUsers->bindValue(':fullname', $data['fullname'], PDO::PARAM_STR);
    $stmtUsers->bindValue(':email', $data['email'], PDO::PARAM_STR);
    $stmtUsers->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
    $stmtUsers->bindValue(':msg_notification', $data['msg_notification'], PDO::PARAM_INT);
    $stmtUsers->bindValue(':msg', $data['msg'], PDO::PARAM_STR);
    $stmtUsers->bindValue(':user_image', $data['user_image'], PDO::PARAM_STR);
    $stmtUsers->bindValue(':status', $data['status'], PDO::PARAM_INT);
    $stmtUsers->bindValue(':userid', $data['userid'], PDO::PARAM_STR);

    $stmtUsers->execute();


    /*
    |--------------------------------------------------------------------------
    | LOGIN TABLE
    |--------------------------------------------------------------------------
    */

    $sqlLogin = "
        UPDATE login SET
            role = :role,
            Role_edit_user = :Role_edit_user,
            Role_create_user = :Role_create_user,
            Role_delete_user = :Role_delete_user,
            Role_approve_user = :Role_approve_user,
            Role_create_report = :Role_create_report,
            Role_approve_report = :Role_approve_report,
            Role_edit_report = :Role_edit_report,
            Role_delete_report = :Role_delete_report,
            Role_comment = :Role_comment,
            status = :status
        WHERE userid = :userid
        LIMIT 1
    ";

    $stmtLogin = $this->conn->prepare($sqlLogin);

    $stmtLogin->bindValue(':role', $data['role'], PDO::PARAM_STR);
    $stmtLogin->bindValue(':Role_edit_user', $data['Role_edit_user'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':Role_create_user', $data['Role_create_user'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':Role_delete_user', $data['Role_delete_user'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':Role_approve_user', $data['Role_approve_user'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':Role_create_report', $data['Role_create_report'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':Role_approve_report', $data['Role_approve_report'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':Role_edit_report', $data['Role_edit_report'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':Role_delete_report', $data['Role_delete_report'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':Role_comment', $data['Role_comment'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':status', $data['status'], PDO::PARAM_INT);
    $stmtLogin->bindValue(':userid', $data['userid'], PDO::PARAM_STR);

    $stmtLogin->execute();


    /*
    |--------------------------------------------------------------------------
    | COMMIT
    |--------------------------------------------------------------------------
    */

    $this->conn->commit();

    return true;

} catch (PDOException $e) {

    if ($this->conn->inTransaction()) {
        $this->conn->rollBack();
    }

    return false;
}


}



public function CreateCorridorAndThoseSimilar($data = []){
    try {
        // Extract variables from the data array
        $corridor_name = $data['corridor_name'] ?? '';
        $userid        = $data['userid'] ?? '';
        $role          = $data['role'] ?? '';
        $the_tb        = $data['the_tb'] ?? '';
        $color         = $data['color'] ?? '';
        $maxrecords    = $data['maxrecords'] ?? 0;

        $date_created = date('Y-m-d H:i:s');

        // Count records in the table first
        $sql_count = "SELECT COUNT(*) AS total FROM {$the_tb}";
        $stmt_count = $this->conn->prepare($sql_count);
        $stmt_count->execute();
        $count_row = $stmt_count->fetch(PDO::FETCH_ASSOC);

        if ((int)$count_row['total'] > (int)$maxrecords) {
            return [
                'status' => false,
                'message' => "you cannot create more than  $maxrecords here"
            ];
        }

        $sql_check = "SELECT name FROM {$the_tb} WHERE name = :name LIMIT 1";

        $stmt_check = $this->conn->prepare($sql_check);

        $stmt_check->execute([
            ':name' => $corridor_name
        ]);

        $existing_corridor = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existing_corridor) {
            return [
                'status' => false,
                'message' => 'This record already exists'
            ];
        }

        $sql_user = "SELECT fullname FROM users WHERE userid = :userid LIMIT 1";

        $stmt_user = $this->conn->prepare($sql_user);

        $stmt_user->execute([
            ':userid' => $userid
        ]);

        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

        $creator_name = $user['fullname'] ?? '';

        // Check if the table has a "color" column
        $hasColorColumn = false;
        $sql_col_check = "SHOW COLUMNS FROM {$the_tb} LIKE 'color'";
        $stmt_col_check = $this->conn->prepare($sql_col_check);
        $stmt_col_check->execute();

        if ($stmt_col_check->fetch(PDO::FETCH_ASSOC)) {
            $hasColorColumn = true;
        }

        if ($hasColorColumn) {
            $sql = "INSERT INTO {$the_tb}
                    (name, creator_userid, creator_name, creator_role, date_created, status, color)
                    VALUES
                    (:name, :creator_userid, :creator_name, :creator_role, :date_created, :status, :color)";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':name' => $corridor_name,
                ':creator_userid' => $userid,
                ':creator_name' => $creator_name,
                ':creator_role' => $role,
                ':date_created' => $date_created,
                ':status' => 1,
                ':color' => $color
            ]);
        } else {
            $sql = "INSERT INTO {$the_tb}
                    (name, creator_userid, creator_name, creator_role, date_created, status)
                    VALUES
                    (:name, :creator_userid, :creator_name, :creator_role, :date_created, :status)";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':name' => $corridor_name,
                ':creator_userid' => $userid,
                ':creator_name' => $creator_name,
                ':creator_role' => $role,
                ':date_created' => $date_created,
                ':status' => 1
            ]);
        }

        return [
            'status' => true,
            'message' => 'Record created successfully'
        ];

    } catch (PDOException $e) {
        return [
            'status' => false,
            'message' => 'Unable to create record'
        ];
    }
}



    
    public function updateCompanyDetails(array $data): array{
    $sn = 1;

    $sql = "UPDATE company SET
        company_url = :company_url,
        company_logfile_url = :company_logfile_url,
        company_userid = :company_userid,
        company_signup = :company_signup,
        company_status = :company_status,
        company_acct_approval = :company_acct_approval,
        company_auto_ticketing = :company_auto_ticketing,
        company_map = :company_map,
        company_name = :company_name,
        company_alias = :company_alias,
        company_email = :company_email,
        company_phone = :company_phone,
        company_phone2 = :company_phone2,
        company_address = :company_address,
        company_address2 = :company_address2,
        company_care = :company_care,
        company_care2 = :company_care2,
        company_copyright = :company_copyright,
        company_copyrightlink = :company_copyrightlink,
        company_poweredby = :company_poweredby,
        company_logo = COALESCE(:company_logo, company_logo),
        company_favicon = COALESCE(:company_favicon, company_favicon)
        WHERE sn = :sn";

    try {
        $stmt = $this->conn->prepare($sql);

        $companyLogo = $data['company_logo'] ?? null;
        $companyFavicon = $data['company_favicon'] ?? null;

        $success = $stmt->execute([
            ':company_url' => $data['company_url'],
            ':company_logfile_url' => $data['company_logfile_url'],
            ':company_userid' => $data['company_userid'],
            ':company_signup' => $data['company_signup'],
            ':company_status' => $data['company_status'],
            ':company_acct_approval' => $data['company_acct_approval'],
            ':company_auto_ticketing' => $data['company_auto_ticketing'],
            ':company_map' => $data['company_map'],
            ':company_name' => $data['company_name'],
            ':company_alias' => $data['company_alias'],
            ':company_email' => $data['company_email'],
            ':company_phone' => $data['company_phone'],
            ':company_phone2' => $data['company_phone2'],
            ':company_address' => $data['company_address'],
            ':company_address2' => $data['company_address2'],
            ':company_care' => $data['company_care'],
            ':company_care2' => $data['company_care2'],
            ':company_copyright' => $data['company_copyright'],
            ':company_copyrightlink' => $data['company_copyrightlink'],
            ':company_poweredby' => $data['company_poweredby'],
            ':company_logo' => $companyLogo,
            ':company_favicon' => $companyFavicon,
            ':sn' => $sn
        ]);

        if ($success) {
            return [
                'success' => true,
                'message' => 'Company details updated successfully.'
            ];
        }

        return [
            'success' => false,
            'message' => 'Failed to update company details.'
        ];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ];
    }
}











// public function SelectUsersAndLoginTableForDev($userid) {
//         try {
//             $excluded_role = "developer";
//             $sql = "SELECT
//                         users.sn AS user_sn,
//                         users.date AS user_date,
//                         users.title AS user_title,
//                         users.user_image AS user_image,
//                         users.otp_request AS user_otp_request,
//                         users.userid AS user_userid,
//                         users.email AS user_email,
//                         users.phone AS user_phone,
//                         users.msg AS user_msg,
//                         users.fullname AS user_fullname,
//                         users.status AS user_status,
//                         users.msg_notification AS user_msg_notification,

//                         login.sn AS login_sn,
//                         login.userid AS login_userid,
//                         login.password AS login_password,
//                         login.last_login AS login_last_login,
//                         login.role AS login_role,
//                         login.role_name AS login_role_name,
//                         login.Role_edit_user AS login_edit_user,
//                         login.Role_create_user AS login_create_user,
//                         login.Role_delete_user AS login_delete_user,
//                         login.Role_approve_user AS login_approve_user,
//                         login.Role_create_report AS login_create_report,
//                         login.Role_approve_report AS login_approve_report,
//                         login.Role_edit_report AS login_edit_report,
//                         login.Role_delete_report AS login_delete_report,
//                         login.Role_comment AS login_comment,
//                         login.status AS login_status

//                     FROM users

//                     LEFT JOIN login
//                         ON users.userid = login.userid

//                     WHERE users.userid != :userid AND  login.role != :excluded_role

//                     ORDER BY users.sn DESC";

//             $stmt = $this->conn->prepare($sql);

//             $stmt->execute([
//                 ':userid' => $userid,
//                 ':excluded_role' => $excluded_role
//             ]);

//             return $stmt->fetchAll(PDO::FETCH_ASSOC);

//         } catch (PDOException $e) {
//             return [];
//         }
        
//     }





    public function SelectAllCategoryOfUsersAndLoginTableForAdmin($userid) {
        try {

$login_active   = 1;
$login_inactive = 0;

$baseSql = "SELECT
                users.sn AS user_sn,
                users.corridor AS user_corridor,
                users.date AS user_date,
                users.title AS user_title,
                users.user_image AS user_image,
                users.otp_request AS user_otp_request,
                users.userid AS user_userid,
                users.email AS user_email,
                users.phone AS user_phone,
                users.msg AS user_msg,
                users.fullname AS user_fullname,
                users.status AS user_status,
                users.msg_notification AS user_msg_notification,

                login.sn AS login_sn,
                login.status AS login_status,
                login.userid AS login_userid,
                login.password AS login_password,
                login.last_login AS login_last_login,
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
                login.Role_comment AS login_comment

            FROM users

            LEFT JOIN login
                ON users.userid = login.userid

            WHERE users.userid != :userid
              AND login.status IN (:login_active, :login_inactive)

            ORDER BY users.sn DESC";

$stmt = $this->conn->prepare($baseSql);
$stmt->execute([
    ':userid'         => $userid,
    ':login_active'   => $login_active,
    ':login_inactive' => $login_inactive,
]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Bucket rows in one pass — O(n) instead of 4 queries
$results = [
    'administrator' => [],
    'reporter'      => [],
    'supervisor'    => [],
    'all'           => [],
];

foreach ($rows as $row) {
    $role = strtolower(trim($row['login_role'] ?? ''));

    // Exclude developers from the "all" category
    if ($role !== 'developer') {
        $results['all'][] = $row;
    }

    // Keep role-specific categories unchanged
    if (isset($results[$role]) && $role !== 'all') {
        $results[$role][] = $row;
    }
}

return $results;} catch (PDOException $e) {
    return [];
}}







    

public function SelectUsersAndrequestTable(){
try {
$sql = "SELECT


                request.sn AS ticket_sn,
                request.ticket_no AS ticket_no,
                request.ticket_userid AS ticket_userid,
                request.complain AS ticket_complain,
                request.subject AS ticket_subject,
                request.priority AS ticket_priority,
                request.date AS ticket_date,
                request.category AS ticket_category,
                request.status AS ticket_status,

users.sn AS user_sn,
users.date AS user_date,
users.title AS user_title,
users.user_image AS user_image,
users.userid AS user_userid,
users.email AS user_email,
users.phone AS user_phone,
users.msg AS user_msg,
users.fullname AS user_fullname,
users.status AS user_status


            FROM request

            LEFT JOIN users
                ON request.ticket_userid = users.userid 

            ORDER BY request.sn DESC";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    return [];
}


}

public function requestReply($data)
{
    $sn     = $data['sn'];
    $status = $data['status'];

    $sql = "UPDATE request 
            SET status = :status 
            WHERE sn = :sn";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindValue(':status', $status, PDO::PARAM_INT);
    $stmt->bindValue(':sn', $sn, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return true;
    }

    return false;
}








public function EraseRecord($table_name_token, $sn_token){
    try {

        $table_name = base64_decode($table_name_token, true);
        $sn = base64_decode($sn_token, true);

        if ($table_name === false || $sn === false) {
            return "Invalid token";
        }

        $table_name = trim($table_name);
        $sn = trim($sn);

        $allowed_tables = [
            'corridor',
            'incidence_source',
            'operator',
            'owner',
            'pipeline',
            'pipeline_type',
            'priority',
            'zone',
            'wellhead_status',
            'ticket_category',
            'report_type'
        ];

        if (!in_array($table_name, $allowed_tables, true)) {
            return "Invalid table name";
        }

        if ($sn === '' || !preg_match('/^[0-9]+$/', $sn)) {
            return "Invalid record ID";
        }

        $sn = (int) $sn;

        if ($sn <= 0) {
            return "Invalid record ID";
        }

        $sql = "DELETE FROM `{$table_name}` WHERE sn = :sn LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':sn' => $sn
        ]);

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return "Record not found";

    } catch (PDOException $e) {

        return "Unable to delete record";

    }
}











public function clearlog($userid, $password, $company_logfile_url)
{
    try {

        $sql = "SELECT password FROM login WHERE userid = :userid LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "Invalid password.";
        }

        if (!password_verify($password, $user['password'])) {
            return "Invalid username or password.";
        }

        $clear = $this->conn->prepare("DELETE FROM audit_trail");
        $clear->execute();

        file_put_contents($company_logfile_url, '');

        return "Log file and Audit trail cleared successfully.";

    } catch (PDOException $e) {

        return "An error occurred while clearing the Log trail.";

    }
}





public function SelectCorridorsAndThoseSimilar($tb_name)
{
    try {

        $allowed_tables = [
            'corridor',
            'incidence_source',
            'operator',
            'owner',
            'pipeline',
            'pipeline_type',
            'priority',
            'zone',
            'wellhead_status',
            'ticket_category',
            'report_type'
        ];

        if (!in_array($tb_name, $allowed_tables, true)) {
            return [];
        }

        $sql = "SELECT * FROM `{$tb_name}` ORDER BY date_created DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        return [];

    }
}

public function getLoginStatusCounts(){
    try {
        $sql = "SELECT
                    SUM(CASE WHEN login_status = -1 THEN 1 ELSE 0 END) AS deleted,
                    SUM(CASE WHEN login_status = 1  THEN 1 ELSE 0 END) AS active,
                    SUM(CASE WHEN login_status = 0  THEN 1 ELSE 0 END) AS inactive
                FROM login";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return [
            'deleted' => 0,
            'active'  => 0,
            'inactive' => 0
        ];
    }
}


  public function StatusCount(){
    $sql = "SELECT
                COUNT(*) AS total,
                SUM(status = 0) AS inactive,
                SUM(status = 1) AS active,
                SUM(status = -1) AS deleted
            FROM login
            WHERE role <> :role";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['role' => 'developer']);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function TicketCount()    {
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
}

