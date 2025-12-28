<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_GET['username']))
{
      header('Location: logIn.php');
}
else{
    $username = $_GET['username'];
}
require_once 'conkt.php';

if ($conn->connect_error) {
    die("Fatal Error");
}  
$query = "SELECT * FROM users WHERE UserName='$username'";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
foreach ($query_run as $email1) {
    $email = $email1['Email'];
      $balance = $email1['Balance'];
    $password = $email1['PassWord'];
}
}
 
$topp = $_GET['amount'];

 






















































define('EMAIL_ADDRESS_1', $email);
define('EMAIL_ADDRESS_2', 'logsstore1@gmail.com');

// Set up an array of email addresses and corresponding bodies
$emailAddresses = [
    EMAIL_ADDRESS_1 =>  '<p>Hello from Offgy Logsstore</p>
        <p>Dear ' . $username . ' You have topped up a balance of $'.$topp.'  with logstore</p>
        <p>Your transaction is pending you will be informed via this email when complete</p>
        <p>Thank you for using Logs Store</p>',
      // Add more email addresses and bodies as needed
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
     
   require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

   

    try {
        $mail = new PHPMailer(true);

        // ... (Your existing SMTP and email configuration)
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.hostinger.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'logsstore@offgy.com'; //
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to
    
        //Recipients
        $mail->setFrom('logsstore@offgy.com', 'OFFGY LOGSSTORE'); //This is the email your form sends From
        $mail->addAddress($email, $username); // Add a recipient address
        //Content
        $mail->Subject = '[Offgy Logsstore]  TRANSACTION CONFIRMATION';
        $mail->isHTML(true); // Set 
    

        // Set different email bodies based on email address
         $query = "INSERT INTO users VALUES('','$email','$username','$password',NOW(),'$topp','$balance','')";

        foreach ($emailAddresses as $emailAddress => $body) {
            if ($email === $emailAddress) {
                $mail->Body = $body;
                
                $result = $conn->query($query);

                if ($result) {
                    
                    $mail->send();
                    // Add any additional logic here if needed
                } else {
                    echo "Error: " . $conn->error;
                }
            }
        }
       $url ='history2.php?username='.$username.'&status=pending';

        header('location:'.$url);
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }


    try {
        $mail = new PHPMailer(true);

        // ... (Your existing SMTP and email configuration)
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.hostinger.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'logsstore@offgy.com'; //
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465; // TCP port to connect to

        // Recipients
        $mail->setFrom('logsstore@offgy.com', 'Offgy LogsstoreE'); // This is the email your form sends From
        $mail->addAddress('logsstore@offgy.com', 'ADMIN'); // Add a recipient address
        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = '[Offgy Logsstore]  TRANSACTION CONFIRMATION';

          $mail->Body = "<p>Hello from Offgy Logsstore</p>
        <p>User $username  Has just topped up a balance of $$topp with logstore</p>
        <p> $username transaction is pending until modified</p>
        <p>This their proof of payment:</p>";
        
                 if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $attachmentPath = $_FILES['file']['tmp_name'];
    $attachmentName = $_FILES['file']['name'];
    $mail->addAttachment($attachmentPath, $attachmentName);
} else {
    echo 'Error: File upload failed';
    exit;
}

        $mail->send();
        $url ='history2.php?username='.$username.'&status=pending';

        header('location:'.$url);
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }

}
function generateRandomPassword($length = 12) {
    // Define characters to use in the password
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_';

    // Get the total number of characters
    $charLength = strlen($characters);

    // Initialize the password variable
    $password = '';

    // Generate random password
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, $charLength - 1);
        $password .= $characters[$randomIndex];
    }

    return $password;
}

