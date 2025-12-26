<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'config.php';


if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Resolve the current username from common session/GET/POST keys.
 * This prevents repeated "Username not provided" loops when
 * different scripts store the username under different keys.
 *
 * Priority:
 * 1) Session keys: 'username', 'UserName', 'user', 'uname'
 * 2) GET keys: 'username', 'UserName', 'user', 'uname'
 * 3) POST keys: 'username', 'UserName', 'user', 'uname'
 * 4) Cookie key: 'username'
 * Returns a trimmed string or empty string if none found.
 */
function resolveUsername(): string {
    $sessionKeys = ['username', 'UserName', 'user', 'uname'];
    foreach ($sessionKeys as $k) {
        if (isset($_SESSION[$k]) && is_string($_SESSION[$k]) && trim($_SESSION[$k]) !== '') {
            return trim($_SESSION[$k]);
        }
    }
    $getKeys = ['username', 'UserName', 'user', 'uname'];
    foreach ($getKeys as $k) {
        if (isset($_GET[$k]) && is_string($_GET[$k]) && trim($_GET[$k]) !== '') {
            // Keep the session in sync for subsequent requests
            $_SESSION['username'] = trim($_GET[$k]);
            return trim($_GET[$k]);
        }
    }
    $postKeys = ['username', 'UserName', 'user', 'uname'];
    foreach ($postKeys as $k) {
        if (isset($_POST[$k]) && is_string($_POST[$k]) && trim($_POST[$k]) !== '') {
            $_SESSION['username'] = trim($_POST[$k]);
            return trim($_POST[$k]);
        }
    }
    if (isset($_COOKIE['username']) && is_string($_COOKIE['username']) && trim($_COOKIE['username']) !== '') {
        $_SESSION['username'] = trim($_COOKIE['username']);
        return trim($_COOKIE['username']);
    }
    return '';
}

