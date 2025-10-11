<?php
if (!isset($_GET['username']))
{
      header('Location: logIn.php');
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

    <title>HoldLogix</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon-16x16.png">
    <link rel="manifest" href="assets/site.webmanifest">

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
 
    <link href="static/css/grayscale.css" rel="stylesheet">
</head>

<body>


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            <!-- Menu -->

    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme sidenav-bg-color" style="background-color: #07102e !important; color: white !important;">


        <ul class="menu-inner py-1 pt-5">
        
           
<li class="menu-item py-1">
                <a href="#" class="menu-link">
                    <div data-i18n="Basic">Logged in as <?=$username ?></div>
                </a>
            </li>


<li class="menu-item py-1">
                        <a href="#" class="menu-link">
                            <div data-i18n="Basic">Balance:  <?php require_once 'conkt.php';
                           

                             
                            $username= $_GET["username"];
                        if ($conn->connect_error) die("Fatal Error");
                            $query = "SELECT * FROM  users WHERE UserName='$username'";
                            $query_run = mysqli_query($conn, $query);
                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $balance = mysqli_fetch_array($query_run);
                            }
                                ?>
                                $<?= $balance['Balance']; ?>.00
                                

                        </div>
                        </a>
                    </li>
            
                   <!-- Dashboard -->
                    <li class="menu-item py-1">
                        <a href="Addbalance.php?username=<?=$username?>" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-credit-card'></i>
        <div data-i18n="Analytics">ADD BALANCE</div>
      </a>
                    </li>


                    <li class="menu-item active">
                        <a href="Dashboad.php?username=<?=$username?>" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-dashboard' ></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
                    </li>



                    <li class="menu-item py-1">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
        
        <i class='menu-icon tf-icons bx bxs-bank'></i>
        
        <div data-i18n="Basic">USA BANKS</div>
      </a>
                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="woodForestbank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Woodforest Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="WellsFargoBank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Wells Fargo Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="usaa.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">USAA Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="MT_Bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">M&amp;T Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="Hunting_Bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Huntington Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="DCU_Bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">DCU Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="Citizen_Bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Citizens Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="citi_bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Citi Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="chime_bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Chime Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="chase_bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Chase Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="CashApp.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Cash App Logs</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="Boa_bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Bank of America (BOA)</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="afcu_bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">AFCU Bank</div>
                                </a>
                            </li>
                             <li class="menu-item">
                                <a href="cpt1.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">CAPITAL ONE Bank</div>
                                </a>
                            </li>
                             <li class="menu-item">
                                <a href="rg.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">REGION  Bank</div>
                                </a>
                            </li>
                       

                        </ul>
                    </li>

                    <li class="menu-item py-1">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
        
        <i class='menu-icon tf-icons bx bxs-bank'></i>
         <div data-i18n="Basic"> AUSTRALIA BANKS</div>
      </a>
                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="nab.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">NATIONAL AUSTRALIA Bank</div>
                                </a>
                            </li>
                            
                            
                            
                             <li class="menu-item">
                                <a href="anz.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">ANZ Bank</div>
                                </a>
                            </li>
                            
                             <li class="menu-item">
                                <a href="amp.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">SURNCORP BANK</div>
                                </a>
                            </li>
                            
                          

                             
 
                            
                        </ul>
                    </li>

                    <li class="menu-item py-1">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bxs-bank'></i>
        
       
                            
        <div data-i18n="Basic">UK BANKS</div>
      </a>
                        <ul class="menu-sub">

                             
                            
                             <li class="menu-item">
                                <a href="barcly.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">BARCLAYS Bank</div>
                                </a>
                            </li>
                            
                             <li class="menu-item">
                                <a href="rbs.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">Santander UK</div>
                                </a>
                            </li>
                           
                           
                        </ul>
                    </li>
                    <li class="menu-item py-1">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class='menu-icon tf-icons bx bxs-bank'></i>
        
        <div data-i18n="Basic">CANADA BANKS</div>
      </a>
                        <ul class="menu-sub">
                            
                             <li class="menu-item">
                                <a href="hc.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">HSBC Bank</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="td_bank.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">TD Canada</div>
                                </a>
                            </li>
                            
                            <li class="menu-item">
                                <a href="cibc.php?username=<?=$username?>" class="menu-link">
                                    <div data-i18n="Error">CIBC Bank</div>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li class="menu-item">
                        <a href="PayPal.php?username=<?=$username?>" class="menu-link">
                            <div data-i18n="Error">PayPal</div>
                        </a>
                    </li>




                    <div class="py-3 menu-item">
                        <li class="menu-item">
                            <a href="history2.php?username=<?=$username?>" class="menu-link">
          <i class='menu-icon tf-icons bx bx-history' ></i>
          <div data-i18n="Basic">PURCHASE HISTORY</div>
        </a>
                        </li>
                        <li class="menu-item">
                            <a href="TopUp.php?username=<?=$username?>" class="menu-link">
          <i class='menu-icon tf-icons bx bxs-dollar-circle'></i>
          <div data-i18n="Basic">TRANSACTION HISTORY</div>
        </a>
                        </li>
                        <li class="menu-item">
                            <a href="signOut.php" class="menu-link">
          <i class='menu-icon tf-icons  bx bx-log-out'></i>
          <div data-i18n="Basic">LOGOUT</div>
        </a>
                        </li>
                    </div>

                </ul>
            </aside>





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

                    <div class="container-fluid text-white">
                        <div class="container">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6">
                                    <div class="h4 display-5">
                                        HSBC BANK
                                    </div>
                                    <p>
                                        [Online Access]+[Account/Routine Number]+[Name And Address]+[Email Access]+[Credit Card Details]
                                    </p>
                                </div>
                                <div class="col-md-6 align-items-right ">
                                    <a href="Dashboad.php?username=<?=$username?>" class="align-items-right">Dashabord</a> /  HSBC BANK
                                </div>
                            </div>

                            <div class="row py-2">
                                <div class="bg-dark2 text-white">
                                    <h5 class="card-header text-white"> HSBC Bank</h5>
                                </div>

                                <div class="table-responsive text-noswrap pt-1">
                                    <table class="table table-bordered table-responsive" id="boa">
                                        <thead>
                                            <tr>

                                                <th class="text-white">#</th>
                                                <th class="text-white">Balance</th>
                                                <th class="text-white">Title</th>
                                                <th class="text-white">Info</th>
                                                <th class="text-white">Price</th>
                                                <th class="text-white">Status</th>
                                                <th class="text-white">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
       
                                        <?php
                                       
