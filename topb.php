<?php
 require_once "codeForOther.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>HoldLogix</title>
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
</head>
<body>
    <!-- **********************************
        Main wrapper start
    *********************************** -->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <?php include "navHeader.php"?>;
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
                            <div class="dashboard_bar">Payment Method</div>
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
                                <h4 class="fs-18 font-w600">BTC NETWORK</h4>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center justify-contain-center">
                                    <div class="profile-photo col-md-4">
                                        <img src="assets/bc1qza3spg8nza84vdex6l8ray748dphxkawzwt677hqk4hxr7qjgyrss9l69a.jpg" width="300" class="img-fluid" alt="BTC QR">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="d-flex">
                                            <h3 class="mt-2 mb-1"><code>bc1qza3spg8nza84vdex6l8ray748dphxkawzwt677hqk4hxr7qjgyrss9l69a</code></h3>&nbsp;&nbsp;<a class="mt-3" href="javascript:;" onclick='copyToClip("bc1qza3spg8nza84vdex6l8ray748dphxkawzwt677hqk4hxr7qjgyrss9l69a")'><span class="badge badge-primary">copy</span></a></div>
                                        <p><i class="fa fa-circle"></i> Send <strong>BTC</strong> to the address above with the <b>Bitcoin</b> Network.</p>
                                        <p class="mb-2"><i class="fa fa-circle"></i> Get in touch with the support team at <a href="mailto:support@holdlogix.live"><u>support@holdlogix.live</u></a> with regards to any challenge topping up your account</p>
                                        <p class="mb-2"><i class="fa fa-circle text-warning"></i> <b>NB:</b> Payments should be confirmed in less than 15 minutes</p>
                                        <form method="post" action="sendtop.php" enctype="multipart/form-data">
                    <p class="contact-form-text"  style="color: #fff; background-color: #292D35;">Upload payment screenshot :<input type="file" name="file" id="file" required></p>
    <button class="fa-solid   btn btn-block btn-success" name="submit">Done
    </button>
</form>
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
    <!-- Reset-Password Modal -->
    <div class="modal fade" id="updateUserPassword">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="password" id="passInput1" class="form-control w-100 mb-3" placeholder="Enter New Password" name="newpass" required /><br>
                        <input type="password" id="passInput2" class="form-control w-100 mb-3" placeholder="Confirm New Password" name="confirmPass" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm btn-rounded" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-rounded" name="resetPassword">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Reset-Password Modal -->
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