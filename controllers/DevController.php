<?php
require_once ROOT_PATH . '/models/dev.php';
// require_once ROOT_PATH . '/models/StateModel.php';
// require_once ROOT_PATH . '/models/PhotoPassword_Update.php';
// require_once ROOT_PATH . '/middleware/AuthMiddleware.php';
require_once ROOT_PATH . '/services/mailer.php';

class DevController {

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
    public function dashboard() {
  if (session_status() === PHP_SESSION_NONE) session_start();
  
  require ROOT_PATH . "/views/users/dev/dashboard.php";
  
  }

}



        
        

