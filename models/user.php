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


    
//Select state and corresponding LGA
    public function getStates(){
        $stmt = $this->conn->prepare("SELECT * FROM states ORDER BY state_name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLgasByState($state_id){
        $stmt = $this->conn->prepare("SELECT * FROM lgas WHERE state_id = ? ORDER BY lga_name ASC");
        $stmt->execute([$state_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public static function createpersonnel() {
        return [

            /*
            |--------------------------------------------------------------------------
            | PERSONAL INFORMATION (STEP 1)
            |--------------------------------------------------------------------------
            */
            'bio_data' => [
                'surname'         => trim($_POST['surname'] ?? ''),
                'firstname'      => trim($_POST['first_name'] ?? ''),
                'middlename'     => trim($_POST['middle_name'] ?? ''),
                'dob'             => trim($_POST['dob'] ?? ''),
                'gender'          => trim($_POST['gender'] ?? ''),
                'marital_status'  => trim($_POST['marital_status'] ?? ''),
                'qualification'   => (int) ($_POST['qualification'] ?? 0),
                'discipline'      => trim($_POST['discipline'] ?? ''),
                'complexion'      => trim($_POST['complexion'] ?? ''),
                'eye_color'       => trim($_POST['eye_color'] ?? ''),
                'blood_group'     => trim($_POST['bg'] ?? ''),
                'genotype'        => trim($_POST['genotype'] ?? ''),
                'height'          => trim($_POST['height'] ?? ''),
                'weight'          => trim($_POST['weight'] ?? ''),
                'chest'           => (int)($_POST['chest'] ?? ''),
                'disability'      => (int)($_POST['disability'] ?? ''),
                'stateoforigin'           => (int) ($_POST['state'] ?? 0),
                'LgaOfOrigin'             => trim($_POST['lga'] ?? ''),
                'hometown'        => trim($_POST['hometown'] ?? ''),
                'email'           => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
                'phone'           => trim($_POST['phone'] ?? ''),
                'address'         => trim($_POST['address'] ?? ''),
                'img'        => $_FILES['passport'] ?? null,
                'signature'       => $_FILES['signature'] ?? null,
                'service_no'      => trim($_POST['service_no'] ?? ''),
                'rank'          => (int) ($_POST['c_rank'] ?? 0),
                'salary_scale'    => trim($_POST['salary_scale'] ?? ''),
                'bank'            => (int) ($_POST['bank'] ?? 0),
                'acct_number'     => trim($_POST['acct_number'] ?? ''),
                'pension_name'    => (int) ($_POST['pension_name'] ?? 0),
                'pen_number'      => trim($_POST['pen_number'] ?? ''),
                'ippis_no'        => trim($_POST['ippis_no'] ?? ''),
                'tin_no'          => trim($_POST['tin_no'] ?? ''),
                'stateofduty'     => (int) ($_POST['c_formation'] ?? 0),
                'current_dept'            => (int) ($_POST['dept'] ?? 0),
                'Lga_Posting'     => trim($_POST['ecowas_unit'] ?? ''),
                'dofa'            => trim($_POST['dofa'] ?? ''),
                'docf'            => trim($_POST['docf'] ?? ''),
                'dor'             => trim($_POST['dor'] ?? ''),
                'rafa'             => trim($_POST['rafa'] ?? ''),
                
            ],


            /*
            |--------------------------------------------------------------------------
            | SERVICE DETAILS (STEP 2)
            |--------------------------------------------------------------------------
            */
            'promotion_data' => [
                 'service_no'      => trim($_POST['service_no'] ?? ''),
                'dopa'            => trim($_POST['dopa'] ?? ''),
               
            ],



               /*
            |--------------------------------------------------------------------------
            | POSTING HISTORY (STEP 2)
            |--------------------------------------------------------------------------
            */
            'posting_data' => [
                             // Last Formation 1
                'service_no'      => trim($_POST['service_no'] ?? ''),
                'from_where'   => trim($_POST['last_cmd_fmt1'] ?? ''),
                'to_where'   => trim($_POST['last_cmd_fmt2'] ?? ''),
                'date'       => trim($_POST['fmt2_to'] ?? ''),
                'posting_type'       => trim("external"),
                ],


                'posting_data2' => [
                             // Last Formation 1
                'service_no'      => trim($_POST['service_no'] ?? ''),
                'last_cmd_fmt1'   => trim($_POST['last_cmd_fmt1'] ?? ''),
                'fmt1_from'       => trim($_POST['fmt1_from'] ?? ''),
                'fmt1_to'         => trim($_POST['fmt1_to'] ?? ''),

                // Last Formation 2
                'last_cmd_fmt2'   => trim($_POST['last_cmd_fmt2'] ?? ''),
                'fmt2_from'       => trim($_POST['fmt2_from'] ?? ''),
                'fmt2_to'         => trim($_POST['fmt2_to'] ?? ''),
            ],




            /*
            |--------------------------------------------------------------------------
            | NEXT OF KIN DATA
            |--------------------------------------------------------------------------
            */
            'next_of_kin' => [
                'service_no'      => trim($_POST['service_no'] ?? ''),
                'nok1_name'         => trim($_POST['nok1_name'] ?? ''),
                'nok1_relationship' => trim($_POST['nok1_relationship'] ?? ''),
                'nok1_gender'       => trim($_POST['nok1_gender'] ?? ''),
                'nok1_dob'          => trim($_POST['nok1_dob'] ?? ''),
                'nok1_phone'        => trim($_POST['nok1_phone'] ?? ''),
                'nok1_address'      => trim($_POST['nok1_address'] ?? ''),
                'nok2_name'         => trim($_POST['nok2_name'] ?? ''),
                'nok2_relationship' => trim($_POST['nok2_relationship'] ?? ''),
                'nok2_gender'       => trim($_POST['nok2_gender'] ?? ''),
                'nok2_dob'          => trim($_POST['nok2_dob'] ?? ''),
                'nok2_phone'        => trim($_POST['nok2_phone'] ?? ''),
                'nok2_address'      => trim($_POST['nok2_address'] ?? ''),
              
            ],


            /*
            |--------------------------------------------------------------------------
            | DECLARATION (STEP 4)
            |--------------------------------------------------------------------------
            */
            'declaration' => [

                'declare' => isset($_POST['declare']) ? 1 : 0,
            ]
        ];
    }




//Get personnel login details by service number
public function getPersonnelDetailsByServiceNo(string $serviceNo): array|false{
    $table_personnel = "personnel";

    $sql = "
        SELECT *
        FROM {$table_personnel}
        WHERE service_no = :service_no
        LIMIT 1
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':service_no', $serviceNo, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }

    // Prepare initials
    $firstInitial  = !empty($user['firstname']) 
        ? strtoupper($user['firstname'][0]) . '.' 
        : '';

    $middleInitial = !empty($user['middlename']) 
        ? ' ' . strtoupper($user['middlename'][0]) . '.' 
        : '';

    // Arrange name based on seniority
    if ((int)$user['seniority'] === 1) {
        $officersName = $firstInitial . $middleInitial . ' ' . $user['surname'];
    } else {
        $officersName = $user['surname'] . ' ' . $firstInitial . $middleInitial;
    }

    // Return structured result
    return [
        'seniority'      => (int)$user['seniority'],
        'personnel_data' => $user,
        'officers_name'  => trim($officersName),
    ];
}






// Model to load monthly report

public function getAllReports(){

    $table_mr = "monthly_report";
     $currentYear = date('Y');
    $currentmonth = date("m");

    // 1️⃣ Get All Report Records For SHQ Admin USer
    if (isset($_SESSION['stateoforigin']) && $_SESSION['stateoforigin'] === 911) {
       
    $queryAll = "SELECT sn, for_what_month, year_of_report, dept, submitted_by, date_submitted 
                 FROM " . $table_mr . " ORDER BY date_submitted DESC";

                     $stmtAll = $this->conn->prepare($queryAll);
    $stmtAll->execute();
    $allRecords = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
 // 2️⃣ Get All current YEAR records For SHQ Admin USer  
       $queryYear = "SELECT sn, for_what_month, year_of_report, dept, submitted_by, date_submitted 
                  FROM " . $table_mr . " 
                  WHERE year_of_report = :year AND for_what_month = :monthoftheyear
                  ORDER BY date_submitted DESC";

    $stmtYear = $this->conn->prepare($queryYear);
    $stmtYear->bindParam(':year', $currentYear);
    $stmtYear->bindParam(':monthoftheyear', $currentmonth);
    $stmtYear->execute();
    $yearRecords = $stmtYear->fetchAll(PDO::FETCH_ASSOC);

    }else{
        
    // 1️⃣  Get Report Records By State Of Origin
         $stateoforigin = (int) $_SESSION['stateoforigin'];
  $queryAll = "SELECT sn, for_what_month, year_of_report, dept, submitted_by, date_submitted 
                 FROM " . $table_mr . "  WHERE stateoforigin =:stateoforigin
                 ORDER BY date_submitted DESC";
$stmtAll = $this->conn->prepare($queryAll);
$stmtAll->bindValue(':stateoforigin', $stateoforigin, PDO::PARAM_STR);
$stmtAll->execute(); 
$allRecords = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

 // 2️⃣ Get CURRENT YEAR records by state of origin
   

    $queryYear = "SELECT sn, for_what_month, year_of_report, dept, submitted_by, date_submitted 
                  FROM " . $table_mr . " 
                  WHERE year_of_report = :year AND for_what_month = :monthoftheyear AND stateoforigin=:stateoforigin
                  ORDER BY date_submitted DESC";

    $stmtYear = $this->conn->prepare($queryYear);
    $stmtYear->bindParam(':stateoforigin', $stateoforigin);
    $stmtYear->bindParam(':year', $currentYear);
    $stmtYear->bindParam(':monthoftheyear', $currentmonth);
    $stmtYear->execute();
    $yearRecords = $stmtYear->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3️⃣ Return BOTH results
    return [
        'all_records' => $allRecords,
        'current_year_month' => $yearRecords
    ];
}





    
// Select all sections/units and their corresponding SN value
// Code Unused : Select all NIS commands and their corresponding SN value
    public function getAllCommands() {
        $query = "SELECT sn, rank FROM ranks ORDER BY sn ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
