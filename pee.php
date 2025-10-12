<?php
 session_start();
require_once 'config.php';
if($conn->connect_error) die("Fatal Error");
if( 
    isset($_POST['submit'])) 
 
    {   
        $email = get_post($conn, 'email');
        $username = get_post($conn, 'username');
        $password = get_post($conn, 'password');
        $password1 = get_post($conn, 'password1');
        
        
        $check= mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if(mysqli_num_rows($check)>0){

       
        echo "<script> alert('Username or email already');</script>";
        }else{
            if($password == $password1){
                $_SESSION['username'] = $username;
                $query = "INSERT INTO users VALUES('','$email','$username','$password',NOW(),'','','')";
                
        $result = $conn->query($query);
        if($result){
            header('location: dash.php');
        }
            else{
                echo "<script> alert('The passwords don't match');</script>";
            }
        }
         
            }
        }
        function get_post($conn, $var){
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

<body class="body h-100" style="min-height: 100%;
  
  background-size: cover;
  box-shadow: inset 0 0 0 2000px rgba(20, 50, 60, 0.7);">

    <style>
        .auth-layout { min-height: 100vh; }
        .glass-card {
            background: linear-gradient(135deg, rgba(18, 24, 38, 0.65), rgba(14, 20, 30, 0.55));
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border-radius: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }
        .auth-image {
            position: relative;
            background-image: url('welky.jpg');
            background-size: cover;
            background-position: center;
            min-height: 50vh;
            border-radius: 0;
        }
        .auth-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(8,12,18,0.55), rgba(8,12,18,0.2));
        }
        @media (min-width: 992px) {
            .auth-image { min-height: 100vh; }
        }
        .brand-logo { width: 180px; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.35)); }
        .btn-primary { box-shadow: 0 6px 16px rgba(62, 123, 255, 0.35); }
        .btn-primary:hover { box-shadow: 0 10px 22px rgba(62, 123, 255, 0.45); transform: translateY(-1px); }
    </style>

    <div class="container-fluid p-0 auth-layout">
        <div class="row g-0 min-vh-100 align-items-stretch">
            <!-- Left: Signup Form (mirrors index.php form styles) -->
            <div class="col-12 col-lg-6 d-flex">
                <div class="card glass-card border-0 w-100 my-auto">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-4 text-center text-lg-start">
                            <img src="assets/logo.png" class="brand-logo" alt="HoldLogix" />
                        </div>
                        <h5 class="mb-3 text-white">Create an account to get started</h5>
                        <hr class="border-secondary">

                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="mb-1"><strong>User Name</strong></label>
                                <input type="text" name="username" class="form-control" placeholder="Enter display name" required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-1"><strong>Email</strong></label>
                                <input type="email" name="email" class="form-control" placeholder="hello@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-1"><strong>Password</strong></label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <a class="text-decoration-underline" href="mailto:support@holdlogix.com">Need help?</a>
                            </div>
                            <div class="mb-3">
                                <label class="mb-1"><strong>Confirm Password</strong></label>
                                <input type="password" name="password1" class="form-control" placeholder="Confirm password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg">Sign Up</button>
                            </div>
                        </form>
                        <hr class="border-secondary">
                        <div class="mt-2 text-center text-lg-start">
                            <span>Already have an account? <a href="index.php"><strong><u>Log In</u></strong></a>.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Background Image (matches index.php) -->
            <div class="col-12 col-lg-6">
                <div class="auth-image w-100 h-100"></div>
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