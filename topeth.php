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
    <meta property="og:image" content="assets/logo.png">
    <link rel="shortcut icon" type="image/png" href="assets/logo.png">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="xui-main/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/grayscale.css">
</head>
<body>
    <div id="main-wrapper">
        <?php include "navHeader.php";?>
        <div class="header" style="background: #2d2362; opacity: .9;">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar" style="white-space: nowrap;">Payment Method</div>
                        </div>
                        <?php include 'header.php'; ?>
                    </div>
                </nav>
            </div>
        </div>
        <?php include './sidebar.php'; ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card balance-data">
                            <div class="card-header border-0 flex-wrap">
                                <h4 class="fs-18 font-w600">ETH NETWORK</h4>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center justify-contain-center">
                                    <div class="profile-photo col-md-4">
                                        <img src="assets/0x92ac0123e292555d197201a8a72bb32f958a0f36.jpg" width="300" class="img-fluid" alt="ETH QR">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="d-flex">
                                            <h3 class="mt-2 mb-1"><code>0x92ac0123e292555d197201a8a72bb32f958a0f36</code></h3>&nbsp;&nbsp;<a class="mt-3" href="javascript:;" onclick='copyToClip("0x92ac0123e292555d197201a8a72bb32f958a0f36")'><span class="badge badge-primary">copy</span></a></div>
                                        <p><i class="fa fa-circle"></i> Send <strong>ETH</strong> to the address above with the <b>Ethereum</b> Network.</p>
                                        <p class="mb-2"><i class="fa fa-circle"></i> Get in touch with the support team at <a href="mailto:support@holdlogix.live"><u>support@holdlogix.live</u></a> with regards to any challenge topping up your account</p>
                                        <p class="mb-2"><i class="fa fa-circle text-warning"></i> <b>NB:</b> Payments should be confirmed in less than 15 minutes</p>
                                        <form method="post" action="sendtop.php" enctype="multipart/form-data">
                                            <p class="contact-form-text"  style="color: #fff; background-color: #292D35;">Upload payment screenshot :<input type="file" name="file" id="file" required></p>
                                            <button class="fa-solid   btn btn-block btn-success" name="submit">Done</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include'supportModel.php'; ?>
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
<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #292D35; color: #fff;">
            <div class="modal-body text-center p-5">
                <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="sr-only">Loading...</span>
                </div>
                <h5 class="mb-0">Processing payment and sending email...</h5>
                <p class="text-muted mt-2">Please do not close this window.</p>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#paymentForm').on('submit', function() {
        $('#loadingModal').modal('show');
        toastr.info('Sending payment confirmation...', 'Processing', {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: false
        });
    });
});
</script>
</body>
</html>