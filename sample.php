 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title>Altreyx :: Home </title>
 
    <!-- FAVICONS ICON -->
<link rel="shortcut icon" type="image/png" href="assets/logo.png">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="xui-main/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <!-- Style css -->
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     
    
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="inner">
            <span>Loading </span>
            <div class="loading">
            </div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <!-- **********************************
        Main wrapper start
    *********************************** -->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
                 <?php include './navHeader.php'?>;
        <!--**********************************
            Nav header end
        ***********************************-->


        <!--**********************************
            Header start
        ***********************************-->
        <div class="header" style="background: #2d2362; opacity: .9;">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                Home </div>
                         </div>

                       <?php include './header.php'; ?>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
       <?php include './sidebar.php'?>
        <!--**********************************
            Sidebar end
        ***********************************-->
        <!--**********************************
            Content body start
        ***********************************-->
   
            <!-- row -->
          
                 <div class="content-body">
            <!-- row -->
            <div class="container-fluid">

                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">US-Banks > Chase Bank</a></li>
                    </ol>
                </div>

                <!-- row -->
                <div class="row">
                    <!-- --column-- -->
                    <div class="col-xl-12">
                        <div class="tab-content">
                            <!-- --tab-pane -->
                            <div class="tab-pane fade active show" id="all-transactions" role="tabpanel">
                                <div class="table-responsive ">
 

                                 <table class="table-responsive-lg table display mb-4 dataTablesCard order-table card-table text-black dataTable no-footer student-tbl" id="example5">
    <thead>
        <tr>
            <th class="d-none d-md-block d-lg-block">#</th>
            <th>Balance</th>
            <th>Info</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
         
             <?php
                                        
require_once 'config.php';
 
if ($conn->connect_error) die("Fatal Error");

$query = "SELECT   * FROM chase  ORDER BY RAND()";
$query_run = mysqli_query($conn, $query);

$labels = ["Available", "Sold"];
$id = 0;

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $bank) {
        $id += 1; 
        shuffle($labels); // Shuffle the labels randomly for each row
        $label = $labels[0]; // Select a shuffled label
        $labelClass = ($label === "Sold") ? " color: red;
            font-weight: bold;" : "  color: green;
            font-weight: bold;";
        $disabled = ($label === "Sold") ? "disabled" : "";
        $link = ($label === "Sold") ? "javascript:void(0);" : "shyb.php";
         
        ?>
        <tr  tabindex="0" style="border-bottom: 1px solid #0f172a; padding-bottom: 5px;">
            <td  class="hidden"><?= $id; ?></td>
            <td class="px-2 py-2">
           
            $<strong>
                <?=$bank['Balance']; ?>
                </strong>
          
        </td>
            <td  class="px-2 py-2 text-sm" style="white-space:nowrap;"><?= $bank['info']; ?></td>
            <td  class="px-2 font-medium">$<?= $bank['price']; ?></td>
            <td>
                <label style='<?= $labelClass; ?>'><?= $label; ?></label>
            </td>
            <td>
            <form method="post" action="confirm.php">
    <input type="hidden" name="bank_id" value="<?= $bank['id']; ?>">
    
    <button class='btn btn-primary' type='submit' role='button' name="buy" <?= $disabled; ?>>
        Buy
        <div>
            <i class='bx bxs-cart-alt'></i>
        </div>
    </button>
</form>

                
            </td>
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
                    <!----/column-- -->
                </div>
                <!-- /row -->

            </div>
                                     
                                     
                                        
                            
                            

                                    
                             
 

            <!-- Modal -->
            <div class="modal fade" id="usBankLogsMod">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="mailto:support@altrexy.com">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">US Bank Logs</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                   <?php include 'usBanksModel.php'; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Modal -->
            <!-- Modal -->
            <div class="modal fade" id="ukBankLogsMod">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="mailto:support@altrexy.com">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">UK Bank Logs</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                   
                                <?php include 'ukBanksModel.php'; ?>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Modal -->

        </div>
        <!--**********************************
            Content body end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!-- Modal -->
   <?php include 'topModel.php'; ?>
    <!-- /Modal -->

    <!-- Modal -->
   <?php include 'supportModel.php'; ?>
    <!-- /Modal -->
    
       <!-- Modal -->
   <?php include 'reviewModal.php'; ?>
    <!-- /Modal -->


 


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="xui-main/vendor/global/global.min.js"></script>
    <script src="xui-main/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="xui-main/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script src="xui-main/vendor/toastr/js/toastr.min.js"></script>
    <!-- Apex Chart -->
    <script src="xui-main/vendor/apexchart/apexchart.js"></script>
    <!-- Chart piety plugin files -->
    <script src="xui-main/vendor/peity/jquery.peity.min.js"></script>
    <!-- Chartist -->
    <script src="xui-main/vendor/chartist/js/chartist.min.js"></script>
    <script src="xui-main/vendor/jquery-autocomplete/jquery-ui.js"></script>
    <!-- Dashboard 1 -->
    <script src="xui-main/js/dashboard/dashboard-1.js"></script>
    <script src="xui-main/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="xui-main/js/plugins-init/datatables.init.js"></script>
    <script src="xui-main/js/custom.min.js"></script>
    <script src="xui-main/js/styleSwitcher.js"></script>
    <script src="xui-main/js/demo.js"></script>
    <script src="xui-main/js/dlabnav-init.js"></script>
    <script type="text/javascript">
        function copyToClip(c) {
            // Copy the text inside the text field
            navigator.clipboard.writeText(c);

            // Alert the copied text
            alert("Copied: " + c);
        }
    </script>
 <script src="//code.tidio.co/ak1ircuueqeney9nkp6f8fpaemdimrdn.js" async></script>

</body>

</html>