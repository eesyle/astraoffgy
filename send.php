<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 
require_once 'conkt.php';
// Ensure session and robust username fallback
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$username = (isset($_POST['username']) && $_POST['username'] !== '')
    ? $_POST['username']
    : ((isset($_GET['username']) && $_GET['username'] !== '')
        ? $_GET['username']
        : ((isset($_SESSION['username']) && $_SESSION['username'] !== '') ? $_SESSION['username'] : 'User'));
// Default email to avoid undefined warnings and to use requested address
$email = 'info@holdlogix.com';
// Initialize user-related defaults to prevent undefined variable warnings
$userEmailFromDb = null;
$balance = '';
$password = '';
if (isset($_POST['wfprice'])) {
    $wfprice = $_POST['wfprice'];
} elseif (isset($_GET['wfprice'])) {
    $wfprice = $_GET['wfprice'];
} else {
    $wfprice = 0; // Set a default value if not provided
}
 
if (isset($_POST['dw'])) {
    $WoodForest = $_POST['dw'];
} elseif (isset($_GET['dw'])) {
    $WoodForest = $_GET['dw'];
} else {
    $WoodForest = "HoldLogix";
}
// Optional custom message from admin for completion notifications
$customMessage = isset($_POST['custom_message']) ? trim($_POST['custom_message']) : '';

if ($conn->connect_error) {
    die("Fatal Error");
}
 

$query = "SELECT * FROM users WHERE username='$username'";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $email1) {
        // Keep user data available; $email remains set to requested address for sending
        $userEmailFromDb = isset($email1['email']) ? $email1['email'] : null;
        $balance = isset($email1['balance']) ? $email1['balance'] : '';
        $password = isset($email1['password']) ? $email1['password'] : '';
    }
}
  
$thbank = $WoodForest;
$theprice = $wfprice;
$randomPassword = generateRandomPassword();
$generatedCode = generateCode();


// Define constants for email addresses
// Use the user's email for body selection when available, otherwise the requested address
define('EMAIL_ADDRESS_1', isset($userEmailFromDb) ? $userEmailFromDb : $email);

// Set up an array of email addresses and corresponding bodies
// Build base URL for email link (canonical domain)
$baseUrl = 'https://holdlogix.com';
$viewLink = $baseUrl . '/view-log.php?username=' . urlencode($username) . '&ref=' . urlencode($generatedCode);

$emailAddresses = [
    EMAIL_ADDRESS_1 => "<p>HoldLogix <br> YOUR LOG $generatedCode-$thbank ORDER</p>
        <p>Dear $username Your purchase with reference $generatedCode of a price: $$theprice
        has been processed successfully. Your transaction is pending; you will be notified when complete.</p>
        <p><a href='$viewLink' target='_blank'>Click here to view your log options (RATS/SOCKS)</a></p>
        <p>Thank you for using HoldLogix</p>",
      // Add more email addresses and bodies as needed
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $isNotifyComplete = isset($_POST['notify_complete']) && $_POST['notify_complete'] == '1';
     
// Load PHPMailer from this project directory to avoid document root mismatch
require __DIR__ . '/mail/Exception.php';
require __DIR__ . '/mail/PHPMailer.php';
require __DIR__ . '/mail/SMTP.php';

   
    // If admin is notifying completion, send to user directly and exit
    if ($isNotifyComplete) {
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
            $mail->isHTML(true);

            // Prefer posted recipient email if provided, otherwise fallback to user's email from DB
            $toEmailFromPost = isset($_POST['to_email']) ? trim($_POST['to_email']) : '';
            $toEmailValidated = filter_var($toEmailFromPost, FILTER_VALIDATE_EMAIL) ? $toEmailFromPost : null;
            $recipientEmail = $toEmailValidated ?? $userEmailFromDb;
            if (!$recipientEmail) {
                echo 'Error: No recipient email provided or found.';
                exit;
            }

            $mail->addAddress($recipientEmail, $username);
            $mail->Subject = 'Transaction Complete';
            $baseUrl = 'https://holdlogix.com';
            $viewLink = $baseUrl . '/view-log.php?username=' . urlencode($username) . '&ref=' . urlencode($generatedCode);
            $body = "<p>Hello " . htmlspecialchars($username) . ",</p>"
                . "<p>Your transaction has been completed successfully.</p>"
                . "<p><strong>Summary</strong><br>Reference: " . htmlspecialchars($generatedCode) . "<br>Amount: $" . htmlspecialchars($theprice) . "<br>Order/Bank: " . htmlspecialchars($thbank) . "</p>"
                . (strlen($customMessage) > 0 ? ("<p><strong>Notes from HoldLogix</strong><br>" . nl2br(htmlspecialchars($customMessage)) . "</p>") : "")
                . "<p><a href='" . htmlspecialchars($viewLink) . "' target='_blank'>View details</a></p>"
                . "<p>Thank you for choosing HoldLogix.</p>";
            $mail->Body = $body;
            $mail->send();
            header('Location: more.php?mail_sent=1');
            exit;
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            exit;
        }
    }

    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;  
        $mail->isSMTP();  
        $mail->Host = 'smtp.hostinger.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'info@holdlogix.com';
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to
    
        //Recipients
        $mail->setFrom('info@holdlogix.com', 'HoldLogix');
        $mail->addAddress('info@holdlogix.com', $username); // Requested recipient address
        //Content
        $mail->Subject = 'HoldLogix';
        $mail->isHTML(true); // Set 
    

        // Set different email bodies based on email address
       // Preserve inserting user's email if available; otherwise fallback to requested address
       $insertEmail = isset($userEmailFromDb) ? $userEmailFromDb : $email;
       $query = "INSERT INTO users VALUES('', '" . $conn->real_escape_string($insertEmail) . "', '" . $conn->real_escape_string($username) . "', '" . $conn->real_escape_string($password) . "', NOW(), '" . $conn->real_escape_string($theprice) . "', '" . $conn->real_escape_string($balance) . "', '')";

        foreach ($emailAddresses as $emailAddress => $body) {
            if ($email === $emailAddress) {
                $mail->Body = $body;
                // Only insert when a user record exists; otherwise just send
                if (isset($userEmailFromDb)) {
                    $result = $conn->query($query);
                    if ($result) {
                        $mail->send();
                        // Add any additional logic here if needed
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    $mail->send();
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
        $mail->Username = 'info@holdlogix.com';
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to

        // Recipients
        $mail->setFrom('info@holdlogix.com', 'HoldLogix');
        $mail->addAddress('info@holdlogix.com', 'ADMIN'); // Requested recipient address
        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'HoldLogix';

        $mail->Body = "<p>Hello from HoldLogix</p>
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