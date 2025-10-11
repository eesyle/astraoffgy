
<?php
require_once 'conkt.php';
if($conn->connect_error) die("Fatal Error");
if(isset($_POST['submit']))
{
    $email = get_post($conn, 'email');
$password1 = get_post($conn, 'password1');
$password2 = get_post($conn, 'password2');
 
 
	if($password1 == $password2){
		$query = "UPDATE users SET  PassWord= '$password1' WHERE  Email ='$email'";
        $result = $conn->query($query);
if($result){
    header('location: emailchanged.php');
}

if(!$result) echo "UPDATE failed!<br /><br />";
 
	else{
		echo "<script> alert('The passwords don't match');</script>";
	}
}
 
	}
    
function get_post($conn, $var){
    return $conn->real_escape_string($_POST[$var]);
}
    ?>

<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{% static '" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        Change Password
    </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <!-- <link rel="icon" type="image/x-icon" href="https://www.inlaks.com/wp-content/uploads/2019/08/Inlaks-Favicon.png"-->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="/static/vendor/fonts/boxicons.css" />

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


                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->


                    <div class="container-fluid text-white pt-3 pb-5">
                        <div class="row  justify-content-center">
                            <div class="col-md-6"> >
                                <div class="">
                                    <div class="card card-bg p-5 m-2 bg-main">
                                        <h2>Change Password</h2>


                                        <form method="POST" action="">
                                            <input type="hidden" name="csrfmiddlewaretoken" value="fnLN5gIz3uby0Bb9LPX3hHRATH0bwDWzmooMDSuqeNL8YRj9bdbXeINmTPw2r6g6">


                                            
                                            <div id="div_id_password1" class="mb-3"> <label for="id_password1" class="form-label requiredField">
                Email<span class="asteriskField">*</span> </label> <input type="email" name="email" placeholder="Your Current"  class="passwordinput form-control" required id="id_password1"> </div>
                                            <div id=
                                            <div id="div_id_password1" class="mb-3"> <label for="id_password1" class="form-label requiredField">
                New Password<span class="asteriskField">*</span> </label> <input type="password" name="password1" placeholder="New Password" autocomplete="new-password" class="passwordinput form-control" required id="id_password1"> </div>
                                            <div id="div_id_password2"
                                                class="mb-3"> <label for="id_password2" class="form-label requiredField">
                New Password (again)<span class="asteriskField">*</span> </label> <input type="password" name="password2" placeholder="New Password (again)" class="passwordinput form-control" required id="id_password2"> </div>

                                            <button class="btn btn-primary" name="submit" type="submit">Change Password</button>
                                        </form>





                                        <br>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3"></div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="static\js\toast.js"></script>

    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>
</body>

</html>