<?php
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

// Confirm config.php exists before requiring
$__cfg = __DIR__ . '/config.php';
hlx_debug('config.php exists', file_exists($__cfg) ? 'yes' : 'no');
require_once $__cfg;

// Check database connector state
if (!isset($conn)) {
    hlx_debug('db', 'Missing $conn in config.php');
} else {
    // Only show connect error when debugging is enabled or an error exists
    if (isset($conn->connect_error) && $conn->connect_error) {
        hlx_debug('db_connect_error', $conn->connect_error);
    }
}

if (isset($conn->connect_error) && $conn->connect_error) die("Fatal Error");
 
if (isset($_POST['submit']) &&
    isset($_POST['email']) &&
    isset($_POST['password'])  
  ) {

    // Log incoming POST keys to help debugging (no secrets printed)
    if (defined('HLX_SHOW_DEBUG') && HLX_SHOW_DEBUG) {
        hlx_debug('POST keys', array_keys($_POST));
    }

    $email = get_post($conn, 'email');
    $password = get_post($conn, 'password');
 
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        $row = mysqli_fetch_assoc($check);

          if ($row) {
            if (isset($row['password']) && $password === $row['password']) {
                 
                 $_SESSION['username'] = isset($row['username']) ? $row['username'] : $email;
                
                
                header('location: dash.php');
                exit();
            } else if ($email === 'obed' && $password === 'MI123') {
                $_SESSION['username'] = 'obed';
                $url = "AdminsDash.php?username=" . $_SESSION['username'];
                header('Location: ' . $url);
                exit();
            }
             else {
                echo "<script> alert('Incorrect password');</script>";
            }
        } else {
            echo "<script> alert('The user is not registered');</script>";
}
  }

function get_post($conn, $var)
{
    return isset($_POST[$var]) ? $conn->real_escape_string($_POST[$var]) : '';
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
    <title>Login</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">

</head>

<body class="body h-100" style="min-height: 100%;
  background: url(hacking.png);
  background-size: cover;
  box-shadow: inset 0 0 0 2000px rgba(20, 50, 60, 0.7);">

    <div class="container h-100" >
        <div class="row h-100 align-items-center justify-contain-center"  >
            <div class="col-xl-6">
                <div class="card" style="background-color: #1d3bc1;">
                    <div class="card-body ">
                        <div class="row m-0 align-items-center justify-contain-center">
                            <div class="">
                                <div class="sign-in-your">
                                    <div class="mb-3">
                                        <img src="assets/logo.png" style="width: 200px;"></img>
                                    </div>
                                    <h5>Welcome Login to access your account</h5>
                                    <hr>

                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="hello@example.com" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class="row text-right mt-0 mb-4 float-right pull-right">
                                            <u><a href="mailto:support@offggy.com">Forgot Password?</a></u>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                                        </div>
                                    </form>
                                    <hr><br>
                                    <span>Don't have an account? <a href="pee.php"><strong><u>Register</u></strong></a>.</span>
                                </div>
                            </div>
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
    </script>

</body>

</html>