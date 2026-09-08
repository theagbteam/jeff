
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

    public function updateCompanyDetails(array $data): array
{
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
                    SUM(role = 'developer') AS developers,
                    SUM(role = 'reporter') AS reporters,
                    SUM(role = 'supervisor') AS supervisors,
                    SUM(role = 'administrator') AS administrators
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
}

