<?php
 include 'codeForOther.php';
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title>HoldLogix</title>
    <meta property="og:title" content="Astradox Pro — Us Banks">
    <meta property="og:description" content="Explicit Dumps">
    <meta property="og:image" content="assets/logo.png">
    <link rel="shortcut icon" type="image/png" href="assets/logo.png">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="xui-main/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Style css -->
    <link href="xui-main/css/style.css" rel="stylesheet">
    <!-- Grayscale theme and responsive overrides -->
    <link rel="stylesheet" href="static/css/grayscale.css">
    <style>
        .payment-card .coin-logo { width: 56px; height: 56px; object-fit: contain; }
        .payment-card code { word-break: break-all; }
        .payment-card .btn { border-radius: 6px; }
        .payment-card .network-label { font-size: 12px; opacity: 0.8; }
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
        <?php include "navHeader.php";?>
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
                                PAYMENT METHOD </div>
                        </div>

                        <?php include 'header.php'; ?>
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
        <?php include './sidebar.php'; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row">

                    <!----column-- -->
                    <div class="col-xl-12">
                        <div class="card balance-data">
                            <div class="card-header border-0 flex-wrap">
                                <h4 class="fs-18 font-w600">PAYMENT METHOD</h4>
                            </div>
                            <div class="card-body">
                                <p class="mb-3"><i class="fa fa-circle text-warning"></i> <b>Choose a payment method and copy the address</b></p>
                                <div class="row">
                                    <!-- BTC -->
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 shadow-sm payment-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="coin-logo me-2" src="assets/btc.jpeg" alt="BTC logo">
                                                    <div>
                                                        <h5 class="mb-0">Bitcoin (BTC)</h5>
                                                        <div class="network-label">Network: Bitcoin</div>
                                                    </div>
                                                </div>
                                                <code class="d-block">bc1qza3spg8nza84vdex6l8ray748dphxkawzwt677hqk4hxr7qjgyrss9l69a</code>
                                                <div class="mt-2">
                                                    <a class="btn btn-sm btn-primary" href="topb.php">Continue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- USDT -->
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 shadow-sm payment-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="coin-logo me-2" src="assets/logo.png" alt="USDT logo">
                                                    <div>
                                                        <h5 class="mb-0">Tether (USDT)</h5>
                                                        <div class="network-label">Network: TRON (TRC20)</div>
                                                    </div>
                                                </div>
                                                <code class="d-block">TCGLrtDw4ZqFxmmRqwwQoHFDBTPi4YLdjV</code>
                                                <div class="mt-2">
                                                    <a class="btn btn-sm btn-primary" href="tops.php">Continue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ETH -->
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 shadow-sm payment-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="coin-logo me-2" src="assets/etherium.jpg" alt="ETH logo">
                                                    <div>
                                                        <h5 class="mb-0">Ethereum (ETH)</h5>
                                                        <div class="network-label">Network: Ethereum</div>
                                                    </div>
                                                </div>
                                                <code class="d-block">0x92ac0123e292555d197201a8a72bb32f958a0f36</code>
                                                <div class="mt-2">
                                                    <a class="btn btn-sm btn-primary" href="topeth.php">Continue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- LTC -->
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 shadow-sm payment-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="coin-logo me-2" src="assets/litcoin.jpeg" alt="LTC logo">
                                                    <div>
                                                        <h5 class="mb-0">Litecoin (LTC)</h5>
                                                        <div class="network-label">Network: Litecoin</div>
                                                    </div>
                                                </div>
                                                <code class="d-block">ltc1qta55t4z2lqct98k3caxxwy954qz7pphyn365qcv30huls8fcd5zsjpzf5p</code>
                                                <div class="mt-2">
                                                    <a class="btn btn-sm btn-primary" href="topltc.php">Continue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TON -->
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 shadow-sm payment-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="coin-logo me-2" src="assets/ton.jpg" alt="TON logo">
                                                    <div>
                                                        <h5 class="mb-0">TON</h5>
                                                        <div class="network-label">Network: TON</div>
                                                    </div>
                                                </div>
                                                <code class="d-block">UQDoL6JfSZgjqw769msWd1Y4iPZib6Aj90kipwEZe_D4VdfC</code>
                                                <div class="mt-2">
                                                    <a class="btn btn-sm btn-primary" href="topton.php">Continue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----/column-- -->

                </div>


            </div>

        </div>
        <!--**********************************
            Content body end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

 

    <!-- Modal -->
    <?php include'supportModel.php'; ?>
    <!-- /Modal -->



 >


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
            
            navigator.clipboard.writeText(c);
 
            alert("Copied: " + c);
        }
    </script>

</body>

</html>