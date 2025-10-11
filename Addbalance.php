<?php
require_once 'conkt.php';
if (!isset($_GET['username']))
{
     echo "Invalid username";
}
$username = $_GET['username'];

if ($conn->connect_error) {
    die("Fatal Error: " . $conn->connect_error);
}
 
if(isset($_POST['submit'])){

    $amount = get_post($conn, 'amount');
        $urlt = "shybtop.php?amount=".$amount."&username=".$username;
        header('location: '.$urlt);
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
        TOP UP ACCOUNT
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

    
</head>

<body>


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            <!-- Menu -->
            <?php include 'dash.php'; ?>

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
                    <div class="d-xl-block text-white text-center w-100">
        <div class="row mx-auto">
            <div class="col-12">
                <div class="h4 display-5 h4-display">
                    Top Up Account
                </div>
            </div>
        </div>
    </div>
                </nav>


                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->

                    <div class="container-fluid text-white pt-3 pb-5">
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                 
                                <div class="">
                                    <div class="card card-bg p-2 m-2">
                                        <h3 class="text-warning p-3">Attention!</h3>
                                        <hr>
                                        <p class="content p-2">
                                            <!-- You can Deposit a minimum amount of $30.00 and these funds
                will immediatley go to your personal account.
                <br> -->
                                            The conversion rate is in USD, it is updated from <span><a href="https://www.blockchain.com/explorer/assets/btc" target="_blank">blockchain.info</a></span> at the time of receipt of funds to the account.
                                        </p>
                                    </div>

                                    <div class="card card-bg p-2 m-2 bg-main">
                                        <form action="" method="post" class="forms-control">
                                            <input type="hidden" name="csrfmiddlewaretoken" value="tRBmvqBH6geHEFEcgBgaVoNHx7a9m7SiASel32nyhzOhCVMcGZu4SpJtxfG0hAcP">


                                            <div id="div_id_amount" class="mb-3"> <label for="id_amount" class="form-label requiredField">
                Amount<span class="asteriskField">*</span> </label> <input type="number" name="amount" step="0.01" class="numberinput form-control" required id="id_amount"> </div>

                                            <br>

                                            <input type="submit" class="btn btn-md btn-primary text-white" name="submit" value="Send">
                                        </form>
                                        <br>
                                    </div>


                                </div>

                            </div>
                            <div class="col-md-2"></div>

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


        <div id="toast-container" class="toast-top-left">
            <div class="toast toast-success bg-success" aria-live="polite" style="background-color: black;">
                <div class="toast-title"> </div>
                <div class="toast-message"> </div>
            </div>
        </div>


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