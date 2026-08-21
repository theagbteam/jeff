<?php

require_once ROOT_PATH . '/core/database.php';
require_once ROOT_PATH . '/models/User.php';
require_once ROOT_PATH . '/services/mailer/PHPMailer.php';
require_once ROOT_PATH . '/services/mailer/SMTP.php';
require_once ROOT_PATH . '/services/mailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


//    public function web_settings() {
// $table_site_settings = "company";
//     $stmt = $this->conn->prepare(
//         "SELECT * FROM {$table_site_settings}"
//     );
//     $stmt->execute();

//     // return $stmt->fetch(PDO::FETCH_ASSOC);
//     $web_settings = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $web_settings;
// }



    public function sendmail($receiveraddress, $subject, $message) {
        try {

            // Get mail settings
            // $settings = $this->web_settings();
            $user = new User();
            $settings = $user->web_settings();

            $mail = new PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = $settings['company_email_host'];
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = $settings['company_email_secure'];
            $mail->Port       = $settings['company_email_port'];

            // SMTP login
            $mail->Username = $settings['company_email_username'];
            $mail->Password = $settings['company_email_password'];

            // Sender
            $mail->setFrom(
                $settings['company_email_from'],
                $settings['company_name'] ?? 'AICSS'
            );

            // Receiver
            $mail->addAddress($receiveraddress);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Plain-text alternative
            $mail->AltBody = strip_tags($message);

            // Send email
            return $mail->send();

        } catch (Exception $e) {

            error_log('Mailer Error: ' . $e->getMessage());

            return false;
        }
    }
}