$username = resolveUsername();
if ($username === '') {
    // Friendly message without hard loop; provide a direct login link
    echo "<script>alert('Error: Username not provided! Please log in first.');</script>";
    echo "<p>Go to <a href='index.php'>Login</a> then retry your action.</p>";
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
require_once __DIR__ . '/mail/Exception.php';
require_once __DIR__ . '/mail/PHPMailer.php';
require_once __DIR__ . '/mail/SMTP.php';

   

    try {
        $mail = new PHPMailer(true);

 
        // Toggle SMTP debug via query param ?smtp_debug=1
        $enableSmtpDebug = isset($_GET['smtp_debug']) && $_GET['smtp_debug'] === '1';
        $mail->SMTPDebug = $enableSmtpDebug ? 2 : 0; 
        $mail->isSMTP(); 
        // Try multiple SMTP hosts in order (PHPMailer supports semicolon list)
        $mail->Host = 'mail.holdlogix.live;smtp.hostinger.com';  
        $mail->SMTPAuth = true; 
        $mail->Username = 'info@holdlogix.live'; // Updated sender email per your change
        $mail->Password = 'Obedofla@00'; // Password remains unchanged
        $mail->SMTPSecure = 'ssl';  
        $mail->Port = 465;  
    
       
        $mail->setFrom('info@holdlogix.live', 'HoldLogix');  // Updated sender email per your change
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
        // Contact info block (plain text for better deliverability)
        $contactBlock = "<p>Need help? Contact us:</p>\n<p>WhatsApp: +1 409 340 2245</p>\n<p>Telegram: @BalrogAdmin</p>\n<p>Email: support@holdlogix.live</p>";
        
        if($triger == "top"){
            $mail->Body = "<p>Hello from HoldLogix</p>"
                . "<p>Dear " . htmlspecialchars($username) . " You have topped up a balance of $" . number_format((float)$theprice, 2) . " with HoldLogix</p>"
                . "<p>Your transaction is pending; you will be informed via this email when complete</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $mail->Body));
        }
        if($triger == "purchase"){
            $amountFmt = number_format((float)$theprice, 2);
            $bankText = $bankName !== '' ? ' from ' . htmlspecialchars($bankName) : '';
            
            $mail->Body = "<p>Dear " . htmlspecialchars($username) . " Your purchase with reference $generatedCode of a price: $ $amountFmt$bankText</p>"
                . "<p>Has been processed successfully. Your transaction is pending; you will be notified when complete.</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $mail->Body));
        }
        if($triger == "rats"){
            $amountFmt = number_format((float)$theprice, 2);
            $mail->Body = "<p>Dear " . htmlspecialchars($username) . " You selected RATS for your log options.</p>"
                . "<p>Price: $ $amountFmt. Your transaction is pending; you will be notified when complete.</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $mail->Body));
        }
        if($triger == "socks"){
            $amountFmt = number_format((float)$theprice, 2);
            $mail->Body = "<p>Dear " . htmlspecialchars($username) . " You selected SOCKS for your log options.</p>"
                . "<p>Price: $ $amountFmt. Your transaction is pending; you will be notified when complete.</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $mail->Body));
        }
        if($triger == "card"){
            $mail->Body = "  <p>Dear $username  You have just purchased a card of a price: $ $theprice
        Has been processed succefully. your transaction is pending you will be notified when complete
        </p>
        <p>Thank you for using HoldLogix</p>" . $contactBlock;
            $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $mail->Body));
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

        // Match history table columns: id, date, Info, user, amount, is_active
        $query = "INSERT INTO history (date, Info, user, amount, is_active) VALUES (NOW(), '" . mysqli_real_escape_string($conn, $info) . "', '" . mysqli_real_escape_string($conn, $username) . "', '" . mysqli_real_escape_string($conn, (string)$effectiveAmount) . "', '1')";

                $result = $conn->query($query);

                if ($result) {
                    // Attempt send with current SSL/465 config; on failure, fallback to TLS/587
                    try {
                        $mail->send();
                    } catch (Exception $exSend) {
                        // Fallback to TLS/587
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        $mail->SMTPAutoTLS = true;
                        // Relax SSL verification in case of cert chain issues on Windows/XAMPP
                        $mail->SMTPOptions = [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true,
                            ],
                        ];
                        try {
                            $mail->send();
                        } catch (Exception $exSend2) {
                            throw $exSend2; // bubble up to outer catch
                        }
                    }
                } 
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }


    try {
        $mail = new PHPMailer(true);
 
        // Toggle SMTP debug via query param ?smtp_debug=1
        $enableSmtpDebugAdmin = isset($_GET['smtp_debug']) && $_GET['smtp_debug'] === '1';
        $mail->SMTPDebug = $enableSmtpDebugAdmin ? 2 : 0;  
        $mail->isSMTP(); 
        // Try multiple SMTP hosts in order (PHPMailer supports semicolon list)
        $mail->Host = 'mail.holdlogix.live;smtp.hostinger.com'; 
        $mail->SMTPAuth = true;  
        $mail->Username = 'info@holdlogix.live'; // Updated sender email per your change
        $mail->Password = 'Obedofla@00'; // Password remains unchanged
        $mail->SMTPSecure = 'ssl';  
        $mail->Port = 465; 

         
        $mail->setFrom('info@holdlogix.live', 'HoldLogix');  // Updated sender email per your change
        $mail->addAddress('info@holdlogix.live', 'ADMIN');  
         
        $mail->isHTML(true); 
 
                $mail->Subject = '[HoldLogix]  TRANSACTION CONFIRMATION';

                if($triger == "top"){
                    $mail->Body = "<p>Hello from HoldLogix</p>"
                        . "<p>User " . htmlspecialchars($username) . " has just topped up a balance of $" . number_format((float)$theprice, 2) . "</p>"
                        . "<p>" . htmlspecialchars($username) . "'s transaction is pending until modified</p>"
                        . "<p>The attachment below is their purchase proof:</p>";
                    $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $mail->Body));
                }
                if($triger == "purchase"){
                    $mail->Body = "<p>Hello from HoldLogix</p>
        <p>User $username has just made a purchase of $$theprice</p>
        <p>$username's transaction is pending until modified</p>
        <p>The attachment below is their purchase proof:</p>";
                    $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $mail->Body));
                }

                if($triger == "card"){
                    $mail->Body = "<p>Hello from HoldLogix</p>
        <p>User $username has just bought a card of $$theprice</p>
        <p>$username's transaction is pending until modified</p>
        <p>The attachment below is their purchase proof:</p>";
                    $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n"], $mail->Body));
                }

       
        
                 if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $attachmentPath = $_FILES['file']['tmp_name'];
    $attachmentName = $_FILES['file']['name'];
    $mail->addAttachment($attachmentPath, $attachmentName);
}

        // Attempt send with current SSL/465 config; on failure, fallback to TLS/587
        try {
            $mail->send();
        } catch (Exception $exSendAdmin) {
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPAutoTLS = true;
            // Relax SSL verification in case of cert chain issues on Windows/XAMPP
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];
            try {
                $mail->send();
            } catch (Exception $exSendAdmin2) {
                throw $exSendAdmin2;
            }
        }
 

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