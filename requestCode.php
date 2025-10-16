<?php
 include 'codeForOther.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes from the local project directory to avoid document root mismatches
require __DIR__ . '/mail/Exception.php';
require __DIR__ . '/mail/PHPMailer.php';
require __DIR__ . '/mail/SMTP.php'; 

 
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

// If user selected Other and provided a custom reason, use it
if ($refundCategory === 'other' && isset($_POST['other_reason'])) {
    $custom = trim($_POST['other_reason']);
    if ($custom !== '') {
        // Basic sanitization; PHPMailer will escape content appropriately
        $refundReasonText = 'Other: ' . htmlspecialchars($custom, ENT_QUOTES, 'UTF-8');
    }
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
        $mail->Username = 'info@holdlogix.com'; // updated sender account
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to
    
        //Recipients
        $mail->setFrom('info@holdlogix.com', 'HoldLogix'); // updated branding
        $mail->addAddress('info@holdlogix.com', 'Admin'); // send to HoldLogix
        //Content
        
        $mail->isHTML(true);
        $mail->Subject = 'HoldLogix';
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
        // Admin notification sent successfully; proceed to send user confirmation
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
        $mail->Username = 'info@holdlogix.com'; // updated sender account
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to
    
        //Recipients
        $mail->setFrom('info@holdlogix.com', 'HoldLogix');
        $mail->addAddress($email, $username); // Add a recipient address
        //Content
        
        $mail->isHTML(true);
        $mail->Subject = 'HoldLogix';
        $mail->Body = "<p>Hello from HoldLogix</p>
        <p>Dear $username, your refund request has been received successfully.</p>
        <p>Your request will be processed within three days.</p>
        <p>Thank you for choosing HoldLogix.</p>";

        $mail->send();
        // Redirect to a styled confirmation page similar to sendtop
        header('Location: email-success.php?username=' . urlencode($username) . '&status=sent&type=refund');
        exit;
    } catch (Exception $e) {
       
               echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
 
    }






}

?>