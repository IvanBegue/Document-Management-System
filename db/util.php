<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/appfolder/Emailcomposer/vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function validate_input($data)
{
    // Sanitize Input
    $data = trim($data);
    $data = ltrim($data);
    $data = Rtrim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function sendEmail($em,$sub,$body,$receiverName,$ccEmail,$ccName)
{
    $mail = new PHPMailer(TRUE);
    
    try {
        /* Set the mail sender. */
        $mail->setFrom('evansbegue@gmail.com', 'evan'); //!Replace WITH UTM EMAIL
        /* Add a recipient. */
        $mail->addAddress($em,$receiverName); //*Receiver Info 

        if(isset($ccEmail) && isset($ccName))
        {
            // Add CC recipient
        $mail->addCC($ccEmail, $ccName);
        }


        
        $mail->Subject = $sub; //*Subject of Email
        /* Set the mail message body. */
        $mail->isHTML(TRUE);
        $mail->Body = $body;
    
        $mail->isSMTP();
        /* SMTP server address. */
        $mail->Host = 'smtp.gmail.com';
        /* Use SMTP authentication. */
        $mail->SMTPAuth = TRUE;
        /* Set the encryption system. */
        $mail->SMTPSecure = 'tls';
        /* SMTP authentication username. */
        $mail->Username = 'evansbegue@gmail.com';
        /* SMTP authentication password. */
        $mail->Password = 'uhemfobnrtlsuqsz';
        /* Set the SMTP port. */
        $mail->Port = 587;
        /* Finally send the mail. */
        $retval = $mail->send();
        
    } catch (Exception $e) {
        
        error_log($e->errorMessage());
    } catch (\Exception $e) {
        
    error_log($e->getMessage());
    }
}

?>