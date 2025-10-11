<?php
 
include 'codeForOther.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
if (!isset($_SESSION['username'])) {
    die("Username not set in session.");
}

$username = $_SESSION['username'];
 
 
$query = "SELECT * FROM users WHERE username='$username'";
$query_run = mysqli_query($conn, $query);

if ($query_run && mysqli_num_rows($query_run) > 0) {
    $user = mysqli_fetch_assoc($query_run);
    $currentBalance = $user['balance'];
    
} else {
    die("Failed to fetch user data or no data found.");
}
 
$query = "SELECT * FROM history";
$query_run = mysqli_query($conn, $query);

function getBalanceFromDatabase($twoDaysLater = null) {
    global $conn, $username;

    $currentDate = strtotime(date('Y-m-d'));
    $result = "SELECT statusComplete, date FROM users WHERE username='$username'";
    $query_run = mysqli_query($conn, $result);

 
    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $user = mysqli_fetch_assoc($query_run);
        $date = strtotime($user['date']);
   
        $statusComplete = $user['statusComplete'];
        if ($statusComplete != 1 && $date < strtotime('-2 days', $currentDate)) {
            $statusComplete = 0;   
        }
    }

    return $statusComplete;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title>Alteryx  </title>
    <meta property="og:title" content="Astradox Pro — Us Banks">
    <meta property="og:description" content="Explicit Dumps">
    <meta property="og:image" content="assets/logo.png">

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="assets/logo.png">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="xui-main/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Style css -->
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">
</head>

<body>
    <div id="main-wrapper">
        <?php include "navHeader.php"; ?>
        <div class="header" style="background: #2d2362; opacity: .9;">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">Orders</div>
                        </div>
                        <?php include 'header.php'; ?>
                    </div>
                </nav>
            </div>
        </div>
         
                <!--**********************************
            Sidebar start
        ***********************************-->
        <?php include 'sidebar.php'; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->


        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="">
                            <div class="border-0 flex-wrap">
                                <h4 class="fs-18 font-w600">Orders</h4>
                            </div>
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table-responsive-lg table display mb-4 dataTablesCard order-table card-table text-black dataTable no-footer student-tbl" id="example5">
                                        <thead>
                                            <tr>
                                                <th scope="col">#O-ID</th>
                                                <th scope="col">Order Type</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Info</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($query_run && mysqli_num_rows($query_run) > 0) {
                                                while ($amount = mysqli_fetch_assoc($query_run)) {
                                                    $date = strtotime($amount['date']);
                                                    $currentDate = strtotime(date('Y-m-d'));
                                                    $twoDaysLater = strtotime('+2 days', $date);
                                                    $statusComplete = getBalanceFromDatabase($twoDaysLater);
                                                    ?>
                                                    <tr>
                                                        <td scope="col"><?= htmlspecialchars($amount['id']); ?></td>
                                                        <td scope="col">Purchase</td>
                                                        <td scope="col"><?= htmlspecialchars($amount['date']); ?></td>
                                                        <td scope="col">
                                                        <ul>
                                <?php 
                                $infoItems = explode('+', $amount['Info']); 
                                foreach ($infoItems as $item): 
                                ?>
                                    <li><i class="bi bi-check" scope="col"></i> <?php echo htmlspecialchars($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                                                        
                                                        
                                                        
                                                        
                                                        
                                             </td>
                                                        <td scope="col">
                                                            <?php
                                                            if ($statusComplete == 1) {
                                                                echo 'Complete';
                                                            } elseif ($statusComplete == 0 && $twoDaysLater <= $currentDate) {
                                                                echo 'Cancelled';
                                                            } else {
                                                                echo 'Pending';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'><h5>No Record Found</h5></td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required vendors -->
    <script src="xui-main/vendor/global/global.min.js"></script>
    <script src="xui-main/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="xui-main/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script src="xui-main/vendor/toastr/js/toastr.min.js"></script>
    <script src="xui-main/vendor/apexchart/apexchart.js"></script>
    <script src="xui-main/vendor/peity/jquery.peity.min.js"></script>
    <script src="xui-main/vendor/chartist/js/chartist.min.js"></script>
    <script src="xui-main/vendor/jquery-autocomplete/jquery-ui.js"></script>
    <script src="xui-main/js/dashboard/dashboard-1.js"></script>
    <script src="xui-main/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="xui-main/js/plugins-init/datatables.init.js"></script>
    <script src="xui-main/js/custom.min.js"></script>
    <script src="xui-main/js/dlabnav-init.js"></script>
    <script src="xui-main/js/styleSwitcher.js"></script>
    <script src="xui-main/js/demo.js"></script>

    <script type="text/javascript">
        function copyToClip(c) {
            navigator.clipboard.writeText(c);
            alert("Copied: " + c);
        }
    </script>
</body>

</html>
