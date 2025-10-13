<?php
 require_once "codeForLogs.php";
 if($balance>0){
    $sql = "SELECT id, balance, info, price FROM hsbc where price > $balance";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $rows = [];
    }
}else{
    $sql = "SELECT id, balance, info, price FROM hsbc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $rows = [];
}
}
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title>HoldLogix</title>
    <meta property="og:title" content="Astradox Pro — UK Banks">
    <meta property="og:description" content="Explicit Dumps">
    <meta property="og:image" content="assets/logo.png">
 

    <!-- FAVICONS ICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon-16x16.png">
    <link rel="manifest" href="assets/site.webmanifest">
    <link rel="shortcut icon" type="image/png" href="assets/favicon-32x32.png">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="xui-main/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
      <!-- Bootstrap Icons -->
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Style css -->
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">
    <style>
      /* Monochrome table: black / white / grey only */
      #example5 thead th,
      .dataTablesCard .card-table .table thead th {
        background: var(--bg-3) !important;
        color: var(--text-1) !important;
        border-bottom-color: var(--border) !important;
      }
      #example5,
      #example5 tbody td,
      #example5 tbody tr {
        background: var(--bg-2) !important;
        color: var(--text-1) !important;
      }
      #example5 tbody tr:nth-of-type(odd) { background-color: var(--bg-1) !important; }
      #example5 tbody tr:hover { background-color: var(--bg-2) !important; }
      #example5 .bi-check { color: var(--text-1) !important; }
      #example5 h2 strong { color: var(--text-0) !important; }
      #example5 .btn { background: var(--bg-3) !important; color: var(--text-1) !important; border: 1px solid var(--border) !important; }
      #example5 .btn:hover { background: var(--bg-2) !important; }
      .dataTables_wrapper .dataTables_paginate .paginate_button { background: var(--bg-3) !important; color: var(--text-1) !important; border-color: var(--border) !important; }
      .dataTables_wrapper .dataTables_paginate .paginate_button.current,
      .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: var(--bg-2) !important; }
    </style>
</head>

<body>

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
                                UK Banks </div>
                        </div>

                        <?php
 
 $headerFile = './header.php';
 if (is_readable($headerFile)) {
     include($headerFile);
 } else {
     echo "Error: Unable to include $headerFile";
 }
 ?>

                         
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
        <?php include 'sidebar.php'; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">

                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">UK-Banks > HSBC</a></li>
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
 

                                <table class="table-responsive-lg table display mb-4 dataTablesCard order-table card-table dataTable no-footer student-tbl" id="example5">
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
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td class="d-none d-md-block d-lg-block"><code class="text-light">#<?php echo htmlspecialchars($row['id']); ?></code></td>
                        <td>
                            <span style="font-size:5px; opacity: 0.015;"><?php echo htmlspecialchars($row['balance']); ?></span>
                            <h2><sup>$</sup> <strong class="text-white"><?php echo number_format($row['balance'], 2); ?></strong></h2>
                        </td>
                        <td class="whitesp-no">
                            <ul>
                                <?php 
                                $infoItems = explode('+', $row['info']); 
                                foreach ($infoItems as $item): 
                                ?>
                                    <li><i class="bi bi-check"></i> <?php echo htmlspecialchars($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="whitesp-no amount">$<?php echo number_format($row['price'], 2); ?></td>
                        <td>
                            <form method="post" action="buy.php">
                                <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
                                <input type="hidden" name="bank" value="HSBC">
                                <button type="submit" class="btn btn-rounded btn-xs">Buy</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No data available</td>
                </tr>
            <?php endif; ?>
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
    <?php include 'topModel.php'; ?>
    <!-- /Modal -->



        </div>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!-- Modal -->
  <?php include './supportModel.php';?>
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
    <script src="xui-main/js/dlabnav-init.js"></script>
    <script src="xui-main/js/styleSwitcher.js"></script>
    <script src="xui-main/js/demo.js"></script>

    <script type="text/javascript">
        function copyToClip(c) {
            // Copy the text inside the text field
            navigator.clipboard.writeText(c);

            // Alert the copied text
            alert("Copied: " + c);
        }
    </script>

</body>

</html>