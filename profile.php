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

    <title>Alteryx Pro  </title>
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
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">
    <style>
        .dlabnav-scroll {
            max-height: 100vh;
            overflow-y: auto;
        }
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
        <?php include "navHeader.php"?>;
        <!--**********************************
            Nav header end
        ***********************************-->
            <?php include './navHeader.php'; ?>

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header" style="background: #2d2362; opacity: .9;">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                PROFILE </div>
                        </div>

                        <?php include './header.php' ?>
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
         <?php include './sidebar.php';?>
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

                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-sm-12">
                                <div class="card overflow-hidden">
                                    <div class="text-center p-3" style="background-image: url('./xui-main/images/big/img1.jpg');">
                                        <div class="profile-photo">
                                            <img src="uploads/default-user.png" width="100" class="img-fluid rounded-circle" alt="">
                                        </div>
                                        <h3 class="mt-3 mb-1 text-white"><?php echo $username ?> </h3>
                                        <p class="text-white mb-0">524afe8df6...33cc0f0640</p>
                                        <a class="btn btn-light btn-xxs btn-rounded mt-2" href="javascript:void();" data-bs-toggle="modal" data-bs-target="#updateUserPassword">Reset Password</a>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Email:</span><strong class=""> <?php echo $email ?></strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Phone:</span><strong class="">N/A</strong></li>
                                    </ul>
                                    <div class="card-body border-0 mt-0">

                                        <div class="alert alert-info alert-dismissible fade show">
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                            <strong>Protection!</strong><br>We guarantee the security of our users by concealing their IP addresses to avoid being tracked down.
                                        </div>
                                    </div>
                                    <div class="card-footer pt-0 pb-0 text-center">
                                        <div class="row">
                                            <div class="col-6 pt-3 pb-3 border-end">
                                                <h3 class="mb-1">0</h3><span>Orders</span>
                                            </div>
                                            <div class="col-6 pt-3 pb-3">
                                                <h3 class="mb-1">0</h3><span>Transactions</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----column-- -->
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header border-0 flex-wrap">
                                        <h4 class="fs-18 font-w600">Recent Initialized Transaction Queue</h4>
                                        <!-- <p>Having any issue? Contact the <a href="mailto:support@astradox.pro"><u>support team</u></a>.</p> -->
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive recentOrderTable">
                                            <table class="table verticle-middle table-responsive-md">
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----/column-- -->

                        </div>
                        <!--/row-->
                    </div>
                    <!--/column-->

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
   <?php include './topModel.php'; ?>
    <!-- /Modal -->

    <!-- Modal -->
    <?php include './supportModel.php'; ?>
    <!-- /Modal -->



    <!-- Reset-Password Modal -->
    <?php include './resetModel.php'; ?>
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
            // Copy the text inside the text field
            navigator.clipboard.writeText(c);

            // Alert the copied text
            alert("Copied: " + c);
        }
    </script>

</body>

</html>