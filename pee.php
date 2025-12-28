<?php
ob_start();
// ===== Debugging hooks for Hostinger HTTP 500 =====
// Enable verbose error output and capture fatals/exceptions
$__hlx_show_debug = (
    (isset($_GET['debug']) && $_GET['debug'] === '1') ||
    (getenv('HLX_DEBUG') === '1')
);
define('HLX_SHOW_DEBUG', $__hlx_show_debug);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo "<pre style=\"background:#1b2938;color:#ffcc00;padding:10px;\">PHP ERROR [$errno]: $errstr\nFile: $errfile\nLine: $errline</pre>";
    return false; // allow default handler too
});

set_exception_handler(function($e) {
    echo "<pre style=\"background:#1b2938;color:#ff6b6b;padding:10px;\">UNCAUGHT EXCEPTION: "
        . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
});

register_shutdown_function(function() {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<pre style=\"background:#1b2938;color:#f08d49;padding:10px;\">FATAL ERROR: {$err['message']}\nFile: {$err['file']}\nLine: {$err['line']}</pre>";
    }
});

function hlx_debug($label, $data) {
    if (!defined('HLX_SHOW_DEBUG') || !HLX_SHOW_DEBUG) return;
    if (is_string($data)) {
        $val = $data;
    } else {
        ob_start();
        print_r($data);
        $val = ob_get_clean();
    }
    echo "<pre style=\"background:#0e1a24;color:#9be7ff;padding:10px;border:1px solid #1e88e5;\">DEBUG $label:\n" . htmlspecialchars($val) . "</pre>";
}

hlx_debug('Environment', [
    'php_version' => PHP_VERSION,
    'server_name' => $_SERVER['SERVER_NAME'] ?? '',
    'request_method' => $_SERVER['REQUEST_METHOD'] ?? '',
    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? '',
    'script' => __FILE__,
]);

session_start();
require_once 'config.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/mail/Exception.php';
require_once __DIR__ . '/mail/PHPMailer.php';
require_once __DIR__ . '/mail/SMTP.php';


// Check if connection was successful
if (!isset($conn)) {
    die("Database connection variable not set in config.php");
}
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])) {   
    $email = get_post($conn, 'email');
    $username = get_post($conn, 'username');
    $password = get_post($conn, 'password');
    // Check if password1 exists in POST
    $password1_val = isset($_POST['password1']) ? $_POST['password1'] : ''; 
    $password1_safe = $conn->real_escape_string($password1_val);
    
    // Check if user already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (!$check) {
        echo "Query Error: " . $conn->error;
    } elseif(mysqli_num_rows($check) > 0){
        echo "<script> alert('Username already exists');</script>";
    } else {
        if($password == $password1_safe){
            // Attempt to send verification email FIRST
            $mail = new PHPMailer(true);
            $emailSent = false;
            $mailError = '';

            try {
                // Server settings
                $mail->isSMTP(); 
                $mail->Host = 'mail.holdlogix.live;smtp.hostinger.com'; 
                $mail->SMTPAuth = true; 
                $mail->Username = 'info@holdlogix.live'; 
                $mail->Password = 'Obedofla@00'; 
                $mail->SMTPSecure = 'ssl'; 
                $mail->Port = 465; 
                
                $mail->setFrom('info@holdlogix.live', 'HoldLogix');
                $mail->addAddress($email, $username);
                
                $mail->isHTML(true); 
                $mail->Subject = 'Welcome to HoldLogix';
                
                $bodyContent = "Hello " . htmlspecialchars($username) . ", welcome!!<br>" .
                               "you have signed up at holdlogix.live<br>" .
                               "you will receive the logins info at this email,<br>" .
                               "the relevant information for cashing out on purchase<br>" .
                               "will also be sent to this email address you supplied along with the log details.<br>" .
                               "text us on telegram for or reach out on support@holdlogix.live for the walkthrough";
                
                $mail->Body = $bodyContent;
                $mail->AltBody = strip_tags(str_replace("<br>", "\n", $bodyContent));

                $mail->send();
                $emailSent = true;

            } catch (Exception $e) {
                // Fallback to TLS if SSL fails
                try {
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
                    $mail->send();
                    $emailSent = true;
                } catch (Exception $e2) {
                    $mailError = $mail->ErrorInfo;
                }
            }

            if ($emailSent) {
                // Email sent successfully, proceed to create account
                $_SESSION['username'] = $username;
                
                // Fixed: Use NULL for auto-increment ID, 0 for integers, and match 9 columns
                $query = "INSERT INTO users VALUES(NULL,'$email','$username','$password',NOW(),'0','0','0','0')";
                
                $result = $conn->query($query);
                if($result){
                    ob_end_clean(); // Clean buffer before redirect
                    header('Location: dash.php');
                    exit(); // Always exit after header redirect
                } else {
                    // Show actual database error
                    echo "<script> alert('Database Error: " . addslashes($conn->error) . "');</script>";
                }
            } else {
                // Email failed
                echo "<script> alert('Could not verify email address: " . addslashes($email) . ". Please provide a valid email address. Error: " . addslashes($mailError) . "');</script>";
            }

        } else {
             echo "<script> alert('The passwords do not match');</script>";
        }
    }
}

