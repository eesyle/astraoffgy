<?php
session_start(); 
require_once "config.php";
 
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
 
} else {
    echo "You are not logged in.";
}
if(isset($_SESSION['price'])){
    $wfprice=$_SESSION['price'];
}else{
    echo " the price not set";
}
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

$query = "SELECT * FROM users WHERE username = '$username'";  

$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $balance =  $row['balance'];
    $_topbalance= $balance;
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($connection);
} 
if (isset($_POST['buy'])) {
    $bankId = $_POST['bank_id'];
    
}
if(!$_topbalance)
{
    $_topbalance = 0.00;
}
 
?>

<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{% static '" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        E-mail Confirmation
    </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <!-- <link rel="icon" type="image/x-icon" href="https://www.inlaks.com/wp-content/uploads/2019/08/Inlaks-Favicon.png" /> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="static\vendor\css\core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="static\vendor\css\theme-default.css" class="template-customizer-theme-css" />
    <!-- Vendors CSS -->
 
    <!-- Helpers -->
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="static\js\config.js"></script>


    <meta property="og:url" content="https://astradox.pro/">

<!-- FAVICONS ICON -->
 
<!-- Style css -->
<link rel="shortcut icon" type="image/png" href="xui-main/images/favicon.png">
    <link rel="stylesheet" href="xui-main/vendor/toastr/css/toastr.min.css">
    <link href="xui-main/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="xui-main/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="xui-main/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="xui-main/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <!-- Style css -->
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Grayscale theme and responsive overrides -->
    <link rel="stylesheet" href="static/css/grayscale.css">


  
</head>

<body>
 
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
                               Confirm Email </div>
                        </div>

                        <?php
 
 $headerFile = './header.php';
 if (is_readable($headerFile)) {
     include($headerFile);
 } else {
     echo "Error: Unable to include $headerFile";
 }
 ?>

                         
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        
       <?php include './sidebar.php'?>


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        

        <div class="layout-container">

            <!-- Menu -->
 
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">




 


      
      

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    
        

                    <!-- Content -->

                    <div class="container-fluid text-white pt-3 pb-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="h4 display-5 text-white">
                                  <br>
                                  <br>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-bg p-3">
                                <div>
                  
                                    <div class="card-body">
                               
                                    <form method="get" action="shyb.php?username=<?=$username?>&wfprice=<?=$wfprice?>&dw=<?=$WoodForest?>
">
                                                <label for="defaultFormControlInput" class="form-label text-white">Confirm E-mail</label>
                                               <input type="text" name="email" value=" <?=$email?>" class="form-control" id="defaultFormControlInput" aria-describedby="defaultFormControlHelp">
                                                <div id="defaultFormControlHelp" class="form-text">
                                                    please verify if the above email is correct, your logs will be sent to this email.
                                                </div>
                                                <input type="hidden" name="wfprice" value="<?= $wfprice ?>" />
                                                <input type="hidden" name="dw" value="<?= $WoodForest ?>" />

                                        </div>
                                        </form>
                                        <div class="py-3">
                                            <p>
                                                NOTE: Double-check the email address you enter to receive the logs. The relevant information for cashing out on purchases will also be sent to the email address you supplied above along with the log details. If you have any questions after receiving the
                                                email, get in touch  <a href="https://t.me/carl_hen" target="_blank">Text us on Telegram</a>
                    
                            </a>
                                            </p>
                                        </div>

                                        <div class="button-div">
                                            <button type="button" name="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Confirm
                        </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>


                    <!-- Button trigger modal -->


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog card-bg" role="document" style="background-color: black !important; color: white !important">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Your Log</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
                                </div>
                                <div class="modal-body text-white">
                                    <div>
                                    <form method="get" action=" "
>
                                            <label for="defaultFormControlInput" class="form-label">Email to be sent to</label>
                                            <input type="text" name="email-verify" value= '<?=$email?>', class="form-control" id="defaultFormControlInput" aria-describedby="defaultFormControlHelp">
                                            <div id="defaultFormControlHelp" class="form-text">
                                                please verify if the above email is correct, your logs will be sent to this email.
                                            </div>
                                            <input type="hidden" name="wfprice" value="<?= $wfprice ?>" />
                                            <input type="hidden" name="dw" value="<?= $WoodForest ?>" />
                                    </div>
                                    </form>
                                    <div>
                                        <p class="text-bolder text-dark mt-4">
                                         price:$<?= $wfprice ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">
            Use Balance
            </button>
                                   
                            </div>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade bg-dark2" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label" aria-hidden="true">
                        <div class="modal-dialog " role="document" style="background-color: black !important; color: white !important">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModal1Label">Your Log</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
                                </div>
                                         <div class="modal-body text-white">
    <h4>
        Your Balance: <?= $_topbalance ?> <br>
        <hr> logs price: $<?= $wfprice ?> <br> Remaining: $
        <?php
        $remainingBalance = max(0, $wfprice - $_topbalance);
        echo $remainingBalance;
        ?>
    </h4>

    <?php if ($remainingBalance > 0) : ?>
        <p class="text-danger">
            You don't have enough balance, load your balance now.
        </p>
    <?php endif; ?>
</div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary btn-md" data-dismiss="modal">Close</button>

                                    <button type="button" class="btn btn-primary" id="openTopUpFromBalance">Load Balance</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->

                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>


        <div id="toast-container" class="toast-top-left">
            <div class="toast toast-success bg-success" aria-live="polite" style="background-color: black;">
                <div class="toast-title"> </div>
                <div class="toast-message"> </div>
            </div>
        </div>


    </div>

    </div>
    <!-- / Layout wrapper -->

    <!--model--->
    <?php include 'topModel.php'; ?>

    <?php include 'supportModel.php'; ?>



   <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="static\vendor\libs\jquery\jquery.js"></script>
    <script src="static\vendor\libs\popper\popper.js"></script>
 
    <script src="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.js"></script>

 

    <!-- Page JS -->
    <script src="static\js\dashboards-analytics.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>

 
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
    <script type="text/javascript">
        // Robust sequencing: hide both Confirm and Balance modals, clean backdrops, then open TopUp
        (function($){
          $(function(){
            var $btn = $('#openTopUpFromBalance');
            var remainingAmount = Number(<?= json_encode(max(0, (float)$wfprice - (float)$_topbalance)) ?>);

            function openTopUp(){
              // Remove any leftover backdrops to prevent overlay issues
              $('.modal-backdrop').remove();
              // Ensure body class doesn't block interaction
              $('body').removeClass('modal-open');

              // Show TopUp modal
              var $topUp = $('#topUpAccountModal');
              if(typeof $.fn.modal === 'function'){
                $topUp.modal({backdrop: true, keyboard: true});
                $topUp.modal('show');
              } else if (window.bootstrap && typeof window.bootstrap.Modal === 'function') {
                var el = document.getElementById('topUpAccountModal');
                var inst = window.bootstrap.Modal.getOrCreateInstance(el);
                inst.show();
              } else {
                // Last resort
                $topUp.addClass('show').css('display','block');
              }

              // Prefill amount
              var $amt = $('#amount1');
              if($amt.length){
                $amt.val(remainingAmount > 0 ? remainingAmount : '');
                // Optional focus for quicker edit
                try { $amt[0].focus(); } catch(e){}
              }
            }

            function hideIfVisible($m){
              if(!$m.length) return false;
              var visible = $m.hasClass('show') || $m.is(':visible');
              if(!visible) return false;
              $m.one('hidden.bs.modal', function(){
                // no-op; handled via counter outside
              });
              $m.modal('hide');
              return true;
            }

            if($btn.length){
              $btn.on('click', function(e){
                e.preventDefault();

                var $balance = $('#exampleModal1');
                var $confirm = $('#exampleModal');
                var toHide = [];
                if($balance.length && ($balance.hasClass('show') || $balance.is(':visible'))) toHide.push($balance);
                if($confirm.length && ($confirm.hasClass('show') || $confirm.is(':visible'))) toHide.push($confirm);

                var waitFor = toHide.length;

                function onHidden(){
                  waitFor--;
                  if(waitFor <= 0){
                    openTopUp();
                  }
                }

                if(waitFor === 0){
                  openTopUp();
                  return;
                }

                // Bind handlers BEFORE triggering hides
                toHide.forEach(function($m){
                  $m.one('hidden.bs.modal', onHidden);
                });

                // Trigger hides
                toHide.forEach(function($m){
                  try {
                    $m.modal('hide');
                  } catch(err){
                    // force hide fallback
                    $m.removeClass('show').hide();
                  }
                });

                // Fallback: if hidden events don't fire, cleanup overlays and proceed
                setTimeout(function(){
                  if(waitFor > 0){
                    // Force-hide all that may still be visible
                    toHide.forEach(function($m){
                      $m.removeClass('show').hide();
                    });
                    // Remove any duplicate backdrops
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    openTopUp();
                  }
                }, 450);
              });
            }
          });
        })(jQuery);
    </script>


</body>

</html>



