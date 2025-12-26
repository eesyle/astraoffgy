<?php
 include 'codeForOther.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes from the local project directory to avoid document root mismatches
require_once __DIR__ . '/mail/Exception.php';
require_once __DIR__ . '/mail/PHPMailer.php';
require_once __DIR__ . '/mail/SMTP.php'; 

 
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
        $mail->isSMTP(); 
        $mail->Host = 'mail.holdlogix.live'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'info@holdlogix.live'; 
        $mail->Password = 'Obedofla@00';
        
        // Relaxed SSL Settings
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];
        
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465; 
    
        //Recipients
        $mail->setFrom('info@holdlogix.live', 'HoldLogix'); 
        $mail->addAddress('info@holdlogix.live', 'Admin'); 
        
        //Content
        $mail->isHTML(true);
        $mail->Subject = 'HoldLogix';
        
        $bodyContent = "Full Name: $username<br>Email: $email<br>BTC or USDT Address: $btcId<br>Refund Reason: $refundReasonText<br>Refund Category: $refundCategory";
        $mail->Body = $bodyContent;
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $bodyContent)); // Plain text version

        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $attachmentPath = $_FILES['file']['tmp_name'];
            $attachmentName = $_FILES['file']['name'];
            $mail->addAttachment($attachmentPath, $attachmentName);
        } else {
            echo 'Error: File upload failed';
            exit;
        }

        try {
            $mail->send();
        } catch (Exception $exSend) {
            // Fallback to TLS/587
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPAutoTLS = true;
            try {
                $mail->send();
            } catch (Exception $exSend2) {
                throw $exSend2;
            }
        }
        
        // Admin notification sent successfully; proceed to send user confirmation
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }



    try {
        //Server settings
        $mail = new PHPMailer(true);
        $mail->isSMTP(); 
        $mail->Host = 'mail.holdlogix.live'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'info@holdlogix.live'; 
        $mail->Password = 'Obedofla@00';
        
        // Relaxed SSL Settings
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];
        
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465; 
    
        //Recipients
        $mail->setFrom('info@holdlogix.live', 'HoldLogix');
        $mail->addAddress($email, $username); 
        
        //Content
        $mail->isHTML(true);
        $mail->Subject = 'HoldLogix';
        
        $userBody = "<p>Hello from HoldLogix</p>
        <p>Dear $username, your refund request has been received successfully.</p>
        <p>Your request will be processed within three days.</p>
        <p>Thank you for choosing HoldLogix.</p>";
        
        $mail->Body = $userBody;
        $mail->AltBody = "Hello from HoldLogix\n\nDear $username, your refund request has been received successfully.\nYour request will be processed within three days.\nThank you for choosing HoldLogix.";

        try {
            $mail->send();
        } catch (Exception $exSend) {
            // Fallback to TLS/587
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPAutoTLS = true;
            try {
                $mail->send();
            } catch (Exception $exSend2) {
                throw $exSend2;
            }
        }

        // Redirect to a styled confirmation page similar to sendtop
        header('Location: email-success.php?username=' . urlencode($username) . '&status=sent&type=refund');
        exit;
    } catch (Exception $e) {
       echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
    }






}

?>