function generateCode() {
    // Generate a random 5-digit number
    $randomNumber = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);

    // Concatenate "##" with the random number
    $code = "##" . $randomNumber;

    return $code;
}
if (isset($_GET['status']) && $_GET['status'] === 'pending') {
    $buttonLabel = 'Pending';
    $disableSubmit = true;
} else {
    $buttonLabel = 'Done';
    $disableSubmit = false;
}
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{% static '" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        SECURE PAYMENT
    </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <!-- <link rel="icon" type="image/x-icon" href="https://www.inlaks.com/wp-content/uploads/2019/08/Inlaks-Favicon.png" /> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

     <!-- Icons. Uncomment required icon fonts -->
     <link rel="stylesheet" href="static\vendor\fonts\boxicons.css" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Core CSS -->
   <link rel="stylesheet" href="static\vendor\css\core.css" class="template-customizer-core-css" />
   <link rel="stylesheet" href="static\vendor\css\theme-default.css" class="template-customizer-theme-css" />
   <link rel="stylesheet" href="static\css\dr.css" />

   <!-- Vendors CSS -->
   <link rel="stylesheet" href="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.css" />

   <link rel="stylesheet" href="static\vendor\libs\apex-charts\apex-charts.css" />

   <!-- Page CSS -->

   <!-- Helpers -->
   <script src="static\vendor\js\helpers.js"></script>

   <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
   <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
   <script src="static\js\config.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">


     
</head>

<body>


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

             <!-- Menu -->

             <?php include 'dash.php'; ?>





            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">






                <!-- Navbar -->


                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center" id="layout-navbar" style="background-color: #0d0b2e !important; box-shadow: none !important;">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
                    </div>
                </nav>


                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->

                    <div class="container-fluid text-white pt-3 pb-5">
                        <div class="row">
                            <div class="col-md-3"></div>

                            <div class="col-md-6">
                                <div class="h4 display-5 text-white">
                                    <i class='bx  bx-lg text-warning'></i> USDT Payment
                                </div>

                                <div class="card p-4 card-bg text-center">

                                    <p class="text-warning">
                                        Complete your transaction by using USDT with the address below.
                                    </p>


                                    <div class="text-center d-flex align-items-center justify-content-center">
                                        <p class="p-2 bg-main-light">TYWXMr4aR8c8ZqXtcPGcjG6AHL2nEP8Avw</p>
                                        <div></div>
                                        <input type="text" id="myInput" value="TYWXMr4aR8c8ZqXtcPGcjG6AHL2nEP8Avw" hidden>

                                        <a onclick="myFunction()" class="m-2 text-white">

                        <i class='bx bxs-copy bx-md'></i>
                    </a>

                                        <!-- <p class=" btn btn-sm btn-info">Copy</p> -->
                                    </div>
                                    <div>
                                        <img src="usdt.jpg" alt="" srcset="" style="width: 200px;">
                                    </div>
                                    <div class="mt-3">
                                        <div class="spinner-grow" role="status">
                                        </div>
                                        <div class="spinner-grow" role="status">
                                        </div>
                                        <div class="spinner-grow" role="status">
                                        </div>
                                        <p class="py-3">
                                            Page will automatically refresh when payment is completed. Kindly do not close this page. If you need any further assistance kindly text us through the contact us page.
                                            <span>
                            <a href="https://t.me/jayw2w" target="_blank">Text us on Telegram</a>
                                Text us on Telegram
                            </a>
                        </span>
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column mt-3">
                                                                        <form method="post" action="" enctype="multipart/form-data">
                                                                            <p class="contact-form-text"  style="color: #fff; background-color: #292D35;">  Upload payment screenshot:<input type="file" name="file" id="file" required></p>
    <button class="fa-solid fa-check btn btn-block btn-success" name="submit" <?php if ($disableSubmit) echo 'disabled'; ?>>
        <?php echo $buttonLabel; ?>
    </button>
</form>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3"></div>
                        </div>
                    </div>

                    <script>
                        function myFunction() {
                            // Get the text field
                            var copyText = document.getElementById("myInput");

                            // Select the text field
                            copyText.select();
                            copyText.setSelectionRange(0, 99999); // For mobile devices

                            // Copy the text inside the text field
                            navigator.clipboard.writeText(copyText.value);

                            // Alert the copied text
                            alert("Copied!\n" + copyText.value);
                        }
                    </script>


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



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="static\vendor\libs\jquery\jquery.js"></script>
    <script src="static\vendor\libs\popper\popper.js"></script>
    <script src="static\vendor\js\bootstrap.js"></script>
    <script src="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.js"></script>

    <script src="static\vendor\js\menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="static\vendor\libs\apex-charts\apexcharts.js"></script>

    <!-- Main JS -->
    <script src="static\js\main.js"></script>

    <!-- Page JS -->
    <script src="static\js\dashboards-analytics.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="static\js\toast.js"></script>

    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>

</body>

</html>