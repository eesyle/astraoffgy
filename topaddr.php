<?php
require_once "codeForOther.php";
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$currency = isset($_GET['currency']) ? strtoupper($_GET['currency']) : '';
$address = isset($_GET['address']) ? $_GET['address'] : '';
$image = isset($_GET['image']) ? $_GET['image'] : '';
$wfprice = '';
$username = isset($_GET['username']) ? $_GET['username'] : '';
$rdp_email = isset($_GET['rdp_email']) ? $_GET['rdp_email'] : '';
$itemsEncoded = isset($_GET['items']) ? $_GET['items'] : '';
$items = [];
if ($itemsEncoded) {
    $decoded = base64_decode($itemsEncoded, true);
    if ($decoded !== false) {
        $arr = json_decode($decoded, true);
        if (is_array($arr)) $items = $arr;
    }
}
if (isset($_GET['wfprice']) && is_numeric($_GET['wfprice'])) {
    $wfprice = $_GET['wfprice'];
} elseif (isset($_GET['price']) && is_numeric($_GET['price'])) {
    $wfprice = $_GET['price'];
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    require_once __DIR__ . '/mail/Exception.php';
    require_once __DIR__ . '/mail/PHPMailer.php';
    require_once __DIR__ . '/mail/SMTP.php';
    try {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'mail.holdlogix.live;smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@holdlogix.live';
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('info@holdlogix.live', 'HoldLogix');
        if ($rdp_email) $mail->addAddress($rdp_email, $username ?: $rdp_email);
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation - Tools Purchased';
        $list = '';
        foreach ($items as $it) {
            $list .= '- ' . htmlspecialchars($it['name'] ?? '') . ' ($' . number_format((float)($it['price'] ?? 0), 2) . ')<br>';
        }
        $body = "<h2>Hello " . htmlspecialchars($username ?: 'Customer') . ",</h2>"
            . "<p>Thank you for your purchase. We have received your order for the following tools:</p>"
            . "<blockquote>" . $list . "</blockquote>"
            . "<p><strong>Total Amount: $" . number_format((float)$wfprice, 2) . "</strong></p>"
            . "<p>Payment method: <strong>" . htmlspecialchars($currency) . "</strong></p>"
            . "<p>Payment address: <code>" . htmlspecialchars($address) . "</code></p>"
            . "<hr>"
            . "<p>Your RDP ID and Password will be sent to this email address (" . htmlspecialchars($rdp_email ?: 'N/A') . ") shortly after verification.</p>"
            . "<p>If you have not made the payment yet, please ensure you complete it to avoid delays.</p>"
            . "<br><p>Best Regards,<br>HoldLogix Team</p>";
        $mail->Body = $body;
        $mail->send();
        $adminMail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $adminMail->isSMTP();
        $adminMail->Host = 'mail.holdlogix.live;smtp.hostinger.com';
        $adminMail->SMTPAuth = true;
        $adminMail->Username = 'info@holdlogix.live';
        $adminMail->Password = 'Obedofla@00';
        $adminMail->SMTPSecure = 'ssl';
        $adminMail->Port = 465;
        $adminMail->setFrom('info@holdlogix.live', 'HoldLogix System');
        $adminMail->addAddress('infos@holdlogix.live');
        $adminMail->isHTML(true);
        $adminMail->Subject = 'New Tool Order Received';
        $adminMail->Body = "User: " . htmlspecialchars($username) . "<br>Email: " . htmlspecialchars($rdp_email) . "<br>Total: $" . number_format((float)$wfprice, 2) . "<br>Currency: " . htmlspecialchars($currency) . "<br>Address: " . htmlspecialchars($address) . "<br>Items:<br>" . $list;
        if (isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
            $adminMail->addAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
        }
        $adminMail->send();
        echo "<script>alert('Order placed successfully! Please check your email (" . htmlspecialchars($rdp_email) . ") for confirmation.'); window.location.href='verified_products.php';</script>";
        exit();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $e->getMessage();
        exit();
    }
}
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
    <style>
        .coin-logo {
            width: 300px;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: contain;
        }
        code.address {
            word-break: break-all;
        }
    </style>
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
                                <h4 class="fs-18 font-w600"><?= htmlspecialchars($currency) ?> NETWORK</h4>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center justify-contain-center">
                                    <div class="profile-photo col-md-4 text-center">
                                        <?php if ($image): ?>
                                            <img src="<?= htmlspecialchars($image) ?>" class="img-fluid coin-logo" alt="<?= htmlspecialchars($currency) ?> QR">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <h3 class="mt-2 mb-1"><code class="address"><?= htmlspecialchars($address) ?></code></h3>
                                            <a class="mt-3 ml-2" href="javascript:;" onclick='copyToClip("<?= htmlspecialchars($address) ?>")'><span class="badge badge-primary">copy</span></a>
                                        </div>
                                        <p><i class="fa fa-circle"></i> Send <strong><?= htmlspecialchars($currency) ?></strong> to the address above.</p>
                                        <p class="mb-2"><i class="fa fa-circle"></i> Get in touch with the support team at <a href="mailto:support@holdlogix.live"><u>support@holdlogix.live</u></a></p>
                                        <p class="mb-2"><i class="fa fa-circle text-warning"></i> <b>NB:</b> Payments should be confirmed in less than 15 minutes</p>
                                        <form method="post" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" enctype="multipart/form-data" id="paymentForm">
                                            <?php if($wfprice): ?>
                                                <input type="hidden" name="wfprice" value="<?php echo htmlspecialchars($wfprice); ?>">
                                                <input type="hidden" name="trigger" value="purchase">
                                            <?php else: ?>
                                                <input type="hidden" name="trigger" value="purchase">
                                            <?php endif; ?>
                                            <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                                            <input type="hidden" name="rdp_email" value="<?= htmlspecialchars($rdp_email) ?>">
                                            <input type="hidden" name="items" value="<?= htmlspecialchars($itemsEncoded) ?>">
                                            <p class="contact-form-text"  style="color: #fff; background-color: #292D35;">Upload payment screenshot :<input type="file" name="file" id="file" required></p>
                                            <button class="fa-solid btn btn-block btn-success" name="submit">Done</button>
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
        $(document).ready(function() {
            $('#paymentForm').on('submit', function() {
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
