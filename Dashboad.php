<?php
 
if (!isset($_GET['username']))
{
      header('Location: htcm.php');
}
else{
    $username = $_GET['username'];
    $url = "balance.php?username=".$username;  
}
 
?>
 
 <!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{% static '" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        Dashboard
    </title>

    <meta name="description" content="" />

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />

   

     <!-- Icons. Uncomment required icon fonts -->
     <link rel="stylesheet" href="static\vendor\fonts\boxicons.css" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

   <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
   <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
   <script src="static\js\config.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">



    <style>
    .gallery {
      display: flex;
      flex-wrap: wrap;
      width: 100%;
      justify-content: center;
      align-items: center;
      margin: 50px 0;
    }

    .custom-card {
      width: 60%;
      max-height: 100vh;
      margin: 15px auto;
      text-align: center;
      border-radius: 20px;
      padding-top: 10px;
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
      transition: .4s;
 
    }

    .custom-card:hover {
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
      transform: translate(0px, -8px);
    }

    .custom-card p {
      text-align: center;
      color: #fff;
      padding-top: 0 8px;
    }

    .custom-card a {
      position: relative;
      display: inline-block;
      padding: 10px 20px;
      border-radius: 40px;
      margin-top: 20px;
      text-decoration: none;
    }

    img{
    width: 180px;
    height: 140px;
    text-align: center;
    margin: 0 auto ;
    border-radius: 20px;
     display: block; 
 }

    @media (max-width: 1024px) {
      .custom-card {
        width: 45%;
        height: auto;
      }
    }

    @media (max-width: 750px) {
      .custom-card {
        width: 100%;
        height: auto;
      }
    }

    @media (min-width: 35em) {
      .row {
        display: flex;
        margin-left: -.75em;
        margin-right: -.75em;
      }

      .column {
        flex: 1;
        margin-right: 0.75em;
        margin-left: 0.75em;
      }
    }

     



  </style>


 
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
                    <div class="row">
                                <div class="h4 display-5">
                                 
                                </div>
                            </div>



                            <div class="d-xl-block text-white text-center w-100">
        <div class="row mx-auto">
            <div class="col-12">
                <div class="h4 display-5 h4-display">
                WELCOME, <?=$username ?>
                </div>
            </div>
        </div>
    </div>
                     
                </nav>


                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->

                    <div class="container-fluid text-white">
                        <div class="container">
                           
                            <br>
 

 
                                    <div class="card">
                                        <div class="card-header" style="background-color: rgb(21, 21, 66);color:white">
                                            <span class="glyphicon glyphicon-calendar" style="color: #000;"></span>
                                            <p>
                                                Our store embodies a self-written engine, anti-DDoS system and a bulletproof server. Logs are re-checked and updated after each occurrence of issuing bulk purchases. Please do not hesitate to contact the support team if you encounter any issue.
                                            </p>

                                            <p>
                                                Please take the time to read through our policies.
                                            </p>
                                            <p>
                                                The store disclaims any responsibility for any additional actions you take with the purchased log in your possession.
                                            </p>
                                            <p>
                                                Funds sent to the store will be allocated to the user after two confirmations.
                                            </p>
                                            <p>
                                                Get in touch with the SUPPORT TEAM , in case of any queries or inquiries.
                                            </p>
                                            <p>
                                                A token would be issued to any account after three instant purchases or a deposit of more than $1000.
                                            </p>
                                            Accounts that have been inactive for six months will be deactivated.


                                        </div>
                                    </div>



                                                <br>

                                    
                                    <div class="card">
                                    <div class="card-note mt-4" style="background-color: #232138;color:white">
                                        <div class="card-header">
                                        <div class="media align-items-center">
                                                <div class="media-body">
                                                    <h6 class="mb-0 H6-filter-by-text" data-filter-by="text" style="color: white;">
                                                    <p>
                                                            FAQs
                                                        </p>

                                                        <p>
                                                            Q1: How do I add balance?
                                                        </p>

                                                        <p>
                                                            A: To add balance, simply navigate to the sidebar and click the "Add Balance” button. From there, you can pay with bitcoins and follow the prompts to complete the transaction.
                                                        </p>

                                                        <p>
                                                            Q2: Can I buy without adding balance?
                                                        </p>

                                                        A: Yes, you can still make purchases without adding balance to your account. Simply choose your desired product or service, proceed to checkout, and follow the prompts to complete the transaction using your preferred payment method.
                                                    </h6>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    
                                    </div>
                                    
                                    <br>
                                     <div class="row">
                                <div class="text-white">
                                    <p>Recently added</p>
                                </div>
                            </div>
                                

    

        <!-- Woodforest Bank -->
        
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/woodforest.jpg') no-repeat center center; background-size: cover;">
            <p class=" "> Woodforest </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="dw.php?username=<?= $username ?>">Woodforest(Full Info) </a>
            </p>
       
        </div>
   

     

        <!-- Wells Fargo Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/wlls.jpg') no-repeat center center; background-size: cover;">
            <p  style="color: #000;"> Wells Fargo </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="gw.php?username=<?= $username ?>">Wells Fargo(Full Info) </a>
            </p>
            
        </div>
                        

        <!-- USAA Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/usaa2.png') no-repeat center center; background-size: cover;">
            <p class=" "> USAA Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="msa.php?username=<?= $username ?>">USAA Bank (Full Info) </a>
            </p>
            
        </div>

        <!-- TD Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/td.jpg') no-repeat center center; background-size: cover;">
            <p class=" "> TD Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="atew.php?username=<?= $username ?>">TD Bank (Full Info) </a>
            </p>
            
        </div>

        <!-- PayPal -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/ly.png') no-repeat center center; background-size: cover;  background-color: #fff;">
            <p class=" "> PayPal </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="ly.php?username=<?= $username ?>">PayPal (Full Info) </a>
            </p>
            
        </div>

        <!-- M&T Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/mt.png') no-repeat center center; background-size: cover;">
            <p class=" "> M&T Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="eat.php?username=<?= $username ?>">M&T Bank (Full Info) </a>
            </p>
            
        </div>

        <!-- Huntington Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/hunt.png') no-repeat center center; background-size: cover;">
            <p class=" "> Huntington Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="ieei.php?username=<?= $username ?>">Huntington(Full Info) </a>
            </p>
            
        </div>

        <!-- DCU Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/dcu.jpg') no-repeat center center; background-size: cover;  background-color: #fff;">
            <p class=" "> DCU Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="cud.php?username=<?= $username ?>">DCU Bank (Full Info) </a>
            </p>
            
        </div>

        <!-- Citizens Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/citizen.png') no-repeat center center; background-size: cover;">
            <p class=" "> Citizens Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="pop.php?username=<?= $username ?>">Citizens Bank (Full Info) </a>
            </p>
            
        </div>

        <!-- Citi Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/citi2.jpg') no-repeat center center; background-size: cover;">
            <p class=" "> Citi Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="acii.php?username=<?= $username ?>">Citi Bank (Full Info) </a>
            </p>
            
        </div>

        <!-- Chime Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/chime.png') no-repeat center center; background-size: cover;">
            <p class=" "> Chime Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="niche.php?username=<?= $username ?>">Chime Bank (Full Info) </a>
            </p>
            
        </div>

        <!-- Chase Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/chase.png') no-repeat center center; background-size: cover; background-color: #fff;">
            <p class=" "> Chase Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="sim.php?username=<?= $username ?>">Chase Bank (Full Info) </a>
            </p>
            
        </div>

        <!-- Cash App Logs -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/cashp.jpg') no-repeat center center; background-size: cover;">
            <p class=" "> Cash App Logs </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="leo.php?username=<?= $username ?>">Cash App Logs (Full Info) </a>
            </p>
            
        </div>

        <!-- Bank of America (BOA) -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/boa2.png') no-repeat center center; background-size: cover;">
            <p class=" "> Bank of America  </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="oab.php?username=<?= $username ?>">BOA (Full Info) </a>
            </p>
            
        </div>

        <!-- AFCU Bank -->
        <div class="custom-card" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('banklogs/afcu.png') no-repeat center center; background-size: cover;">
            <p class=" "> AFCU Bank </p>
            <h5> Added <?php echo rand(1, 15); ?> logs in this category </h5>
            <small><?php echo date("M. d, Y"); ?></small>
            <p>
                <a href="cufat.php?username=<?= $username ?>">AFCU Bank (Full Info) </a>
            </p>
           
        </div>


</div>

                                

                                   
                            
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


        <div id="toast-container" class="toast-top-left">
            <div class="toast toast-success bg-success" aria-live="polite" style="background-color: black;">
                <div class="toast-title"> </div>
                <div class="toast-message"> </div>
            </div>
        </div>


    </div>

    </div>
    <!-- / Layout wrapper -->
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