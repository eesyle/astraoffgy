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
$query = "SELECT * FROM users WHERE username='$username'";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
foreach ($query_run as $email1) {
    $email = $email1['Email'] ?? $email1['email'] ?? '';
    $balance = $email1['price'] ?? $email1['price'] ?? 0;
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
// Determine trigger from POST/GET, fallback to session
if (isset($_POST['trigger']) && $_POST['trigger'] !== '') {
    $triger = $_POST['trigger'];
    $_SESSION['trigger'] = $triger;
} elseif (isset($_GET['trigger']) && $_GET['trigger'] !== '') {
    $triger = $_GET['trigger'];
    $_SESSION['trigger'] = $triger;
} elseif (isset($_SESSION['trigger'])) {
    $triger = $_SESSION['trigger'];
}
}
  
 
$theprice = (float)$topp;
// Ensure price is set for purchase flows that use session/POST
if ($theprice <= 0) {
    if (isset($_POST['price']) && is_numeric($_POST['price'])) {
        $theprice = (float)$_POST['price'];
    } elseif (isset($_SESSION['price']) && is_numeric($_SESSION['price'])) {
        $theprice = (float)$_SESSION['price'];
    }
}
$randomPassword = generateRandomPassword();
$generatedCode = generateCode();
 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
     
// Load PHPMailer from this project directory to avoid document root mismatch
require __DIR__ . '/mail/Exception.php';
require __DIR__ . '/mail/PHPMailer.php';
require __DIR__ . '/mail/SMTP.php';

   

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
        // Resolve bank name from POST/GET/SESSION for purchase emails
        $bankName = '';
        if (isset($_POST['bank'])) {
            $bankName = trim($_POST['bank']);
        } elseif (isset($_GET['bank'])) {
            $bankName = trim($_GET['bank']);
        } elseif (isset($_SESSION['bank'])) {
            $bankName = trim($_SESSION['bank']);
        }
        // Contact info + dashboard CTA block appended to all user-facing emails
        $dashboardUrl = 'https://holdlogix.com/dash';