require_once 'conkt.php';

if ($conn->connect_error) die("Fatal Error");

$query = "SELECT  * FROM hsbc  ORDER BY RAND()";
$query_run = mysqli_query($conn, $query);

$labels = ["Available", "Sold"];

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $bank) {
        $id += 1;
        shuffle($labels); // Shuffle the labels randomly for each row
        $label = $labels[0]; // Select a shuffled label
        $labelClass = ($label === "Sold") ? "btn btn-danger blink_me" : "btn btn-success blink_me";
        $disabled = ($label === "Sold") ? "disabled" : "";
        $link = ($label === "Sold") ? "javascript:void(0);" : "paymentMethod.php?username=<?=$username?>";
       
 
        ?>
        <tr>
            <td class='text-white'><?= $id; ?></td>
            <td class='text-white'>$<?= $bank['Balance']; ?></td>
            <td class='text-white'><?= $bank['Title']; ?></td>
            <td class='text-white'><?= $bank['info']; ?></td>
            <td class='text-white'>$<?= $bank['price']; ?></td>
            <td>
                <label class='<?= $labelClass; ?>'><?= $label; ?></label>
            </td>

            <td>
            <form method="post" action="CnfirmEmailToBuyhsbc.php?username=<?=$username?>">
    <!-- Other form elements go here, if any -->
    <input type="hidden" name="bank_id" value="<?= $bank['id']; ?>">
    <a href="<?= $link; ?>">
                    <button class='btn btn-primary' type='submit' role='button' name="buy" <?= $disabled; ?>>
                        Buy
                        <div>
                            <i class='bx bxs-cart-alt'></i>
</form>
               
                        </div>
                    </button>
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    echo "<h5> No Record Found </h5>";
}
?>
                                             
                                        </tbody>
                                    </table>
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