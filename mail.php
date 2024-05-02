<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/*// Include PHPMailer autoload file
require 'vendor/Phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';*/

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Set mailer to use SMTP
    $mail->isSMTP();

    // Specify Zoho SMTP server
    $mail->Host       = 'smtp.zoho.in';

    // Enable SMTP authentication
    $mail->SMTPAuth   = true;

    // Zoho SMTP username and password
    $mail->Username   = 'raj@proflujo.com';
    // $mail->Password   = '9Qp358JwzMJk';
    $mail->Password   = 'Q69WMJFkK4fq';

    // Set the encryption type
    $mail->SMTPSecure = 'TLS'; // Use 'ssl' if Zoho requires it

    // Set the SMTP port (Zoho uses 587 for TLS and 465 for SSL)
    $mail->Port       = 587;

    // Set sender and recipient details
    $mail->setFrom('raj@proflujo.com', 'Proflujo');
    $mail->addAddress('ajaykumar@proflujo.com', 'Ajaykumar');

    // Set email subject and body
    $mail->isHTML(true);
    $mail->Subject    = 'RI District 3232 Conference Sangamam 24';
    $mail->Body       = '
                        Dear Rtn/Ann/Annette {{Name}},<br><br>

                         

                        Thank you for registering for the Sangamam24 - the RID 3232 District Conference. Your registration number is XXXX.<br><br>

                         

                        We will be sending shortly out a soft copy of the Entry pass for the conference via email and WhatsApp.<br><br>

                         

                        In case of any difficulties, reach out to the registration team headed by Rtn. <b>A Kannan 99429 04699</b><br><br>

                         

                        Thank you,<br><br><br>

                         

                        Registration Team<br>

                        Sangamam24<br>

                        RID 3232 District Conference
                            ';

    // Send the email
    $mail->send();
    echo 'Email has been sent successfully';
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
