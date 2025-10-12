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
// Dashboard counters: subtle, time-of-day biased updates per refresh
$hour = (int)date('G');
if (!isset($_SESSION['dashboardCounts'])) {
    $_SESSION['dashboardCounts'] = [
        'bank' => mt_rand(22, 30),
        'mobile' => mt_rand(14, 22),
        'dumps' => mt_rand(14, 22),
        'ongoing' => mt_rand(9, 15),
    ];
}
// Bias deltas by time of day: higher during business hours
if ($hour >= 9 && $hour <= 18) {
    $bankDelta = mt_rand(-1, 3);
    $mobileDelta = mt_rand(-1, 3);
    $dumpsDelta = mt_rand(-1, 3);
    $ongoingDelta = mt_rand(-1, 2);
} elseif ($hour >= 19 && $hour <= 22) {
    $bankDelta = mt_rand(-1, 2);
    $mobileDelta = mt_rand(-1, 2);
    $dumpsDelta = mt_rand(-1, 2);
    $ongoingDelta = mt_rand(-1, 2);
} else { // late night / early morning
    $bankDelta = mt_rand(-2, 1);
    $mobileDelta = mt_rand(-2, 1);
    $dumpsDelta = mt_rand(-2, 1);
    $ongoingDelta = mt_rand(-2, 1);
}
// Apply and clamp to sensible ranges
$_SESSION['dashboardCounts']['bank']   = max(20, min(40, $_SESSION['dashboardCounts']['bank'] + $bankDelta));
$_SESSION['dashboardCounts']['mobile'] = max(12, min(32, $_SESSION['dashboardCounts']['mobile'] + $mobileDelta));
$_SESSION['dashboardCounts']['dumps']  = max(12, min(32, $_SESSION['dashboardCounts']['dumps'] + $dumpsDelta));
$_SESSION['dashboardCounts']['ongoing']= max(8,  min(24, $_SESSION['dashboardCounts']['ongoing'] + $ongoingDelta));
// Keep relations plausible
if ($_SESSION['dashboardCounts']['mobile'] > $_SESSION['dashboardCounts']['bank'] - 1) {
    $_SESSION['dashboardCounts']['bank'] = $_SESSION['dashboardCounts']['mobile'] + mt_rand(1, 3);
}
// Ongoing typically smaller than mobile
$_SESSION['dashboardCounts']['ongoing'] = max(8, min(
    24,
    (int)round($_SESSION['dashboardCounts']['mobile'] * mt_rand(40, 70) / 100)
));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title>Orders</title>
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
        <?php include 'sideBar.php'; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->


        <div class="content-body">
            <div class="container-fluid">
                <style>
                    .stat-card{background:#1f2a38;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,.25);color:#e5e7eb;padding:16px;position:relative}
                    .stat-card .accent{height:4px;border-radius:0 0 12px 12px;position:absolute;bottom:0;left:0;right:0;opacity:.9}
                    .stat-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:10px}
                </style>
                <div class="row mb-4">
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background:#2d3b4f"><i class="bi bi-bank text-info"></i></div>
                                    <h3 class="mb-0"><?= htmlspecialchars($_SESSION['dashboardCounts']['bank']); ?></h3>
                                    <small>Updated Bank Logs</small>
                                    <div class="accent" style="background:#3b82f6"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background:#2d3b4f"><i class="bi bi-phone text-warning"></i></div>
                                    <h3 class="mb-0"><?= htmlspecialchars($_SESSION['dashboardCounts']['mobile']); ?></h3>
                                    <small>Added Mobile Logs</small>
                                    <div class="accent" style="background:#f59e0b"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background:#2d3b4f"><i class="bi bi-collection text-success"></i></div>
                                    <h3 class="mb-0"><?= htmlspecialchars($_SESSION['dashboardCounts']['dumps']); ?></h3>
                                    <small>Newly loaded dumps</small>
                                    <div class="accent" style="background:#10b981"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background:#2d3b4f"><i class="bi bi-arrow-repeat text-info"></i></div>
                                    <h3 class="mb-0"><?= htmlspecialchars($_SESSION['dashboardCounts']['ongoing']); ?></h3>
                                    <small>Ongoing Transactions</small>
                                    <div class="accent" style="background:#22d3ee"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <style>
                    /* Modern dark table styling */
                    .card-dark{background:#1f2a38;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,.25)}
                    .table-dark thead th{color:#9ca3af;border-bottom:1px solid rgba(255,255,255,.1)}
                    .table-dark tbody tr:hover{background:#243344}
                </style>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-dark">
                            <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                <h4 class="text-white mb-0">Orders</h4>
                                <small class="text-muted">Your recent purchases</small>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-responsive-lg table table-hover table-dark mb-0 dataTablesCard order-table card-table text-white" id="example5">
                                        <thead>
                                            <tr>
                                                <th scope="col">#O-ID</th>
                                                <th scope="col">Type</th>
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
                                                        <ul class="pl-3 mb-0">
                                <?php 
                                $infoItems = explode('+', $amount['Info']); 
                                foreach ($infoItems as $item): 
                                ?>
                                    <li><i class="bi bi-check"></i> <?php echo htmlspecialchars(trim($item)); ?></li>
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
