<?php
 include 'codeForOther.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php'; 

 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
 


    $username = $_POST['fullname']; // Assuming $username is set before this point
    $email = $_POST['email'];
    $btcId = $_POST['btcId'];
    
    
    
    $refundCategory = isset($_POST['category']) ? $_POST['category'] : '';
$refundReasonText = '';
switch ($refundCategory) {
    case 'incorrect':
        $refundReasonText = 'The log info is not correct';
        break;
    case 'wrong':
        $refundReasonText = 'I did not get the log info';
        break;
        case 'cancel':
            $refundReasonText = 'I need to cancel the the transaction';
            break;
            case 'notReceived':
                $refundReasonText = 'I received the wrong info';
                break;
                case 'delay':
                    $refundReasonText = 'Delay in receiving the info';
                    break;
    // ... (Add cases for other options)
    default:
        $refundReasonText = 'Other';
}

 
   
























































 
    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail = new PHPMailer(true);
        // ... (Your existing SMTP and email configuration)
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.hostinger.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'logsstore@offggy.com'; //
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to
    
        //Recipients
        $mail->setFrom('logsstore@offggy.com', ' offggy logsstore'); //This is the email your form sends From
        $mail->addAddress('logsstore@offggy.com', 'Admin'); // Add a recipient address
        //Content
        
        $mail->isHTML(true); // Set 
        $mail->Subject = ' [LOGS STORE] Refund Request';
   // Assuming $photoPath is the path to the uploaded image on your server
 $mail->Body = "Full Name: $username<br>Email: $email<br>BTC or USDT Address: $btcId<br>Refund Reason: $refundReasonText<br>Refund Category: $refundCategory";
        
 
           if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $attachmentPath = $_FILES['file']['tmp_name'];
    $attachmentName = $_FILES['file']['name'];
    $mail->addAttachment($attachmentPath, $attachmentName);
} else {
    echo 'Error: File upload failed';
    exit;
}
            
 


        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }



    try {
        //Server settings
        $mail = new PHPMailer(true);
        // ... (Your existing SMTP and email configuration)
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.hostinger.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'logsstore@offggy.com'; //
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to
    
        //Recipients
        $mail->setFrom('logsstore@offggy.com', 'OFFGY LOGSSTORE'); //This is the email your form sends From
        $mail->addAddress($email, $username); // Add a recipient address
        //Content
        
        $mail->isHTML(true); // Set 
        $mail->Subject = ' [LOGS STORE] Refund Request';
        $mail->Body = "<p>Hello from Log Store</p>
        <p>Dear $username  your request for refund has been received  successfully</p>
        <p>the request will be processed within three days</p>
        <p>Thank you for using Logs Store</p>";

        $mail->send();
       echo "<script> alert('Message sent');</script>";
    } catch (Exception $e) {
       
               echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
 
    }






}

?>