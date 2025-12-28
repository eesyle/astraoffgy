<?php
session_start();
require_once "config.php";
require_once "codeForLogs.php";

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    echo "You are not logged in.";
    exit();
}

// Fetch user balance
$balance = 0.00;
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    // Use 'price' as balance based on findings in CnfirmEmailToBuyW.php
    $balance = (float)($row['price'] ?? 0.00);
}

// Product Prices
$socksPrice = 60.00;
$ratsPrice = 50.00;

?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="static/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Verified Products | HoldLogix</title>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="static/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="static/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="static/vendor/fonts/boxicons.css" />

    <!-- Custom Styles -->
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/grayscale.css">
    
    <style>
        .product-card {
            background: rgba(35, 39, 68, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        .icon-box {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(105, 108, 255, 0.1);
        }
        .price-tag {
            font-size: 2.5rem;
            font-weight: 700;
            color: #696cff;
        }
        .feature-list li {
            margin-bottom: 12px;
            color: #a1acb8;
            font-size: 1.1rem;
        }
        .feature-list i {
            color: #00d25b; /* Success green */
            margin-right: 10px;
        }
        .bg-label-success {
            background-color: rgba(0, 210, 91, 0.1) !important;
            color: #00d25b !important;
        }
    </style>
</head>

<body>

    <?php include './navHeader.php'; ?>

    <!-- Header Start -->
    <div class="header" style="background: #2d2362; opacity: .9;">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Verified Products
                        </div>
                    </div>
                    <?php
                    $headerFile = './header.php';
                    if (is_readable($headerFile)) {
                        include($headerFile);
                    }
                    ?>
                </div>
            </nav>
        </div>
    </div>
    <!-- Header End -->

    <?php include './sidebar.php'; ?>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="content-wrapper">
                    
                    <div class="container-fluid text-white pt-5 pb-5">
                        
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <h2 class="text-white mb-3">Premium Verified Products</h2>
                                <p class="text-muted">Exclusive access for verified account holders.</p>
                                <div class="alert alert-info d-inline-block">
                                    Your Balance: <strong>$<?= number_format($balance, 2) ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            
                            <!-- SOCKS Product -->
                            <div class="col-md-5 mb-4">
                                <div class="card product-card h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="icon-box rounded-circle p-3">
                                                <i class="fas fa-network-wired fa-2x text-primary"></i>
                                            </div>
                                            <span class="badge bg-label-success px-3 py-2">Available</span>
                                        </div>
                                        <h3 class="card-title text-white">Premium SOCKS Proxy</h3>
                                        <div class="price-tag mb-3">$<?= number_format($socksPrice, 2) ?></div>
                                        <p class="card-text text-muted mb-4">
                                            High-performance SOCKS5 proxies offering superior anonymity and speed. Ideal for secure browsing and bypassing geo-restrictions.
                                        </p>
                                        <ul class="list-unstyled feature-list">
                                            <li><i class="fas fa-check-circle"></i> 99.9% Uptime Guarantee</li>
                                            <li><i class="fas fa-check-circle"></i> Unlimited Bandwidth</li>
                                            <li><i class="fas fa-check-circle"></i> Residential IPs Available</li>
                                            <li><i class="fas fa-check-circle"></i> Instant Activation</li>
                                        </ul>
                                        
                                        <?php if ($balance >= $socksPrice): ?>
                                            <form action="sendtop.php" method="POST">
                                                <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                                                <input type="hidden" name="wfprice" value="<?= $socksPrice ?>">
                                                <input type="hidden" name="trigger" value="socks">
                                                <input type="hidden" name="submit" value="1">
                                                <button type="submit" class="btn btn-primary w-100 mt-3 btn-lg" onclick="return confirm('Are you sure you want to purchase SOCKS Proxy for $<?= number_format($socksPrice, 2) ?>?');">
                                                    Buy Now
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-secondary w-100 mt-3 btn-lg" disabled>
                                                Insufficient Balance (Need $<?= number_format($socksPrice, 2) ?>)
                                            </button>
                                            <div class="text-center mt-2">
                                                <a href="#" class="text-primary small" data-bs-toggle="modal" data-bs-target="#topUpAccountModal">Top up your wallet</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- RATS Product -->
                            <div class="col-md-5 mb-4">
                                <div class="card product-card h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="icon-box rounded-circle p-3">
                                                <i class="fas fa-bug fa-2x text-danger"></i>
                                            </div>
                                            <span class="badge bg-label-success px-3 py-2">Available</span>
                                        </div>
                                        <h3 class="card-title text-white">Premium Remote Tool (RATS)</h3>
                                        <div class="price-tag mb-3">$<?= number_format($ratsPrice, 2) ?></div>
                                        <p class="card-text text-muted mb-4">
                                            Advanced remote administration tool for professional network management and security testing.
                                        </p>
                                        <ul class="list-unstyled feature-list">
                                            <li><i class="fas fa-check-circle"></i> Full Remote Access</li>
                                            <li><i class="fas fa-check-circle"></i> Encrypted Connection</li>
                                            <li><i class="fas fa-check-circle"></i> File System Control</li>
                                            <li><i class="fas fa-check-circle"></i> 24/7 Premium Support</li>
                                        </ul>

                                        <?php if ($balance >= $ratsPrice): ?>
                                            <form action="sendtop.php" method="POST">
                                                <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                                                <input type="hidden" name="wfprice" value="<?= $ratsPrice ?>">
                                                <input type="hidden" name="trigger" value="rats">
                                                <input type="hidden" name="submit" value="1">
                                                <button type="submit" class="btn btn-primary w-100 mt-3 btn-lg" onclick="return confirm('Are you sure you want to purchase Premium Remote Tool for $<?= number_format($ratsPrice, 2) ?>?');">
                                                    Buy Now
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-secondary w-100 mt-3 btn-lg" disabled>
                                                Insufficient Balance (Need $<?= number_format($ratsPrice, 2) ?>)
                                            </button>
                                            <div class="text-center mt-2">
                                                <a href="#" class="text-primary small" data-bs-toggle="modal" data-bs-target="#topUpAccountModal">Top up your wallet</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <?php include 'topModel.php'; ?>
    <!-- Core JS -->
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