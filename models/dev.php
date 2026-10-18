
<?php

require_once ROOT_PATH . '/core/database.php';

class ModelDev
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


public function updateMailerDetails(array $data): array
{
    $sn = 1;

    $sql = "UPDATE company SET
        company_mailer_host = :company_mailer_host,
        company_mailer_email = :company_mailer_email,
        company_mailer_port = :company_mailer_port,
        company_mailer_password = :company_mailer_password,
        company_mailer_secure = :company_mailer_secure,
        company_banner = :company_banner
        WHERE sn = :sn";

    try {
        $stmt = $this->conn->prepare($sql);

        $success = $stmt->execute([
            ':company_mailer_host' => $data['company_mailer_host'],
            ':company_mailer_email' => $data['company_mailer_email'],
            ':company_mailer_port' => $data['company_mailer_port'],
            ':company_mailer_password' => $data['company_mailer_password'],
            ':company_mailer_secure' => $data['company_mailer_secure'],
            ':company_banner' => $data['company_banner'],
            ':sn' => $sn
        ]);

        if ($success) {
            return [
                'success' => true,
                'message' => 'Mailer settings updated successfully.'
            ];
        }

        return [
            'success' => false,
            'message' => 'Failed to update mailer settings.'
        ];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Failed to update mailer settings.'
        ];
    }
}




  public function getRoleCounts()
{
    $sql = "SELECT
                SUM(CASE WHEN role = 'developer'     THEN 1 ELSE 0 END) AS developers,
                SUM(CASE WHEN role = 'reporter'      THEN 1 ELSE 0 END) AS reporters,
                SUM(CASE WHEN role = 'supervisor'    THEN 1 ELSE 0 END) AS supervisors,
                SUM(CASE WHEN role = 'administrator' THEN 1 ELSE 0 END) AS administrators
            FROM login";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function GetRequestSum(){
        $sql = "SELECT COUNT(*) AS total FROM request";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
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

public function WipeDevDatabaseWithExceptions()
{
    try {
        // Tables that are fully preserved — never touched
        $preserveEntirely = [
            'states',
            'lgas',
            ];

        // Tables to wipe, in child→parent order (so FKs, if added later, stay happy)
        $wipeTables = [
           'ticket_category',
            'request',
            'report_type',
            'priority',
            'pipeline',
            'pipeline_type',
            'wellhead_status',
            'incidence_source',
            'audit_trail',
            'owner',
            'operator',
            'corridor',
            'zone',
            // 'login' and 'users' and 'company' handled specially below
        ];

        $this->conn->exec("SET FOREIGN_KEY_CHECKS = 0");

        // 1. Wipe the simple tables completely
        foreach ($wipeTables as $table) {
            if (in_array($table, $preserveEntirely, true)) {
                continue;
            }
            $this->conn->exec("TRUNCATE TABLE `{$table}`");
        }

        // 2. COMPANY — delete everything except sn = 1
        $this->conn->exec("DELETE FROM `company` WHERE `sn` <> 1");

        // 3. LOGIN — delete every row whose role is NOT developer/administrator
        //    (case-insensitive, and catches variants like "Developer", "ADMINISTRATOR")
        $this->conn->exec(
            "DELETE FROM `login`
             WHERE LOWER(`role`) NOT LIKE '%developer%'
               AND LOWER(`role`) NOT LIKE '%administrator%'"
        );

        // 4. USERS — delete every user whose userid is NOT tied to a surviving
        //    login row (i.e., keep only users that still have a login as dev/admin)
        $this->conn->exec(
            "DELETE FROM `users`
             WHERE `userid` NOT IN (SELECT `userid` FROM `login`)"
        );

        $this->conn->exec("SET FOREIGN_KEY_CHECKS = 1");

        return true;

    } catch (PDOException $e) {
        // Re-enable FK checks even on failure
        try { $this->conn->exec("SET FOREIGN_KEY_CHECKS = 1"); } catch (PDOException $e2) {}

        error_log('WipeDevDatabaseWithExceptions error: ' . $e->getMessage());
        return false;
    }
}




    public function SelectAllCategoryOfUsersAndLoginTableForDev($userid) {
    try {
        
        $baseSql = "SELECT
                        users.sn AS user_sn,
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
                        login.Role_comment AS login_comment,
                        login.status AS login_status

                    FROM users

                    LEFT JOIN login
                        ON users.userid = login.userid

                    WHERE users.userid != :userid

                    ORDER BY users.sn DESC";

        $stmt = $this->conn->prepare($baseSql);
        $stmt->execute([':userid' => $userid]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Bucket rows in one pass — O(n) instead of 4 queries
        $results = [
            'administrator' => [],
            'reporter'      => [],
            'supervisor'    => [],
            'all'           => $rows,
        ];

        foreach ($rows as $row) {
            $role = $row['login_role'] ?? null;
            if (isset($results[$role]) && $role !== 'all') {
                $results[$role][] = $row;
            }
        }

        return $results;

    } catch (PDOException $e) {
        return [];
    }
}






    

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















    public function TicketCount()
    {
        $sql = "SELECT
                    COUNT(*) AS total,
                    SUM(status = 0) AS status_0,
                    SUM(status = 1) AS status_1,
                    SUM(status = 2) AS status_2
                FROM ticket_reports";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