function get_post($conn, $var){
    if (!isset($_POST[$var])) return '';
    return $conn->real_escape_string($_POST[$var]);
} 
?>	


<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="HoldLogix">
    <meta property="og:title" content="HoldLogix">
    <meta property="og:description" content="HoldLogix">
    <meta property="og:image" content="assets/logo.png">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>HoldLogix</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="assets/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon-16x16.png">
    <link rel="manifest" href="assets/site.webmanifest">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">

</head>

<body class="body h-100">

    <style>
        .auth-layout {
            min-height: 100vh;
            background-image: url('assets/bgpd.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        .auth-layout::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(18, 24, 38, 0.7); /* Dark overlay for readability */
            z-index: 1;
        }
        .glass-card {
            background: rgba(18, 24, 38, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            position: relative;
            z-index: 2;
        }
        /* Compact logo */
        .brand-logo { width: 130px; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.35)); }
        .btn-primary { box-shadow: 0 6px 16px rgba(62, 123, 255, 0.35); }
        .btn-primary:hover { box-shadow: 0 10px 22px rgba(62, 123, 255, 0.45); transform: translateY(-1px); }
        
        /* Loading Overlay */
        #loadingOverlay {
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.85); 
            z-index: 9999; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            color: white;
            backdrop-filter: blur(5px);
        }
        .spinner-custom {
            width: 3rem; 
            height: 3rem;
            border: 4px solid rgba(255,255,255,0.1);
            border-left-color: #3e7bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>
    
    <!-- Loading Overlay -->
    <div id="loadingOverlay">
        <div class="spinner-custom"></div>
        <h4 class="mt-4 text-white">Verifying Email...</h4>
        <p class="text-white-50">Please wait while we send a verification email to your address.</p>
    </div>

    <div class="container-fluid p-0 auth-layout d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                <div class="card glass-card border-0">
                    <!-- Compact padding -->
                    <div class="card-body p-3 p-md-4">
                        <div class="mb-2 text-center">
                            <img src="assets/logo.png" class="brand-logo" alt="HoldLogix" />
                        </div>
                        <h5 class="mb-2 text-white text-center">Create an account to get started</h5>
                        <hr class="border-secondary">

                        <form action="" method="post" id="signupForm">
                            <div class="mb-2">
                                <label class="mb-1 text-white"><strong>User Name</strong></label>
                                <input type="text" name="username" class="form-control" placeholder="Enter display name" required>
                            </div>
                            <div class="mb-2">
                                <label class="mb-1 text-white"><strong>Email</strong></label>
                                <input type="email" name="email" class="form-control" placeholder="hello@example.com" required>
                            </div>
                            <div class="mb-2">
                                <label class="mb-1 text-white"><strong>Password</strong></label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                             <div class="mb-2">
                                <label class="mb-1 text-white"><strong>Confirm Password</strong></label>
                                <input type="password" name="password1" class="form-control" placeholder="Confirm password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a class="text-decoration-underline text-white-50" href="mailto:support@holdlogix.live">Need help?</a>
                            </div>
                           
                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg">Sign Up</button>
                            </div>
                        </form>
                        <hr class="border-secondary">
                        <div class="mt-2 text-center">
                            <span class="text-white">Already have an account? <a href="index.php" class="text-primary"><strong><u>Log In</u></strong></a>.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="xui-main/vendor/global/global.min.js"></script>
    <script src="xui-main/vendor/jquery-autocomplete/jquery-ui.js"></script>
    <!-- Toastr -->
    <script src="xui-main/vendor/toastr/js/toastr.min.js"></script>
    <script src="xui-main/js/custom.min.js"></script>
    <script src="xui-main/js/dlabnav-init.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#signupForm').on('submit', function() {
                // Show the loading overlay when form is submitted
                $('#loadingOverlay').css('display', 'flex');
            });
        });
    </script>

</body>

</html>
