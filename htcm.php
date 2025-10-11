<?php
session_start(); // Start the session

require_once 'conkt.php';

if ($conn->connect_error) die("Fatal Error");

// Verify reCAPTCHA
if (isset($_POST['submit']) &&
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['g-recaptcha-response'])) {

    $username = get_post($conn, 'username');
    $password = get_post($conn, 'password');
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $recaptcha_secret_key = "6Lcc81YpAAAAAGPBlaKiObxpHn3LZBmdyI_L6N22"; // Replace with your reCAPTCHA secret key

    $recaptchaSecretKey = '6Lcc81YpAAAAAGPBlaKiObxpHn3LZBmdyI_L6N22';  
    $recaptchaVerifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecretKey}&response={$recaptchaResponse}";
    $recaptchaData = json_decode(file_get_contents($recaptchaVerifyUrl));

    if ($recaptchaData->success) {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE UserName = '$username'");
        $row = mysqli_fetch_assoc($check);

        if ($row) {
            if ($password == $row["PassWord"]) {
                // Successful login
                $_SESSION['username'] = $username; // Store username in session
                $url = "Dashboad.php?username=" . $username;
                header('location:' . $url);
                exit();
            } else if ($username == 'Obed' && $password == '123456789') {
                // Admin login
                $_SESSION['username'] = $username; // Store username in session
                $url = "AdminsDash.php"; // Redirect to admin dashboard without passing username in URL
                header('Location: ' . $url);
                exit();
            } else {
                echo "<script> alert('Incorrect password');</script>";
            }
        } else {
            echo "<script> alert('The user is not registered');</script>";
        }
    } else {
        echo "<script> alert('Please verify that you are not a robot');</script>";
    }
}

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}
?>

 
 <!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{% static '" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        Log in
    </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <!-- <link rel="icon" type="image/x-icon" href="https://www.inlaks.com/wp-content/uploads/2019/08/Inlaks-Favicon.png" /> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

   <!-- Icons. Uncomment required icon fonts -->
   <link rel="stylesheet" href="static\vendor\fonts\boxicons.css" />

   <!-- Core CSS -->
   <link rel="stylesheet" href="static\vendor\css\core.css" class="template-customizer-core-css" />
   <link rel="stylesheet" href="static\vendor\css\theme-default.css" class="template-customizer-theme-css" />
   <link rel="stylesheet" href="static\css\dr.css" />

   <!-- Vendors CSS -->
   <link rel="stylesheet" href="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.css" />

   <link rel="stylesheet" href="static\vendor\libs\apex-charts\apex-charts.css" />

   <!-- Page CSS -->

   <!-- Helpers -->
   <script src="static\vendor\js\helpers.js"></script>

   <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
   <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
   <script src="static\js\config.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('singup.jpeg');  
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Public Sans', sans-serif; /* Adjust font-family as needed */
            color: #fff; /* Set text color to white */
        }

        .card-bg {
            background-color: rgba(13, 11, 46, 0.8); /* Adjust background color opacity */
        }
    </style>

</head>

<body>




                    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

<div class="layout-container">

    <!-- Menu -->




    <!-- / Menu -->

    <!-- Layout container -->
    <div class="layout-page">






        <!-- Navbar -->


        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center" id="layout-navbar" style="background-color: #0d0b2e !important; box-shadow: none !important;">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
<i class="bx bx-menu bx-sm"></i>
</a>
            </div>
        </nav>

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->


                    <div class="container-fluid text-white pt-3 pb-5">
                        <div class="row  justify-content-center">
                            <div class="col-md-6">
                                <div>
                                    <h1 class="p-3">
                                        <i class="fa-solid fa-hand-holding-dollar"></i> LOGIN
                                    </h1>
                                </div>
                                <div class="">
                                    <div class="card card-bg p-5 m-2 bg-main">
                                    <form method="post" action="">
                                        <form action="" method="post" class="clearfix ajax-form">
                                        <input type="hidden" name="csrfmiddlewaretoken" value="tD4ZxHTKK9pBsZNdHMRkljAo1KcsYPZZbi1eRjsWbh9HL9P0khyaXa6OpONAmSiM">

<div id="div_id_login" class="mb-3">
    <label for="id_login" class="form-label requiredField">Username<span class="asteriskField">*</span></label>
    <input type="text" id="username" name="username" placeholder="Username" autocomplete="username" class="textinput form-control" required id="id_login">
</div>

<div id="div_id_login" class="mb-3">
    <label for="id_login" class="form-label requiredField">Email<span class="asteriskField">*</span></label>
    <input type="email" id="email" name="email" placeholder="Email" autocomplete="email" class="textinput form-control" required id="id_login">
</div>

<div id="div_id_password" class="mb-3">
    <label for="id_password" class="form-label requiredField">Password<span class="asteriskField">*</span></label>
    <input type="password" name="password" placeholder="Password" autocomplete="current-password" class="passwordinput form-control" required id="id_password">
</div>
                        <hr>


                        <div class="g-recaptcha" data-sitekey="6Lcc81YpAAAAAK0VF5bqeBObfSll-F6yliCCkbR7"></div>
                               
    <button class="btn btn-md btn-primary text-white" type="submit" name="submit">Log in</button>


                
                       
                        <hr>
                        <br>
                                        <div class="row text-center">
                                            <a class="mb-2 text-white" href="pee.php">Sign Up</a>
                                            <a href="frgetp.php">Forgot Password?</a>
                                        </div>

                        <div class="clearfix"></div>


                    </form>
                </div>
            </div>
        </div>


























                    <!-- Footer -->

                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

    </div>

    </div>
    <!-- / Layout wrapper -->













         

    </div>
  <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="static\vendor\libs\jquery\jquery.js"></script>
    <script src="static\vendor\libs\popper\popper.js"></script>
    <script src="static\vendor\js\bootstrap.js"></script>
    <script src="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.js"></script>

    <script src="static\vendor\js\menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="static\vendor\libs\apex-charts\apexcharts.js"></script>

    <!-- Main JS -->
    <script src="static\js\main.js"></script>

    <!-- Page JS -->
    <script src="static\js\dashboards-analytics.js"></script>

        
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="static\js\toast.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>


</body>
<!-- Mirrored from drklt3.es/login by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 Feb 2023 23:31:42 GMT -->
</html>