<?php
session_start();
require_once "config.php";
require_once "codeForLogs.php";

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} elseif (isset($_GET['username']) && !empty($_GET['username'])) {
    // Allow login via URL parameter (mostly for email links)
    $username = trim($_GET['username']);
    $_SESSION['username'] = $username;
} else {
    // Redirect to login instead of just showing a message
    header("Location: index.php");
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
        .form-check-input {
            width: 1.6rem;
            height: 1.6rem;
            cursor: pointer;
            appearance: none;
            border: 2px solid #a1acb8;
            border-radius: 6px;
            background: transparent;
            position: relative;
            transition: all .2s ease;
        }
        .form-check-input:checked {
            background-color: #00d25b;
            border-color: #00d25b;
            transform: scale(1.05);
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 210, 91, 0.25);
        }
        .form-check-input::after {
            content: "✓";
            color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -52%) scale(0);
            font-size: 1.1rem;
            font-weight: 800;
            transition: transform .15s ease-out;
        }
        .form-check-input:checked::after {
            transform: translate(-50%, -52%) scale(1);
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
                            <div class="col-12">
                                <div class="card bg-dark text-white border-0">
                                    <div class="card-body">
                                        <p class="mb-4">
                                            Tools U need to successful cashout<br>
                                            Please buy these tools to access the banklogins infos (Details)
                                        </p>
                                        <ul class="mb-4">
                                            <li>Remote Access Trojans(RATs): Malware that will provide you With remote access to the victim’s computer allowing you to monitor Moreover, control the account.</li>
                                            <li>Socks proxy: will help you to change your IP address and hide your location While cashing out the funds from the account.</li>
                                        </ul>

                                        <form action="checkout_tools.php" method="POST" id="purchaseForm">
                                            <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                                            
                                            <div class="mb-4">
                                                <label for="rdp_email" class="form-label">Confirm email to receive RDP access</label>
                                                <input type="email" class="form-control" id="rdp_email" name="rdp_email" required placeholder="@email" style="max-width: 400px;">
                                                <div class="form-text text-light">Please verify the above email is correct your RPD ID and Password will be sent to this email.</div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-dark table-bordered text-white">
                                                    <thead>
                                                        <tr>
                                                            <th>Tools</th>
                                                            <th>Description</th>
                                                            <th>Price</th>
                                                            <th>Checkboxes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- RATs -->
                                                        <tr>
                                                            <td>RATs</td>
                                                            <td>Malware that will provide you With remote access to the victim’s computer allowing you to monitor Moreover, control the account.</td>
                                                            <td>$65</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input tool-checkbox" type="checkbox" name="tools[rats]" value="65" data-name="RATs - Remote Access Trojan">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Socks Proxy -->
                                                        <tr>
                                                            <td rowspan="3">Socks Proxy</td>
                                                            <td rowspan="3">will help you to change your IP address and hide your location While cashing out the funds from the account.</td>
                                                            <td>$20/month</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input tool-checkbox" type="checkbox" name="tools[socks_1m]" value="20" data-name="Socks Proxy (1 Month)">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>$45/3month</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input tool-checkbox" type="checkbox" name="tools[socks_3m]" value="45" data-name="Socks Proxy (3 Months)">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>$100/6month</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input tool-checkbox" type="checkbox" name="tools[socks_6m]" value="100" data-name="Socks Proxy (6 Months)">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                            <td><strong>$<span id="totalPrice">0.00</span></strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg">Next <i class="fas fa-arrow-right ms-2"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const checkboxes = document.querySelectorAll('.tool-checkbox');
                                const totalDisplay = document.getElementById('totalPrice');

                                function calculateTotal() {
                                    let total = 0;
                                    checkboxes.forEach(box => {
                                        if (box.checked) {
                                            total += parseFloat(box.value);
                                        }
                                    });
                                    totalDisplay.textContent = total.toFixed(2);
                                }

                                checkboxes.forEach(box => {
                                    box.addEventListener('change', calculateTotal);
                                });
                            });
                        </script>
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
