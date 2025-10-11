<?php
require_once 'conkt.php';
 



$query = "SELECT * FROM users WHERE UserName='$username'";
$query_run = mysqli_query($conn, $query);
if(mysqli_num_rows($query_run)>0){
    foreach($query_run as $details)
    {
        $email = $details['Email'];
 
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php'; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data





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
        $mail->Username = 'logsstore@offgy.com'; //
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to
    
        //Recipients
        $mail->setFrom('logsstore@offgy.com', 'OFFGY LOGSSTORE'); //This is the email your form sends From
        $mail->addAddress('logsstore@offgy.com', 'Admin'); // Add a recipient address
        //Content
        
        $mail->isHTML(true); // Set 
        $mail->Subject = ' [OFFGY LOGSSTORE] Refund Request';
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
        $mail->Username = 'logsstore@offgy.com'; //
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to
    
        //Recipients
        $mail->setFrom('logsstore@offgy.com', 'OFFGY LOGSSTORE'); //This is the email your form sends From
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Request Form</title>
    <link rel="stylesheet" href="stylss.css">
</head>
<body>

    <div class="contact-section">
    <h1>REQUEST A REFUND</h1>
  <div class="border"></div>
    <form   class="contact-form" action="" method="post" enctype="multipart/form-data">
          <input type="text"  class="contact-form-text" id="fullname" name="fullname"  placeholder="Full Name" value="<?=$username?>" required>
            <input type="email" class="contact-form-text"  id="email" name="email" placeholder="Email address" value="<?=$email?>" required>     
            <input type="text" class="contact-form-text" id="btcId" name="btcId" placeholder="Your BTC or USDT address" required>
 
        <p class="contact-form-text" style="color: #757574; background-color: #37356B;"> upload payment screenshot: <input type="file" name="file" id="file" required></p>
         <select class="contact-form-text" id="category" name="category" required>
        <option value="" disabled selected>What is the reason for refund? click here to Choose from the dropdown menu</option>
        <option value="incorrect">The log info not correct</option>
        <option value="wrong">I did not get the log info</option>
        <option value="cancel">I need to cancel the the transaction</option>
        <option value="notReceived">I recieved the wrong log info</option>
        <option value="delay">Delay in receiving the log info</option>
        <option value="other">Other</option>
    </select>
    <button  class="contact-form-btn" type="submit" name ="submit">Submit Request</button>
    </form>
    </div>
</body>
</html>
