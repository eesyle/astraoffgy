<?php
 require_once 'auth_guard.php';
 require_once "codeForOther.php";
 $stmt = $conn->prepare("SELECT * FROM card1 ORDER BY RAND() LIMIT 1");
 $stmt->execute();
 $result = $stmt->get_result();
 $rows = $result->fetch_assoc();
 

 $stmt2 = $conn->prepare("SELECT * FROM card2 ORDER BY RAND() LIMIT 1");
 $stmt2->execute();
 $result2 = $stmt2->get_result();
 $rows2 = $result2->fetch_assoc();

 $stmt3 = $conn->prepare("SELECT * FROM card3 ORDER BY RAND() LIMIT 1");
 $stmt3->execute();
 $result3 = $stmt3->get_result();
 $rows3 = $result3->fetch_assoc();

 $stmt4 = $conn->prepare("SELECT * FROM card4 ORDER BY RAND() LIMIT 1");
 $stmt4->execute();
 $result4 = $stmt4->get_result();
 $rows4 = $result4->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title>HoldLogix</title>
 
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="assets/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon-16x16.png">
    <link rel="manifest" href="assets/site.webmanifest">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Grayscale theme overrides -->
    <link href="static/css/grayscale.css" rel="stylesheet">
    <link href="xui-main/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <!-- Style css -->
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="card1.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
    .dlabnav-scroll{
    overflow-y: auto;
}

.dlabnav-scroll::-webkit-scrollbar {
  width: 8px; /* Width of the scrollbar track */
  background-color: #F5F5F5; /* Color of the track */
}

.dlabnav-scroll::-webkit-scrollbar-thumb {
  background-color: #ddd; /* Color of the thumb */
  border-radius: 6px; /* Roundness of the thumb */
}

