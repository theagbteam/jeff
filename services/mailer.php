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



    public function sendmail($receiveraddress, $subject, $message) {
        try {

            // Get mail settings
            // $settings = $this->web_settings();
            $user = new User();
            $settings = $user->web_settings();

            $mail = new PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = $settings['company_mailer_host'];
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = $settings['company_mailer_secure'];
            $mail->Port       = $settings['company_mailer_port'];

            // SMTP login
            $mail->Username = $settings['company_mailer_email'];
            $mail->Password = $settings['company_mailer_password'];

            // Sender
            $mail->setFrom(
                $settings['company_mailer_email'],
                $settings['company_name'] ?? 'AICSS'
            );

            // Receiver
            $mail->addAddress($receiveraddress);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;

            // Company information
            $companyName = htmlspecialchars(
                $settings['company_name'] ?? 'AICSS',
                ENT_QUOTES,
                'UTF-8'
            );

            // Your company logo URL
            $logo = ROOT_PATH . "/views/uploads/img/" . $settings['company_logo'];

            // HTML email template
            $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <title>' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</title>
            </head>

            <body style="
                margin:0;
                padding:0;
                background-color:#f4f6f8;
                font-family:Arial, Helvetica, sans-serif;
                color:#333333;
            ">

                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background-color:#f4f6f8; padding:30px 15px;">

                    <tr>
                        <td align="center">

                            <table width="600" cellpadding="0" cellspacing="0" border="0"
                                style="
                                    max-width:600px;
                                    width:100%;
                                    background:#ffffff;
                                    border-radius:8px;
                                    overflow:hidden;
                                    box-shadow:0 2px 10px rgba(0,0,0,0.08);
                                ">

                                <!-- Header -->
                                <tr>
                                    <td align="center"
                                        style="
                                            padding:30px 20px;
                                            background-color:#ffffff;
                                            border-bottom:1px solid #eeeeee;
                                        ">

                                        <img
                                            src="' . $logo . '"
                                            alt="' . $companyName . '"
                                            style="
                                                max-width:180px;
                                                max-height:80px;
                                                display:block;
                                                margin:auto;
                                            "
                                        >

                                    </td>
                                </tr>

                                <!-- Content -->
                                <tr>
                                    <td style="
                                        padding:35px 30px;
                                        font-size:15px;
                                        line-height:1.7;
                                    ">

                                        ' . $message . '

                                    </td>
                                </tr>

                                <!-- Footer -->
                                <tr>
                                    <td align="center"
                                        style="
                                            padding:20px 30px;
                                            background-color:#f8f9fa;
                                            border-top:1px solid #eeeeee;
                                            color:#777777;
                                            font-size:12px;
                                            line-height:1.6;
                                        ">

                                        <strong>' . $companyName . '</strong>
                                        <br>
                                        This is an automated email. Please do not reply
                                        if you do not expect a response.

                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                </table>

            </body>
            </html>
            ';

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
