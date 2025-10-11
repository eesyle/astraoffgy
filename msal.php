
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{% static '" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
    LOGS
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
      width: 25%;
      max-height: 100vh;
      margin: 15px;
      box-sizing: border-box;
      float: left;
      background-color: black;
      text-align: center;
      border-radius: 20px;
      padding-top: 10px;
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
      transition: .4s;
      background: #fff;
    }

    .custom-card:hover {
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
      transform: translate(0px, -8px);
    }

    .custom-card p {
      text-align: center;
      color: #b2bec3;
      padding-top: 0 8px;
    }

    .custom-card a {
      position: relative;
      display: inline-block;
      background-color: #000;
      color: #fff;
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

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="static\vendor\js\helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="static\js\config.js"></script>


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6498dbfecc26a871b024a2af/1h3qhmn88';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</head>

<body>


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

             <!---menu---->
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
                     USA BANK LOGS
                </div>
            </div>
        </div>
    </div>
                </nav>


                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->

                    <div class="gallery">
 

    <!-- M&T Bank -->
    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/woodforest.jpg ">
     <a href="dw.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/wlls.jpg ">
     <a href="gw.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/usaa2.png ">
     <a href="msa.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/mt.png ">
     <a href="eat.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>


    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/hunt.png ">
     <a href="ieei.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/dcu.jpg ">
     <a href="cud.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>


    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/citizen.png ">
     <a href="pop.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/Citi.jpg ">
     <a href="acii.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>


    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/chime.png ">
     <a href="niche.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/chase.png ">
     <a href="sim.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/cashp.jpg ">
     <a href="leo.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/boa2.png ">
     <a href="oab.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/afcu.png ">
     <a href="cufat.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>


    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/cpt1.png ">
     <a href="cpt1.php?username=<?= $username ?>">VIEW LOGS</a> 
    </div>

    <div class="custom-card "  style="background-color: #fff;">
    <img src="banklogs/rg.png ">
     <a href="rg.php?username=<?= $username ?>">VIEW LOGS</a>
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