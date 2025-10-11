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
  background: url(hacking.png);
  background-size: cover;
  box-shadow: inset 0 0 0 2000px rgba(20, 50, 60, 0.7);">

    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-6">
                <div class="card" style="background-color: #1d3bc1;">
                    <div class="card-body ">
                        <div class="row m-0 align-items-center justify-contain-center">
                            <div class="">
                                <div class="sign-in-your">
                                    <div class="mb-3">
                                        <img src="assets/logo.png" style="width: 200px;"></img>
                                    </div>
                                    <h5>Create an account to get started.</h5>
                                    <hr>

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
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password1" class="form-control" placeholder="confirm Password" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign Up</button>
                                        </div>
                                    </form>
                                    <hr><br>
                                    <span>Already have an account? <a href="index.php"><strong><u>LogIn</u></strong></a>.</span>
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