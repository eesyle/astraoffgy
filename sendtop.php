<?php
ob_start();
// ==========================================
// DEBUGGING CONFIGURATION
// ==========================================
$debug = false; // Set to true to enable debugging

if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    echo "<h3>DEBUG MODE: ON</h3>";
    echo "<pre>";
    echo "POST Data: " . print_r($_POST, true) . "\n";
    echo "GET Data: " . print_r($_GET, true) . "\n";
    echo "SESSION Data: " . print_r($_SESSION, true) . "\n";
    echo "</pre>";
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Start Session if not already started
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'config.php';

/**
 * Resolve the current username from common session/GET/POST keys.
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
if ($debug) echo "Resolved Username: " . htmlspecialchars($username) . "<br>";

if ($username === '') {
    // This is a user-facing error, keep it visible or handle gracefully
    echo "<script>alert('Error: Username not provided! Please log in first.');</script>";
    echo "<p>Go to <a href='index.php'>Login</a> then retry your action.</p>";
    exit();
}

if ($conn->connect_error) {
    die("Fatal Error: Database connection failed: " . $conn->connect_error);
}  

// Get User Details
$query = "SELECT * FROM users WHERE username='$username'";
$query_run = mysqli_query($conn, $query);

$email = '';
$balance = 0;

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $userRow) {
        $email = $userRow['Email'] ?? $userRow['email'] ?? '';
        $balance = $userRow['price'] ?? $userRow['Balance'] ?? $userRow['balance'] ?? 0; // Standardize
    }
}
if ($debug) echo "Current User Balance: " . $balance . "<br>";

// Determine Trigger
$triger = '';
if (isset($_POST['trigger']) && $_POST['trigger'] !== '') {
    $triger = $_POST['trigger'];
    $_SESSION['trigger'] = $triger;
} elseif (isset($_GET['trigger']) && $_GET['trigger'] !== '') {
    $triger = $_GET['trigger'];
    $_SESSION['trigger'] = $triger;
} elseif (isset($_SESSION['trigger'])) {
    $triger = $_SESSION['trigger'];
}
if ($debug) echo "Resolved Trigger: " . htmlspecialchars($triger) . "<br>";

// Resolve Price
$theprice = 0.0;

// 1. Check for wfprice in Session (Highest Priority for Purchase Flow)
if ($triger !== 'top' && isset($_SESSION['wfprice']) && is_numeric($_SESSION['wfprice'])) {
    $theprice = (float)$_SESSION['wfprice'];
    if ($debug) echo "Price resolved from SESSION['wfprice']: $theprice<br>";
}
// 2. Check for wfprice in POST (Override if specific form submitted)
if ($triger !== 'top' && isset($_POST['wfprice']) && is_numeric($_POST['wfprice'])) {
    $theprice = (float)$_POST['wfprice'];
    if ($debug) echo "Price resolved from POST['wfprice']: $theprice<br>";
}
// 3. Fallback to 'amount' or 'price'
if ($theprice <= 0) {
    // If trigger is 'top', prioritize 'price' or 'amount' over 'wfprice'
    if ($triger === 'top') {
         if (isset($_SESSION['price']) && is_numeric($_SESSION['price'])) {
            $theprice = (float)$_SESSION['price'];
        } elseif (isset($_POST['price']) && is_numeric($_POST['price'])) {
            $theprice = (float)$_POST['price'];
        } elseif (isset($_GET['amount']) && is_numeric($_GET['amount'])) {
            $theprice = (float)$_GET['amount'];
        }
        if ($debug) echo "Price resolved for TOP-UP: $theprice<br>";
    } else {
        if (isset($_GET['amount']) && is_numeric($_GET['amount'])) {
            $theprice = (float)$_GET['amount'];
        } elseif (isset($_POST['amount']) && is_numeric($_POST['amount'])) {
            $theprice = (float)$_POST['amount'];
        } elseif (isset($_POST['price']) && is_numeric($_POST['price'])) {
            $theprice = (float)$_POST['price'];
        } elseif (isset($_SESSION['price']) && is_numeric($_SESSION['price'])) {
            $theprice = (float)$_SESSION['price'];
        }
        if ($debug) echo "Price resolved from fallback methods: $theprice<br>";
    }
}

// Ensure trigger is 'purchase' if we have a valid price and no explicit top-up trigger
if ($theprice > 0 && ($triger === '' || !isset($triger))) {
    // Basic heuristic: if it came from wfprice, it's likely a purchase
    if (isset($_SESSION['wfprice']) || isset($_POST['wfprice'])) {
        $triger = 'purchase';
        if ($debug) echo "Trigger auto-set to 'purchase' based on wfprice presence.<br>";
    }
}

$randomPassword = generateRandomPassword();
$generatedCode = generateCode();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if ($debug) echo "Processing Form Submission...<br>";

    require_once __DIR__ . '/mail/Exception.php';
    require_once __DIR__ . '/mail/PHPMailer.php';
    require_once __DIR__ . '/mail/SMTP.php';

    try {
        $mail = new PHPMailer(true);

        // Toggle SMTP debug via query param ?smtp_debug=1
        $enableSmtpDebug = isset($_GET['smtp_debug']) && $_GET['smtp_debug'] === '1';
        $mail->SMTPDebug = $enableSmtpDebug ? 2 : 0; 
        $mail->isSMTP(); 
        $mail->Host = 'mail.holdlogix.live;smtp.hostinger.com';  
        $mail->SMTPAuth = true; 
        $mail->Username = 'info@holdlogix.live'; 
        $mail->Password = 'Obedofla@00'; 
        $mail->SMTPSecure = 'ssl';  
        $mail->Port = 465;  
    
        $mail->setFrom('info@holdlogix.live', 'HoldLogix');  
        $mail->addAddress($email, $username);  
         
        $mail->Subject = '[HoldLogix]  TRANSACTION CONFIRMATION';
        
        $bankName = '';
        if (isset($_POST['bank'])) {
            $bankName = trim($_POST['bank']);
        } elseif (isset($_GET['bank'])) {
            $bankName = trim($_GET['bank']);
        } elseif (isset($_SESSION['bank'])) {
            $bankName = trim($_SESSION['bank']);
        }
        
        $contactBlock = "<p>Need help? Contact us:</p>\n<p>WhatsApp: +1 409 340 2245</p>\n<p>Telegram: @jayw2w</p>\n<p>Email: support@holdlogix.live</p>";
        
        // Email Body Construction
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
        // ... (Other triggers: rats, socks, card) ...
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
        $effectiveAmount = (float)$theprice;
        
        if ($debug) echo "Effective Amount for Transaction: $effectiveAmount<br>";

        // Info for history
        $info = 'Transaction';
        if ($triger === 'top') {
            $info = 'Top-up + Amount: $' . number_format($effectiveAmount, 2);
        } elseif ($triger === 'purchase') {
            $info = 'Purchase + Amount: $' . number_format($effectiveAmount, 2);
        } elseif ($triger === 'card') {
            $info = 'Card Purchase + Amount: $' . number_format($effectiveAmount, 2);
        }

        // ============================================================
        // USER BALANCE UPDATE SECTION
        // ============================================================
        if ($debug) echo "Updating User Balance...<br>";
        $newBalance = $balance;
        
        if ($effectiveAmount > 0 && isset($triger) && $triger === 'top') {
            // TOP-UP LOGIC: ADD to balance
            $newBalance = $balance + $effectiveAmount;
            if ($newBalance !== $balance) {
                if ($stmt = $conn->prepare('UPDATE users SET balance = ? WHERE username = ?')) {
                    $stmt->bind_param('ds', $newBalance, $username);
                    $stmt->execute();
                    $stmt->close();
                    $balance = $newBalance;
                    if ($debug) echo "Balance Updated (Top-up): New Balance is $newBalance<br>";
                } else {
                    if ($debug) echo "Error Preparing Update Statement (Top-up): " . $conn->error . "<br>";
                }
            }
        } elseif ($effectiveAmount > 0 && isset($triger) && $triger === 'purchase') {
            // PURCHASE LOGIC: DEDUCT from balance
            // ************************************************************
            // THIS IS WHERE THE PURCHASE DEDUCTION HAPPENS
            // ************************************************************
            $newBalance = $balance - $effectiveAmount;
            
            if ($stmt = $conn->prepare('UPDATE users SET price = ? WHERE username = ?')) {
                $stmt->bind_param('ds', $newBalance, $username);
                $stmt->execute();
                $stmt->close();
                $balance = $newBalance;
                if ($debug) echo "Balance Updated (Purchase): Deducted $effectiveAmount. New Balance is $newBalance<br>";
            } else {
                if ($debug) echo "Error Preparing Update Statement (Purchase): " . $conn->error . "<br>";
            }
        } else {
            if ($debug) echo "No Balance Update Triggered. Trigger: '$triger', Amount: $effectiveAmount<br>";
        }
        // ============================================================

        // Insert into History
        $query = "INSERT INTO history (date, Info, user, amount, is_active) VALUES (NOW(), '" . mysqli_real_escape_string($conn, $info) . "', '" . mysqli_real_escape_string($conn, $username) . "', '" . mysqli_real_escape_string($conn, (string)$effectiveAmount) . "', '1')";
        $result = $conn->query($query);
        if ($result) {
            if ($debug) echo "History Record Inserted.<br>";
            
            // Send User Email
            try {
                $mail->send();
                if ($debug) echo "User Email Sent Successfully.<br>";
            } catch (Exception $exSend) {
                if ($debug) echo "User Email Failed (SSL), trying TLS...<br>";
                // Fallback logic ...
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->SMTPAutoTLS = true;
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];
                try {
                    $mail->send();
                    if ($debug) echo "User Email Sent Successfully (TLS).<br>";
                } catch (Exception $exSend2) {
                     if ($debug) echo "User Email Failed completely: " . $mail->ErrorInfo . "<br>";
                }
            }
        } else {
             if ($debug) echo "Error Inserting History: " . $conn->error . "<br>";
        }

    } catch (Exception $e) {
        if ($debug) echo "Mailer Error: " . $mail->ErrorInfo . "<br>";
    }


    // Admin Email Section
    try {
        $mail = new PHPMailer(true);
        // ... (Admin email config) ...
        $mail->isSMTP(); 
        $mail->Host = 'mail.holdlogix.live;smtp.hostinger.com'; 
        $mail->SMTPAuth = true;  
        $mail->Username = 'info@holdlogix.live'; 
        $mail->Password = 'Obedofla@00'; 
        $mail->SMTPSecure = 'ssl';  
        $mail->Port = 465; 
        $mail->setFrom('info@holdlogix.live', 'HoldLogix');  
        $mail->addAddress('info@holdlogix.live', 'ADMIN');  
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
        // ... other triggers for admin email ...
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

        try {
            $mail->send();
            if ($debug) echo "Admin Email Sent Successfully.<br>";
        } catch (Exception $exSendAdmin) {
             // Fallback
             $mail->SMTPSecure = 'tls';
             $mail->Port = 587;
             $mail->SMTPAutoTLS = true;
             $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];
            try {
                $mail->send();
                if ($debug) echo "Admin Email Sent Successfully (TLS).<br>";
            } catch (Exception $exSendAdmin2) {
                 if ($debug) echo "Admin Email Failed: " . $mail->ErrorInfo . "<br>";
            }
        }
        
        if ($debug) echo "Redirecting to success page...<br>";
        
        // Ensure no output has been sent before header
        ob_end_clean(); 
        
        header('Location: email-success.php?username=' . urlencode($username) . '&status=sent');
        exit();

    } catch (Exception $e) {
        if ($debug) echo "Admin Mailer Error: " . $mail->ErrorInfo;
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
?>