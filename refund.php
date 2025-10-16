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
    <link href="static/css/grayscale.css" rel="stylesheet">
    <link rel="stylesheet" href="styl.css">
    <style>
        /* Futuristic, modern styling for refund form without changing form flow */
        .refund-wrapper{background:radial-gradient(circle at 10% 10%,#0f172a,#1e293b 40%,#0b1020);min-height:100vh}
        .refund-card{background:rgba(30,41,59,.75);backdrop-filter:blur(8px);border-radius:16px;border:1px solid rgba(148,163,184,.2);box-shadow:0 12px 30px rgba(0,0,0,.35)}
        .refund-title{display:flex;align-items:center;gap:12px;color:#e2e8f0}
        .refund-title i{color:#60a5fa}
        .contact-form-text{background:#0b1220;color:#cbd5e1;border:1px solid rgba(148,163,184,.25);border-radius:10px;padding:12px 14px}
        .contact-form-text:focus{outline:none;border-color:#60a5fa;box-shadow:0 0 0 2px rgba(96,165,250,.25)}
        .contact-form-btn{background:linear-gradient(135deg,#06b6d4,#3b82f6);border:none;border-radius:12px;color:#fff;padding:12px 16px;font-weight:600;transition:transform .15s ease,box-shadow .15s ease}
        .contact-form-btn:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(59,130,246,.4)}
        .contact-hint{color:#94a3b8;font-size:.9rem;margin-top:6px}
        .other-reason{display:none}
        .label-muted{color:#94a3b8}
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
                                REFUND </div>
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
                                <h4 class="fs-18 font-w600 refund-title"><i class="bi bi-shield-check"></i> REQUEST A REFUND</h4>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center justify-contain-center refund-wrapper p-3">
                                    
                                    <div class="col-md-7">
                                        <div class="refund-card p-4 w-100">
    
                                       
                                        <div class="contact-section">
  
    <form   class="contact-form" action="requestCode.php" method="post" enctype="multipart/form-data">
          <input type="text"  class="contact-form-text" id="fullname" name="fullname"  placeholder="Full Name" value="<?=$username?>" required>
            <input type="email" class="contact-form-text"  id="email" name="email" placeholder="Email address" value="<?=$email?>" required>     
            <input type="text" class="contact-form-text" id="btcId" name="btcId" placeholder="Your BTC or USDT address" required>
 
        <label class="label-muted">Upload payment screenshot</label>
        <p class="contact-form-text" style="color:#cbd5e1;background-color:#0b1220;border:1px solid rgba(148,163,184,.25);border-radius:10px;">
            <input type="file" name="file" id="file" required style="color:#94a3b8;">
        </p>
         <select class="contact-form-text" id="category" name="category" required>
        <option value="" disabled selected>What is the reason for refund? click here to Choose from the dropdown menu</option>
        <option value="incorrect">The log info not correct</option>
        <option value="wrong">I did not get the log info</option>
        <option value="cancel">I need to cancel the the transaction</option>
        <option value="notReceived">I recieved the wrong log info</option>
        <option value="delay">Delay in receiving the log info</option>
        <option value="other">Other</option>
    </select>
    <div id="other-reason-wrap" class="other-reason">
        <label for="other_reason" class="label-muted">Please describe your reason</label>
        <textarea class="contact-form-text" id="other_reason" name="other_reason" rows="3" placeholder="Type your reason..."></textarea>
        <div class="contact-hint">Be specific so we can process your request faster.</div>
    </div>
    <button  class="contact-form-btn" type="submit" name ="submit">Submit Request</button>
    </form>
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
        // Toggle Other reason textarea visibility and required state
        (function(){
            var categoryEl = document.getElementById('category');
            var otherWrap = document.getElementById('other-reason-wrap');
            var otherInput = document.getElementById('other_reason');
            function toggleOther(){
                if (!categoryEl) return;
                var show = categoryEl.value === 'other';
                if (otherWrap) otherWrap.style.display = show ? 'block' : 'none';
                if (otherInput) {
                    if (show) {
                        otherInput.setAttribute('required','required');
                    } else {
                        otherInput.removeAttribute('required');
                        otherInput.value = '';
                    }
                }
            }
            if (categoryEl) {
                categoryEl.addEventListener('change', toggleOther);
                // Initialize on load
                toggleOther();
            }
        })();
    </script>

</body>

</html>