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


    public function web_settings()
    {
        $table_site_settings = "company";

        $stmt = $this->conn->prepare(
            "SELECT * FROM {$table_site_settings}"
        );

        $stmt->execute();

        $web_settings = $stmt->fetch(PDO::FETCH_ASSOC);

        return $web_settings;
    }



public function sendmail($receiveraddress, $subject, $message)
{
    try {

        // Get mail settings
        $settings = $this->web_settings();

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
            strtoupper($settings['company_name'] ?? 'AICSS')
        );

        // Receiver
        $mail->addAddress($receiveraddress);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;

        // Company name
        $companyName = htmlspecialchars(
            strtoupper($settings['company_name'] ?? 'AICSS'),
            ENT_QUOTES,
            'UTF-8'
        );

        // Banner image
        $logo = rtrim($settings['company_url'], '/')
            . "/views/uploads/img/"
            . $settings['company_banner'];

        /*
         * ---------------------------------------------------------
         * EMAIL HTML TEMPLATE
         * ---------------------------------------------------------
         */

        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            
        </head>

        <body style="
            margin:0;
            padding:0;
            background-color:#f4f6f8;
            font-family:Arial, Helvetica, sans-serif;
            color:#333333;
        ">

            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    background-color:#f4f6f8;
                    padding:30px 15px;
                "
            >

                <tr>
                    <td align="center">

                        <table
                            width="600"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                max-width:600px;
                                width:100%;
                                background-color:#ffffff;
                                border-radius:8px;
                                overflow:hidden;
                                box-shadow:0 2px 10px rgba(0,0,0,0.08);
                            "
                        >

                            <!-- =================================================
                                 HEADER BANNER
                            ================================================== -->
                            <tr>
                                <td
                                    align="center"
                                    style="
                                        padding:0;
                                        margin:0;
                                        border-bottom:1px solid #eeeeee;
                                    "
                                >

                                    <img
                                        src="' . $logo . '"
                                        alt=""
                                        width="1400"
                                        height="370"
                                        style="
                                            display:block;
                                            width:100%;
                                            max-width:1400px;
                                            height:auto;
                                            border:0;
                                            margin:0 auto;
                                            padding:0;
                                        "
                                    >

                                </td>
                            </tr>


                            <!-- =================================================
                                 CONTENT
                            ================================================== -->
                            <tr>
                                <td
                                    style="
                                        padding:35px 30px;
                                        font-size:15px;
                                        line-height:1.7;
                                        color:#333333;
                                    "
                                >

                                    ' . $message . '

                                </td>
                            </tr>


                            <!-- =================================================
                                 FOOTER
                            ================================================== -->
                            <tr>
                                <td
                                    align="center"
                                    style="
                                        padding:20px 30px;
                                        background-color:#f8f9fa;
                                        border-top:1px solid #eeeeee;
                                        color:#777777;
                                        font-size:12px;
                                        line-height:1.6;
                                    "
                                >

                                    <strong style="
                                        color:#131d3b;
                                        font-size:13px;
                                    ">
                                        ' . $companyName . '
                                    </strong>

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
?>