-        $contactBlock = "<hr style='border:0;border-top:1px solid #e0e0e0;margin:24px 0'>\n<div style='font-family:Arial,sans-serif;color:#333333;font-size:14px;line-height:1.6'>\n  <p style='margin:0 0 10px'>Need help? Contact us:</p>\n  <p style='margin:0'>WhatsApp: <a href='https://wa.me/14093402245' style='color:#1a73e8;text-decoration:none'>+1 409 340 2245</a></p>\n  <p style='margin:0'>Telegram: <a href='https://t.me/BalrogAdmin' style='color:#1a73e8;text-decoration:none'>@BalrogAdmin</a></p>\n  <p style='margin:0'>Email: <a href='mailto:support@holdlogix.com' style='color:#1a73e8;text-decoration:none'>support@holdlogix.com</a></p>\n  <table cellpadding='0' cellspacing='0' border='0' style='margin-top:16px'>\n    <tr>\n      <td align='center'>\n        <a href='" . $dashboardUrl . "' style='background-color:#1a73e8;color:#ffffff;text-decoration:none;padding:12px 20px;border-radius:6px;display:inline-block;font-weight:600'>Go to Dashboard</a>\n      </td>\n    </tr>\n  </table>\n</div>";
+        $contactBlock = "<p>Need help? Contact us:</p>\n<p>WhatsApp: <a href='https://wa.me/14093402245'>+1 409 340 2245</a></p>\n<p>Telegram: <a href='https://t.me/BalrogAdmin'>@BalrogAdmin</a></p>\n<p>Email: <a href='mailto:support@holdlogix.com'>support@holdlogix.com</a></p>\n<p><a href='" . $dashboardUrl . "'>Go to Dashboard</a></p>";
        if($triger == "top"){
            $mail->Body = "<p>Hello from HoldLogix</p>"
                . "<p>Dear " . htmlspecialchars($username) . " You have topped up a balance of $" . number_format((float)$theprice, 2) . " with HoldLogix</p>"
                . "<p>Your transaction is pending; you will be informed via this email when complete</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
        }
        if($triger == "purchase"){
            $amountFmt = number_format((float)$theprice, 2);
            $bankText = $bankName !== '' ? ' from ' . htmlspecialchars($bankName) : '';
            // Build base URL for link (use canonical domain)
            $baseUrl = 'https://holdlogix.com';
            $link = $baseUrl . '/view-log.php?username=' . urlencode($username) . '&ref=' . urlencode($generatedCode);
            $mail->Body = "<p>Dear " . htmlspecialchars($username) . " Your purchase with reference $generatedCode of a price: $ $amountFmt$bankText</p>"
                . "<p>Has been processed successfully. Your transaction is pending; you will be notified when complete.</p>"
                . "<p><a href='" . htmlspecialchars($link) . "' target='_blank'>Click here to view your log options (RATS/SOCKS)</a></p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
        }
        if($triger == "rats"){
            $amountFmt = number_format((float)$theprice, 2);
            $mail->Body = "<p>Dear " . htmlspecialchars($username) . " You selected RATS for your log options.</p>"
                . "<p>Price: $ $amountFmt. Your transaction is pending; you will be notified when complete.</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
        }
        if($triger == "socks"){
            $amountFmt = number_format((float)$theprice, 2);
            $mail->Body = "<p>Dear " . htmlspecialchars($username) . " You selected SOCKS for your log options.</p>"
                . "<p>Price: $ $amountFmt. Your transaction is pending; you will be notified when complete.</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
        }
        if($triger == "card"){
            $mail->Body = "  <p>Dear $username  You have just purchased a card of a price: $ $theprice
        Has been processed succefully. your transaction is pending you will be notified when complete
        </p>
        <p>Thank you for using HoldLogix</p>" . $contactBlock;
        }
        $mail->isHTML(true);
        // Determine effective amount (fallback to session price for purchases)
        $effectiveAmount = (float)$theprice;
        if ($effectiveAmount <= 0 && isset($_SESSION['price']) && is_numeric($_SESSION['price'])) {
            $effectiveAmount = (float)$_SESSION['price'];
        }
        // Keep $theprice in sync so existing email templates show the correct amount
        $theprice = $effectiveAmount;

        // Compose Info for history table based on trigger
        $info = 'Transaction';
        if (isset($triger)) {
            if ($triger === 'top') {
                $info = 'Top-up + Amount: $' . number_format($effectiveAmount, 2);
            } elseif ($triger === 'purchase') {
                $info = 'Purchase + Amount: $' . number_format($effectiveAmount, 2);
            } elseif ($triger === 'card') {
                $info = 'Card Purchase + Amount: $' . number_format($effectiveAmount, 2);
            }
        }

        // Update user balance ONLY for top-ups
        $newBalance = $balance;
        if ($effectiveAmount > 0 && isset($triger) && $triger === 'top') {
            $newBalance = $balance + $effectiveAmount;
            if ($newBalance !== $balance) {
                if ($stmt = $conn->prepare('UPDATE users SET balance = ? WHERE username = ?')) {
                    $stmt->bind_param('ds', $newBalance, $username);
                    $stmt->execute();
                    $stmt->close();
                    $balance = $newBalance;
                }
            }
        }

        // Match history table columns: id, date, Info, user, amount
        $query = "INSERT INTO history (date, Info, user, amount) VALUES (NOW(), '" . mysqli_real_escape_string($conn, $info) . "', '" . mysqli_real_escape_string($conn, $username) . "', '" . mysqli_real_escape_string($conn, (string)$effectiveAmount) . "')";

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
                    $mail->Body = "<p>Hello from HoldLogix</p>"
                        . "<p>User " . htmlspecialchars($username) . " has just topped up a balance of $" . number_format((float)$theprice, 2) . "</p>"
                        . "<p>" . htmlspecialchars($username) . "'s transaction is pending until modified</p>"
                        . "<p>The attachment below is their purchase proof:</p>";
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
}

        $mail->send();
 

        header('Location: email-success.php?username=' . urlencode($username) . '&status=sent');
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