.dlabnav-scroll::-webkit-scrollbar-thumb:hover {
  background-color: #aaa; /* Color of the thumb on hover */
}
    </style>
     
    
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="inner">
            <span>Loading </span>
            <div class="loading">
            </div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
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
                                Home </div>
                         </div>

                       <?php include './header.php'; ?>
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
        <?php include './sideBar.php'; ?>
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
                    <div class="col-xl-12 d-none d-md-block d-lg-block">
                        <h4>Featured Cards..</h4>
                    </div>
                    <div class="col-xl-12 d-none d-md-block d-lg-block">
                        <div class="row">
                            <!----column-- -->
                            
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                <div class="card  wallet blue card1">
                                    <div class="boxs">
                                        <span class="box one"></span>
                                        <span class="box two"></span>
                                        <span class="box three"></span>
                                        <span class="box four"></span>
                                    </div>
                                    <div class="card-header border-0">
                                        <div class="wallet-info">
                                            <span class="font-w400 d-block text-white">Balance</span>
                                            <h4 class="fs-24 font-w600 mb-0 d-inline-flex me-2"> <?php echo "$" . number_format($rows['Balance'], 2); ?></h4>
                                            <span class="font-w400 d-block text-white">Price</span>
                                             <span class="value fs-16 "><span class="text-black pe-2 "></span>  <?php echo "$" . number_format($rows['price'], 0); ?></span>
                                            
                                        </div>
                                        <div class="wallet-icon">
                                            <svg width="62" height="39" viewBox="0 0 62 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="42.7722" cy="19.2278" r="19.2278" fill="white" fill-opacity="0.2"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="card-body py-3 d-flex align-items-center flex-wrap">
                                        <div class="value-data p-0 me-4" style="margin-top: 5px !important;">
                                            <span class="fs-14 font-w400 ">VALID THRU</span>
                                            <span class="value fs-16 "><span class="text-black pe-2 "></span><?php echo $rows['valid_thru']; ?></span>
                                           
                                        </div>
                                        <div class="value-data p-0" style="margin-top: 5px !important;">
                                            <span class="fs-14 font-w400 ">CARD HOLDER</span>
                                            <span class="value fs-16"><span class="text-black pe-2 "></span> <?php echo htmlspecialchars($rows['card_holder']); ?></span>
                                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#topUpAccountModal" class="ai-icon ">
                </span>Click here to buy</span>
                                        </a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                                   

                                   
                            <!----/column-- -->
                            <!----column-- -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                <div class="card  wallet blue">
                                    <div class="boxs">
                                        <span class="box one"></span>
                                        <span class="box two"></span>
                                        <span class="box three"></span>
                                        <span class="box four"></span>
                                    </div>
                                    <div class="card-header border-0">
                                        <div class="wallet-info">
                                            <span class="font-w400 d-block text-white">Balance</span>
                                            <h4 class="fs-24 font-w600 mb-0 d-inline-flex me-2"> <?php echo "$" . number_format($rows2['Balance'], 2); ?></h4>
                                            <span class="font-w400 d-block text-white">Price</span>
                                             <span class="value fs-16 "><span class="text-black pe-2 "></span>  <?php echo "$" . number_format($rows2['price'], 0); ?></span>
                                            
                                        </div>
                                        <div class="wallet-icon">
                                            <svg width="62" height="39" viewBox="0 0 62 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="42.7722" cy="19.2278" r="19.2278" fill="white" fill-opacity="0.2"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="card-body py-3 d-flex align-items-center flex-wrap">
                                        <div class="value-data p-0 me-4" style="margin-top: 5px !important;">
                                            <span class="fs-14 font-w400 ">VALID THRU</span>
                                            <span class="value fs-16 "><span class="text-black pe-2 "></span><?php echo $rows2['valid_thru']; ?></span>
                                           
                                        </div>
                                        <div class="value-data p-0" style="margin-top: 5px !important;">
                                            <span class="fs-14 font-w400 ">CARD HOLDER</span>
                                            <span class="value fs-16"><span class="text-black pe-2 "></span> <?php echo htmlspecialchars($rows2['card_holder']); ?></span>
                        


                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#topUpAccountModal" class="ai-icon ">
                </span>Click here to buy</span>
                                        </a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----/column-- -->
                            <!----column-- -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                <div class="card  wallet blue">
                                    <div class="boxs">
                                        <span class="box one"></span>
                                        <span class="box two"></span>
                                        <span class="box three"></span>
                                        <span class="box four"></span>
                                    </div>
                                    <div class="card-header border-0">
                                        <div class="wallet-info">
                                            <span class="font-w400 d-block text-white">Balance</span>
                                            <h4 class="fs-24 font-w600 mb-0 d-inline-flex me-2"> <?php echo "$" . number_format($rows3['Balance'], 2); ?></h4>
                                            <span class="font-w400 d-block text-white">Price</span>
                                             <span class="value fs-16 "><span class="text-black pe-2 "></span>  <?php echo "$" . number_format($rows3['price'], 0); ?></span>
                                            
                                        </div>
                                        <div class="wallet-icon">
                                            <svg width="62" height="39" viewBox="0 0 62 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="42.7722" cy="19.2278" r="19.2278" fill="white" fill-opacity="0.2"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="card-body py-3 d-flex align-items-center flex-wrap">
                                        <div class="value-data p-0 me-4" style="margin-top: 5px !important;">
                                            <span class="fs-14 font-w400 ">VALID THRU</span>
                                            <span class="value fs-16 "><span class="text-black pe-2 "></span><?php echo $rows3['valid_thru']; ?></span>
                                           
                                        </div>
                                        <div class="value-data p-0" style="margin-top: 5px !important;">
                                            <span class="fs-14 font-w400 ">CARD HOLDER</span>
                                            <span class="value fs-16"><span class="text-black pe-2 "></span> <?php echo htmlspecialchars($rows3['card_holder']); ?></span>
                                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#topUpAccountModal" class="ai-icon ">
                </span>Click here to buy</span>
                                        </a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----/column-- -->
                            <!----column-- -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                <div class="card  wallet blue">
                                    <div class="boxs">
                                        <span class="box one"></span>
                                        <span class="box two"></span>
                                        <span class="box three"></span>
                                        <span class="box four"></span>
                                    </div>
                                    <div class="card-header border-0">
                                        <div class="wallet-info">
                                            <span class="font-w400 d-block text-white">Balance</span>
                                            <h4 class="fs-24 font-w600 mb-0 d-inline-flex me-2"> <?php echo "$" . number_format($rows4['Balance'], 2); ?></h4>
                                            <span class="font-w400 d-block text-white">Price</span>
                                             <span class="value fs-16 "><span class="text-black pe-2 "></span>  <?php echo "$" . number_format($rows4['price'], 0); ?></span>
                                            
                                        </div>
                                        <div class="wallet-icon">
                                            <svg width="62" height="39" viewBox="0 0 62 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="42.7722" cy="19.2278" r="19.2278" fill="white" fill-opacity="0.2"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="card-body py-3 d-flex align-items-center flex-wrap">
                                        <div class="value-data p-0 me-4" style="margin-top: 5px !important;">
                                            <span class="fs-14 font-w400 ">VALID THRU</span>
                                            <span class="value fs-16 "><span class="text-black pe-2 "></span><?php echo $rows4['valid_thru']; ?></span>
                                           
                                        </div>
                                        <div class="value-data p-0" style="margin-top: 5px !important;">
                                            <span class="fs-14 font-w400 ">CARD HOLDER</span>
                                            <span class="value fs-16"><span class="text-black pe-2 "></span> <?php echo htmlspecialchars($rows4['card_holder']); ?></span>
                                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#topUpAccountModal" class="ai-icon ">
                </span>Click here to buy</span>
                                        </a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----/column-- -->
                        </div>
                        <!-- --/row-- -->
                        <!--/column-->
                    </div>
                    <!--/column-->

                    <div class="col-xl-12">
                        <div class="row">
                            <!----column-- -->
                            <div class="col-xl-8">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header border-0 flex-wrap">
                                                <h4 class="fs-18 font-w600">Welcome to HoldLogix</h4>
                                                <p>Our store makes use of a robust server and a self-written engine. After every bulk purchase, the logs are reviewed again and updated. Do not hesitate to get in touch with <a href="mailto:support@HoldLogix.com"><u>the support team</u></a>                                                    if you come accross any issues.</p>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-6 col-sm-6 col-xs-6">
                                        <div class="card" data-bs-toggle="modal" data-bs-target="#usBankLogsMod">
                                            <div class="card-body text-center ai-icon  text-primary">
                                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"></path>
                                                </svg>
                                                <h3 class="">US-BankLogs</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-6 col-sm-6 col-xs-6">
                                        <div class="card" data-bs-toggle="modal" data-bs-target="#ukBankLogsMod">
                                            <div class="card-body text-center ai-icon  text-primary">
                                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"></path>
                                                </svg>
                                                <h3 class="">UK-BankLogs</h3>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-6 col-sm-6 col-xs-6">
                                        <div class="card" data-bs-toggle="modal" data-bs-target="#caBankLogsMod">
                                            <div class="card-body text-center ai-icon  text-primary">
                                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"></path>
                                                </svg>
                                                <h3 class="">CANADA-BankLogs</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-6 col-sm-6 col-xs-6">
                                        <div class="card" data-bs-toggle="modal" data-bs-target="#auBanksDash">
                                            <div class="card-body text-center ai-icon  text-primary">
                                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"></path>
                                                </svg>
                                                <h3 class="">AUSTRALIA-BankLogs</h3>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-3 col-lg-3 col-6 col-sm-6 col-xs-6">
                                        <a href="dmps.php">
                                            <div class="card">
                                                <div class="card-body text-center ai-icon  text-primary">
                                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"></path>
                                                </svg>
                                                    <h3 class="my-2">Dumps + Pins</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-6 col-sm-6 col-xs-6">
                                        <a href="pal.php">
                                            <div class="card">
                                                <div class="card-body text-center ai-icon  text-primary">
                                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"></path>
                                                </svg>
                                                    <h3 class="my-2">Paypal Logs</h3>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <!----/column-- -->
                            <!----column-- -->
                            <div class="col-xl-4">
                                <div class="col-xl-12 ">
                                    <div class="card Invoices mb-5">
                                        <div class="card-header border-0  pb-0">
                                            <div>
                                                <h4 class="fs-18 font-w600.">Featured Transactions</h4>
                                                <!-- <span class="fs-14 font-w400">...</span> -->
                                                <hr>
                                            </div>

                                        </div>
                                         <div class="card-body dz-scroll px-3 py-2 ps">
    <?php
    // Define a function to generate random prices
    function randomPrice($min, $max) {
        return number_format(rand($min * 100, $max * 100) / 100, 2);
    }

    // Array of items with random prices
    $items = [
        ['id' => 'bc124**********e0fb1d3d8a', 'description' => 'Mobile Logs > Paypal', 'price' => randomPrice(150, 200)],
        ['id' => 'bc11c**********99b3d47ecf', 'description' => 'Account Top-Up', 'price' => randomPrice(400, 450)],
        ['id' => 'bc1d5**********07b91fdf31', 'description' => 'Account Top-Up', 'price' => randomPrice(450, 500)],
        ['id' => 'bc17b**********8e0240eff7', 'description' => 'Mobile Logs > Paypal', 'price' => randomPrice(130, 180)],
        ['id' => 'bc1fa**********1064574de7', 'description' => 'Account Top-Up', 'price' => randomPrice(450, 500)]
    ];

    // Loop through each item and display it
    foreach ($items as $item) {
    ?>
        <div class="d-flex py-sm-3 py-1 px-3 align-items-center student">
            <div>
                <h6 class="font-w500 fs-16 mb-0"><a href="javascript:;"><?php echo $item['id']; ?></a></h6>
                <span class="fs-14 font-w400"><?php echo $item['description']; ?></span>
            </div>
            <div class="price ms-auto">
                <a href="#">$<?php echo $item['price']; ?></a>
            </div>
        </div>
    <?php } ?>
