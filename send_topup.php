<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. Setup Environment
require_once 'conkt.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 2. Authentication Check
if (!isset($_SESSION['username'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please log in again.']);
    exit();
}

// 3. Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_topup'])) {
    header('Content-Type: application/json');
    
    // Collect Inputs
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $recipientEmail = isset($_POST['to_email']) ? trim($_POST['to_email']) : '';

    // Validate
    if (empty($username) || empty($amount) || !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input details provided.']);
        exit();
    }

    // Load PHPMailer
    require_once __DIR__ . '/mail/Exception.php';
    require_once __DIR__ . '/mail/PHPMailer.php';
    require_once __DIR__ . '/mail/SMTP.php';

    $debugOutput = '';
    
    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) use (&$debugOutput) {
            $debugOutput .= "$level: $str\n";
        };

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'mail.holdlogix.live';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@holdlogix.live';
        $mail->Password = 'Obedofla@00';
        
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];

        // Try Port 465 (SSL) first
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('info@holdlogix.live', 'HoldLogix Support');
        $mail->addAddress($recipientEmail);

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'Top-Up Confirmation';
        
        $message = "Top-Up Confirmation\n\n";
        $message .= "Hello $username,\n\n";
        $message .= "Your top-up on holdlogix.live of $amount has been completed successfully. You may now proceed with your purchase.\n\n";
        $message .= "Thank you for using holdlogix.live. If you need any assistance, please feel free to contact our support team at support@holdlogix.live.";

        $mail->Body = $message;

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully!']);
        
    } catch (Exception $e) {
        // Fallback to TLS/587 if SSL/465 fails
        try {
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Email sent successfully (via TLS)!']);
        } catch (Exception $e2) {
            echo json_encode(['status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo, 'debug' => $debugOutput]);
        }
    }
} else {
    // Direct access not allowed
    header('Location: admin_tools.php');
}
?>