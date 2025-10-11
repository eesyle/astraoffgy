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
        <div class="dlabnav">
             
                 <div class="dlabnav-scroll">

                <ul class="metismenu" id="menu">
                    <li class="mm-active">
                        <a href="dash" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="IconlyHome"><g id="Home">
                                <path id="Home_2" d="M9.13478 20.7733V17.7156C9.13478 16.9351 9.77217 16.3023 10.5584 16.3023H13.4326C13.8102 16.3023 14.1723 16.4512 14.4393 16.7163C14.7063 16.9813 14.8563 17.3408 14.8563 17.7156V20.7733C14.8539 21.0978 14.9821 21.4099 15.2124 21.6402C15.4427 21.8705 15.7561 22 16.0829 22H18.0438C18.9596 22.0023 19.8388 21.6428 20.4872 21.0008C21.1356 20.3588 21.5 19.487 21.5 18.5778V9.86686C21.5 9.13246 21.1721 8.43584 20.6046 7.96467L13.934 2.67587C12.7737 1.74856 11.1111 1.7785 9.98539 2.74698L3.46701 7.96467C2.87274 8.42195 2.51755 9.12064 2.5 9.86686V18.5689C2.5 20.4639 4.04738 22 5.95617 22H7.87229C8.55123 22 9.103 21.4562 9.10792 20.7822L9.13478 20.7733Z" fill="#130F26"/>
                                </g></g>
                            </svg>
                            </div>
                            <span class="nav-text">Home</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"/>
                            </svg>
                            </div>
                            <span class="nav-text">Bank Logs</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">USA BANKLOGS</a>
                                <ul aria-expanded="false">
                                  <?php include 'usBanksDash.php'; ?>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">UK BANKLOGS</a>
                                <ul aria-expanded="false">
                                   <?php include 'ukBanksDash.php'; ?>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">CANADA BANKLOGS</a>
                                <ul aria-expanded="false">
                                   <?php include 'caBanksDash.php'; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="" href="./dmps" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"/>
                            </svg>
                            </div>
                            <span class="nav-text">Dumps + Pins</span>
                        </a>
                    </li>
                    <li>
                        <a class="" href="./pal" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"/>
                            </svg>
                            </div>
                            <span class="nav-text">Paypal Logs</span>
                        </a>
                    </li>

                    <li>
                        <a class="" href="./orders" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="IconlyDocument">
                                <g id="Document">
                                <path id="Document_2" fill-rule="evenodd" clip-rule="evenodd" d="M7.81 2H16.191C19.28 2 21 3.78 21 6.83V17.16C21 20.26 19.28 22 16.191 22H7.81C4.77 22 3 20.26 3 17.16V6.83C3 3.78 4.77 2 7.81 2ZM8.08 6.66V6.65H11.069C11.5 6.65 11.85 7 11.85 7.429C11.85 7.87 11.5 8.22 11.069 8.22H8.08C7.649 8.22 7.3 7.87 7.3 7.44C7.3 7.01 7.649 6.66 8.08 6.66ZM8.08 12.74H15.92C16.35 12.74 16.7 12.39 16.7 11.96C16.7 11.53 16.35 11.179 15.92 11.179H8.08C7.649 11.179 7.3 11.53 7.3 11.96C7.3 12.39 7.649 12.74 8.08 12.74ZM8.08 17.31H15.92C16.319 17.27 16.62 16.929 16.62 16.53C16.62 16.12 16.319 15.78 15.92 15.74H8.08C7.78 15.71 7.49 15.85 7.33 16.11C7.17 16.36 7.17 16.69 7.33 16.95C7.49 17.2 7.78 17.35 8.08 17.31Z" fill="#130F26"/>
                                </g>
                                </g>
                            </svg>
                            </div>
                            <span class="nav-text">Orders</span>
                        </a>
                    </li>
                    
                 

                    <li>
                        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.34933 14.8577C5.38553 14.8577 2 15.47 2 17.9174C2 20.3666 5.364 21 9.34933 21C13.3131 21 16.6987 20.3877 16.6987 17.9404C16.6987 15.4911 13.3347 14.8577 9.34933 14.8577Z" fill="#B9A8FF"/>
                                <path opacity="0.4" d="M9.34935 12.5248C12.049 12.5248 14.2124 10.4062 14.2124 7.76241C14.2124 5.11865 12.049 3 9.34935 3C6.65072 3 4.48633 5.11865 4.48633 7.76241C4.48633 10.4062 6.65072 12.5248 9.34935 12.5248Z" fill="#763ed0"/>
                                <path opacity="0.4" d="M16.1734 7.84875C16.1734 9.19507 15.7605 10.4513 15.0364 11.4948C14.9611 11.6021 15.0276 11.7468 15.1587 11.7698C15.3407 11.7995 15.5276 11.8177 15.7184 11.8216C17.6167 11.8704 19.3202 10.6736 19.7908 8.87118C20.4885 6.19676 18.4415 3.79543 15.8339 3.79543C15.5511 3.79543 15.2801 3.82418 15.0159 3.87688C14.9797 3.88454 14.9405 3.90179 14.921 3.93246C14.8955 3.97174 14.9141 4.02253 14.9395 4.05607C15.7233 5.13216 16.1734 6.44207 16.1734 7.84875Z" fill="#763ed0"/>
                                <path d="M21.7791 15.1693C21.4317 14.444 20.5932 13.9466 19.3172 13.7023C18.7155 13.5586 17.0853 13.3545 15.5697 13.3832C15.5472 13.3861 15.5344 13.4014 15.5325 13.411C15.5295 13.4263 15.5364 13.4493 15.5658 13.4656C16.2663 13.8048 18.9738 15.2805 18.6333 18.3928C18.6186 18.5289 18.7292 18.6439 18.8671 18.6247C19.5335 18.5318 21.2478 18.1705 21.7791 17.0475C22.0736 16.4534 22.0736 15.7635 21.7791 15.1693Z" fill="#B9A8FF"/>
                                </svg>
                            </div>
                            <span class="nav-text">Account</span>
                        </a>
                        <ul aria-expanded="false">
                            <li> <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#topUpAccountModal" class="ai-icon ">
                                            Top Up 
                                        </a></li>
                            <li><a href="./profile">Profile</a></li>
                            <li><a href="./refund">Refund</a></li>
                            <li><a class="text-danger" href="login">Logout</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="IconlyFilter">
                                <g id="Filter">
                                <path id="Filter_2" fill-rule="evenodd" clip-rule="evenodd" d="M8.87774 6.37856C8.87774 8.24523 7.33886 9.75821 5.43887 9.75821C3.53999 9.75821 2 8.24523 2 6.37856C2 4.51298 3.53999 3 5.43887 3C7.33886 3 8.87774 4.51298 8.87774 6.37856ZM20.4933 4.89833C21.3244 4.89833 22 5.56203 22 6.37856C22 7.19618 21.3244 7.85989 20.4933 7.85989H13.9178C13.0856 7.85989 12.4101 7.19618 12.4101 6.37856C12.4101 5.56203 13.0856 4.89833 13.9178 4.89833H20.4933ZM3.50777 15.958H10.0833C10.9155 15.958 11.5911 16.6217 11.5911 17.4393C11.5911 18.2558 10.9155 18.9206 10.0833 18.9206H3.50777C2.67555 18.9206 2 18.2558 2 17.4393C2 16.6217 2.67555 15.958 3.50777 15.958ZM18.5611 20.7778C20.4611 20.7778 22 19.2648 22 17.3992C22 15.5325 20.4611 14.0196 18.5611 14.0196C16.6623 14.0196 15.1223 15.5325 15.1223 17.3992C15.1223 19.2648 16.6623 20.7778 18.5611 20.7778Z" fill="#130F26"></path>
                                </g></g></svg>
                            </div>
                            <span class="nav-text">Theme Switcher</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="javascript:void()">
                                <input class="chk-col-primary filled-in" id="themecolor_2" name="themecolor_bg" type="radio" value="theme_2" />
                                <label for="themecolor_2" class="theme-bg">Theme 1</label></a>
                            </li>
                            <li><a href="javascript:void()">
                                <input class="chk-col-primary filled-in" id="themecolor_4" name="themecolor_bg" type="radio" value="theme_4" />
                                <label for="themecolor_4" class="theme-bg">Theme 2</label></a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a   href="review"  >
                    <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4" d="M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z" fill="#763ed0"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="#B9A8FF"/>
                            </svg>
                            </div>
                            <span class="nav-text">Ratings/Reviews</span>
                        </a>
                        <a class="" href="javascript:;" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#contactSupport">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" d="M11.7759 21.8374C9.49286 20.4273 7.37056 18.7645 5.44782 16.8796C4.09044 15.5338 3.0538 13.8905 2.4171 12.0753C1.27947 8.53523 2.60374 4.48948 6.30105 3.2884C8.25256 2.67553 10.375 3.05175 12.007 4.29983C13.6396 3.05315 15.7613 2.67705 17.7129 3.2884C21.4102 4.48948 22.7434 8.53523 21.6058 12.0753C20.9742 13.8888 19.9438 15.5319 18.5928 16.8796C16.6683 18.7625 14.5463 20.4251 12.2647 21.8374L12.0159 22L11.7759 21.8374Z" fill="#B9A8FF"></path>
                                <path d="M12.0109 22L11.776 21.8374C9.49013 20.4274 7.36487 18.7647 5.43902 16.8796C4.0752 15.5356 3.03238 13.8922 2.39052 12.0753C1.26177 8.53523 2.58605 4.48948 6.28335 3.2884C8.23486 2.67553 10.3853 3.05204 12.0109 4.31057V22Z" fill="#B9A8FF"></path>
                                <path d="M18.2304 9.99922C18.0296 9.98629 17.8425 9.8859 17.7131 9.72157C17.5836 9.55723 17.5232 9.3434 17.5459 9.13016C17.5677 8.4278 17.168 7.78851 16.5517 7.53977C16.1609 7.43309 15.9243 7.00987 16.022 6.59249C16.1148 6.18182 16.4993 5.92647 16.8858 6.0189C16.9346 6.027 16.9816 6.04468 17.0244 6.07105C18.2601 6.54658 19.0601 7.82641 18.9965 9.22576C18.9944 9.43785 18.9117 9.63998 18.7673 9.78581C18.6229 9.93164 18.4291 10.0087 18.2304 9.99922Z" fill="#763ed0"></path>
                            </svg>
                            </div>
                            <span class="nav-text">Support</span>
                        </a>
                    </li>


                </ul>

                <div class="copyright">
                    <p class="fs-14">&copy; 2021 <b style="font-weight: bold !important;">HoldLogix</b></p>
                </div>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body" style=" height: 70vh;">
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