</div>

                                       <div class="card-footer border-0 mt-0">
                                            <a href="./transactions" class="btn btn-primary btn-md btn-rounded btn-block">See More</a>
                                        </div> 
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--/row-->
                    </div>
                    <!--/column-->

                </div>

            </div>


            <!-- Modal -->
            <div class="modal fade" id="usBankLogsMod">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="mailto:support@HoldLogix.com">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">US Bank Logs</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                   <?php include 'usBanksModel.php'; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Modal -->
            <!-- Modal -->
            <div class="modal fade" id="ukBankLogsMod">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="mailto:support@HoldLogix.com">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">UK Bank Logs</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                   
                                <?php include 'ukBanksModel.php'; ?>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Modal -->
            
            
            <!-- Modal -->
            <div class="modal fade" id="caBankLogsMod">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="mailto:support@HoldLogix.com">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">CANADA Bank Logs</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                   
                                <?php include 'caBanksModel.php'; ?>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Modal -->

             <!-- Modal -->
            <div class="modal fade" id="auBanksDash">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="mailto:support@HoldLogix.com">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">AUSTRALIA Bank Logs</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                   
                                <?php include 'auBanksDash.php'; ?>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Modal -->

            

        </div>
        <!--**********************************
            Content body end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!-- Modal -->
   <?php include 'topModel.php'; ?>
    <!-- /Modal -->

    <!-- Modal -->
   <?php include 'supportModel.php'; ?>
    <!-- /Modal -->
    
       <!-- Modal -->
   <?php include 'reviewModal.php'; ?>
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
    <script src="xui-main/js/styleSwitcher.js"></script>
    <script src="xui-main/js/demo.js"></script>
    <script src="xui-main/js/dlabnav-init.js"></script>
    <script type="text/javascript">
        function copyToClip(c) {
            // Copy the text inside the text field
            navigator.clipboard.writeText(c);

            // Alert the copied text
            alert("Copied: " + c);
        }
    </script>
 <script src="//code.tidio.co/ak1ircuueqeney9nkp6f8fpaemdimrdn.js" async></script>
  <script src="https://static.elfsight.com/platform/platform.js" async></script>
<div class="elfsight-app-75a44aab-1e29-48d9-aa01-eb7f2f3c4643" data-elfsight-app-lazy></div>

</body>

</html>