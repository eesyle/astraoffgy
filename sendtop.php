<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'config.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$username = '';
if (isset($_SESSION['username']) && $_SESSION['username'] !== '') {
    $username = $_SESSION['username'];
} elseif (isset($_GET['username']) && $_GET['username'] !== '') {
    $username = $_GET['username'];
} else {
    echo "<script>alert('Error: Username not provided! Redirecting to login...');</script>";
    echo "<meta http-equiv='refresh' content='2;url=index.php'>";
    exit();
}

if ($conn->connect_error) {
    die("Fatal Error");
}  
$query = "SELECT * FROM users WHERE UserName='$username'";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
foreach ($query_run as $email1) {
    $email = $email1['Email'] ?? $email1['email'] ?? '';
    $balance = $email1['Balance'] ?? $email1['balance'] ?? 0;
    $password = $email1['PassWord'] ?? $email1['password'] ?? '';
}
}
// Read amount from GET/POST if provided; default to 0
$topp = 0;
if (isset($_GET['amount']) && is_numeric($_GET['amount'])) {
    $topp = (float)$_GET['amount'];
} elseif (isset($_POST['amount']) && is_numeric($_POST['amount'])) {
    $topp = (float)$_POST['amount'];
}
$query = "SELECT * FROM users WHERE UserName='$username'";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
foreach ($query_run as $email1) {
    $email = $email1['Email'] ?? $email1['email'] ?? '';
    $balance = $email1['Balance'] ?? $email1['balance'] ?? 0;
    $password = $email1['PassWord'] ?? $email1['password'] ?? '';
}
if (isset($_SESSION['trigger'])){
    $triger = $_SESSION['trigger'];
}
}
  
 
$theprice = $topp;
$randomPassword = generateRandomPassword();
$generatedCode = generateCode();
 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
     
require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

   

    try {
        $mail = new PHPMailer(true);

 
        $mail->SMTPDebug = 0; 
        $mail->isSMTP(); 
        $mail->Host = 'smtp.hostinger.com';  
        $mail->SMTPAuth = true; 
        $mail->Username = 'info@holdlogix.com'; //
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl';  
        $mail->Port = 465;  
    
       
        $mail->setFrom('info@holdlogix.com', 'HoldLogix');  
        $mail->addAddress($email, $username);  
         
        $mail->Subject = '[HoldLogix]  TRANSACTION CONFIRMATION';
        if($triger == "top"){
            $mail->Body = "<p>Hello from HoldLogix</p>
        <p>Dear ' . $username . ' You have topped up a balance of $'.$topp.' with HoldLogix</p>
        <p>Your transaction is pending; you will be informed via this email when complete</p>
        <p>Thank you for using HoldLogix</p>";
        }
        if($triger == "purchase"){
            $mail->Body = "  <p>Dear $username  Your purchase with reference $generatedCode of a price: $ $theprice
        Has been processed succefully. your transaction is pending you will be notified when complete
        </p>
        <p>Thank you for using HoldLogix</p>";
        }
        if($triger == "card"){
            $mail->Body = "  <p>Dear $username  You have just purchased a card of a price: $ $theprice
        Has been processed succefully. your transaction is pending you will be notified when complete
        </p>
        <p>Thank you for using HoldLogix</p>";
        }
        $mail->isHTML(true);  
       $query = "INSERT INTO users VALUES('','$email','$username','$password',NOW(),'$theprice','$balance','')";

                $result = $conn->query($query);

                if ($result) {
                    
                    $mail->send();
                } 
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }


    try {
        $mail = new PHPMailer(true);
 
        $mail->SMTPDebug = 0;  
        $mail->isSMTP(); 
        $mail->Host = 'smtp.hostinger.com'; 
        $mail->SMTPAuth = true;  
        $mail->Username = 'info@holdlogix.com'; 
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl';  
        $mail->Port = 465; 

         
        $mail->setFrom('info@holdlogix.com', 'HoldLogix');  
        $mail->addAddress('info@holdlogix.com', 'ADMIN');  
         
        $mail->isHTML(true); 
 
                $mail->Subject = '[HoldLogix]  TRANSACTION CONFIRMATION';

                if($triger == "top"){
                    $mail->Body = "<p>Hello from HoldLogix</p>
                    <p>User $username has just topped up a log $$theprice</p>
                    <p>$username's transaction is pending until modified</p>
                    <p>The attachment below is their purchase proof:</p>";
                }
                if($triger == "purchase"){
                    $mail->Body = "<p>Hello from HoldLogix</p>
        <p>User $username has just made a purchase of $$theprice</p>
        <p>$username's transaction is pending until modified</p>
        <p>The attachment below is their purchase proof:</p>";
                }

                if($triger == "card"){
                    $mail->Body = "<p>Hello from HoldLogix</p>
        <p>User $username has just bought a card of $$theprice</p>
        <p>$username's transaction is pending until modified</p>
        <p>The attachment below is their purchase proof:</p>";
                }

       
        
                 if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $attachmentPath = $_FILES['file']['tmp_name'];
    $attachmentName = $_FILES['file']['name'];
    $mail->addAttachment($attachmentPath, $attachmentName);
} else {
    echo 'Error: File upload failed';
    exit;
}

        $mail->send();
 

        header('Location: dash.php');
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }

}
function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_';
    $charLength = strlen($characters);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, $charLength - 1);
        $password .= $characters[$randomIndex];
    }
    return $password;
}