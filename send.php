<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 
require_once 'conkt.php';
if(isset($_GET['username'])) {
    $username = $_GET['username'];
}  
if (isset($_GET['wfprice'])) {
    $wfprice = $_GET['wfprice'];
} else {
    $wfprice = 0; // Set a default value if not provided
}
 
if (isset($_GET['dw'])) {
    $WoodForest = $_GET['dw'];
} else {
    $WoodForest = " offgy logsstore"; // Set a default value if not provided
}

if ($conn->connect_error) {
    die("Fatal Error");
}
 

$query = "SELECT * FROM users WHERE UserName='$username'";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
foreach ($query_run as $email1) {
    $email = $email1['Email'];
     $balance = $email1['Balance'];
    $password = $email1['PassWord'];
}
}
  
$thbank = $WoodForest;
$theprice = $wfprice;
$randomPassword = generateRandomPassword();
$generatedCode = generateCode();


// Define constants for email addresses
define('EMAIL_ADDRESS_1', $email);
define('EMAIL_ADDRESS_2', 'logsstore@offggy.com');

// Set up an array of email addresses and corresponding bodies
$emailAddresses = [
    EMAIL_ADDRESS_1 => "<p>Offggy Logsstore <br> YOUR LOG $generatedCode-$thbank ORDER

    </p>
        <p>Dear $username  Your purchase with reference $generatedCode of a price: $ $theprice
        Has been processed succefully. your transaction is pending you will be notified when complete
        </p>
        <p>Thank you for using Logs Store</p>",
      // Add more email addresses and bodies as needed
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
     
require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

   

    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;  
        $mail->isSMTP();  
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
        $mail->Subject = '[Offggy Logsstore]  TRANSACTION CONFIRMATION';
        $mail->isHTML(true); // Set 
    

        // Set different email bodies based on email address
       $query = "INSERT INTO users VALUES('','$email','$username','$password',NOW(),'$theprice','$balance','')";

        foreach ($emailAddresses as $emailAddress => $body) {
            if ($email === $emailAddress) {
                $mail->Body = $body;
                
                $result = $conn->query($query);

                if ($result) {
                    
                    $mail->send();
                    // Add any additional logic here if needed
                } else {
                    echo "Error: " . $conn->error;
                }
            }
        }
       $url ='history2.php?username='.$username.'&status=pending';

        header('location:'.$url);
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }


    try {
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

        // Recipients
        $mail->setFrom('logsstore@offggy.com', 'Offggy Logsstore'); // This is the email your form sends From
        $mail->addAddress('logsstore@offggy.com', 'ADMIN'); // Add a recipient address
        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = '[Offggy Logsstore]  TRANSACTION CONFIRMATION';

        $mail->Body = "<p>Hello from Offggy Logsstore</p>
        <p>User $username  Has just purchased a log $$theprice in $thbank Bank</p>
        <p>$username's transaction is pending until modified</p>
        <p>The attachment below is their purchase proof:</p>";
        
                 if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $attachmentPath = $_FILES['file']['tmp_name'];
    $attachmentName = $_FILES['file']['name'];
    $mail->addAttachment($attachmentPath, $attachmentName);
} else {
    echo 'Error: File upload failed';
    exit;
}

        $mail->send();
        $url ='history2.php?username='.$username.'&status=pending';

        header('location:'.$url);
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

function generateCode() {
    $randomNumber = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $code = "##" . $randomNumber;
    return $code;
}
if (isset($_GET['status']) && $_GET['status'] === 'pending') {
    $buttonLabel = 'Pending';
    $disableSubmit = true;
} else {
    $buttonLabel = 'Done';
    $disableSubmit = false;
}
?>