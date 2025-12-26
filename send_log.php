<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. Setup Environment
require_once 'conkt.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 2. Authentication Check (Ensure only admin can use this)
if (!isset($_SESSION['username'])) {
    // Return JSON error if session expired
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please log in again.']);
    exit();
}

// 3. Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_info'])) {
    header('Content-Type: application/json');
    
    // Collect Inputs
    $recipientEmail = isset($_POST['recipient_email']) ? trim($_POST['recipient_email']) : '';
    $bankName = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : 'CHASE BANKLOG';
    $balance = isset($_POST['balance']) ? trim($_POST['balance']) : '$0.00';
    $bankInfo = isset($_POST['bank_info']) ? trim($_POST['bank_info']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : 'United States of America';
    $currentDate = date('d-m-Y H:i:s');

    // Validate Email
    if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address provided.']);
        exit();
    }

    // Load PHPMailer
    require __DIR__ . '/mail/Exception.php';
    require __DIR__ . '/mail/PHPMailer.php';
    require __DIR__ . '/mail/SMTP.php';

    // Capture Debug Output
    $debugOutput = '';
    
    try {
        $mail = new PHPMailer(true);
        
        // Enable Debugging but capture it
        $mail->SMTPDebug = 2; // Detailed debug
        $mail->Debugoutput = function($str, $level) use (&$debugOutput) {
            $debugOutput .= "$level: $str\n";
        };

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'holdlogix@gmail.com';
        $mail->Password = 'xkhscjxnzzffcpcy';
        
        // Relaxed SSL Settings for both ports (Fixes certificate issues)
        $sslOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];
        $mail->SMTPOptions = $sslOptions;

        // Try Port 465 (SSL) first
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('holdlogix@gmail.com', 'HoldLogix');
        $mail->addAddress($recipientEmail);

        // Content
        $mail->isHTML(false); // Plain text as per template appearance, or HTML with pre formatting
        $mail->Subject = '[HoldLogix] Log Information';

        // Construct Body using Template
        $body = "
$bankName
Balance: $balance
UserName : stacieNan03
Password : Lillipie1

-- EMAIL INFO --
Email: stacie22556@yahoo.com
Email Password : Lillipie22/

----- CARD DETAILS -------

Bank Info : $bankInfo | $country

Type : VISA - DEBIT

Level : TRADITIONAL

Name On Card : Stacie Nan Jones

Card Number : 4427910040006907

Expiry date : 10/27

CVV : 882

ATM PIN : 2258

|------------ 💻🌏 DEVICE INFO 🌏💻 -----------|

IP ADDRESS : 174.203.129.129

IP NAME : 129.sub-174-203-129.myvzw.com

CARRIER :

DATE OF SESSION : $currentDate

BROWSER : Apple Safari 15.5 on iPhone

USER AGENT : Mozilla/5.0 (iPhone; CPU iPhone OS 15_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.5 Mobile/15E148 Safari/604.1
";
        // Preserve whitespace in HTML if needed, but email clients handle plain text well if Content-Type is text/plain.
        // If isHTML(true) is used, we need <pre> or nl2br.
        // Let's use HTML with <pre> to ensure formatting is exact.
        $mail->isHTML(true);
        $mail->Body = "<pre style='font-family: monospace; font-size: 14px;'>" . htmlspecialchars($body) . "</pre>";
        $mail->AltBody = $body; // Plain text version

        // Send
        try {
            $mail->send();
        } catch (Exception $exSend) {
            // Fallback to TLS/587
            $debugOutput .= "--- Failing over to TLS/587 ---\n";
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPAutoTLS = true;
            // SMTPOptions already set above
            
            try {
                $mail->send();
            } catch (Exception $exSend2) {
                throw $exSend2;
            }
        }

        echo json_encode(['status' => 'success']);
        exit;

    } catch (Exception $e) {
        // Clean up debug output for JSON
        // Remove sensitive info if necessary (like password) - simple replace
        $safeDebug = str_replace('Obedofla@00', '********', $debugOutput);
        
        echo json_encode([
            'status' => 'error', 
            'message' => 'Failed to send email. ' . $mail->ErrorInfo,
            'debug' => $safeDebug
        ]);
        exit;
    }

} else {
    // Direct access not allowed
    header("Location: admin_tools.php");
    exit();
}
