<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$username = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : (isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '');
$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : 'sent';
// Optional type for context-specific success messages (e.g., refund)
$type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sent</title>
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body { background: var(--bg-1); color: var(--text-1); }
      .success-hero { min-height: 70vh; display:flex; align-items:center; justify-content:center; }
      .card { background: var(--bg-2); border: 1px solid var(--border); }
      .btn-primary { background: var(--bg-3); border-color: var(--border); }
      .btn-primary:hover { background: var(--bg-2); }
    </style>
  </head>
  <body>
    <div class="container success-hero">
      <div class="col-lg-8">
        <div class="card shadow p-4 text-center">
          <div class="mb-3">
            <img src="assets/logo.png" alt="Logo" style="height:48px" />
          </div>
          <h2 class="mb-2"><?php echo ($type === 'refund') ? 'Refund Request Submitted' : 'Email Successfully Sent'; ?></h2>
          <p class="lead">Thanks<?php echo $username ? ", " . $username : ""; ?>. Please check your email for more details.</p>
          <p>Status: <code><?php echo $status; ?></code></p>
          <?php
            // Build a preview of the message that was sent to the user, based on session context
            $trigger = isset($_SESSION['trigger']) ? $_SESSION['trigger'] : '';
            $bankName = isset($_SESSION['bank']) ? htmlspecialchars(trim($_SESSION['bank'])) : '';
            $amount = (isset($_SESSION['price']) && is_numeric($_SESSION['price'])) ? (float)$_SESSION['price'] : 0.0;
            $amountFmt = number_format($amount, 2);

            $dashboardUrl = 'https://holdlogix.com/dash';
            $contactBlock = "<hr style='border:0;border-top:1px solid #e0e0e0;margin:24px 0'>
<div style='font-family:Arial,sans-serif;color:#333333;font-size:14px;line-height:1.6;text-align:left'>
  <p style='margin:0 0 10px'>Need help? Contact us:</p>
  <p style='margin:0'>WhatsApp: <a href='https://wa.me/14093402245' style='color:#1a73e8;text-decoration:none'>+1 409 340 2245</a></p>
  <p style='margin:0'>Telegram: <a href='https://t.me/BalrogAdmin' style='color:#1a73e8;text-decoration:none'>@BalrogAdmin</a></p>
  <p style='margin:0'>Email: <a href='mailto:support@holdlogix.com' style='color:#1a73e8;text-decoration:none'>support@holdlogix.com</a></p>
  <table cellpadding='0' cellspacing='0' border='0' style='margin-top:16px'>
    <tr>
      <td align='center'>
        <a href='" . $dashboardUrl . "' style='background-color:#1a73e8;color:#ffffff;text-decoration:none;padding:12px 20px;border-radius:6px;display:inline-block;font-weight:600'>Go to Dashboard</a>
      </td>
    </tr>
  </table>
</div>";

            $messageHtml = '';
            if ($type === 'refund') {
              $messageHtml = "<p>Hello from HoldLogix</p>"
                . "<p>Dear " . ($username ?: 'User') . ", your refund request has been received successfully.</p>"
                . "<p>Your request will be processed within three days.</p>"
                . "<p>Thank you for choosing HoldLogix.</p>"
                . $contactBlock;
            } elseif ($trigger === 'top') {
              $messageHtml = "<p>Hello from HoldLogix</p>"
                . "<p>Dear " . ($username ?: 'User') . " You have topped up a balance of $" . $amountFmt . " with HoldLogix</p>"
                . "<p>Your transaction is pending; you will be informed via this email when complete</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            } elseif ($trigger === 'purchase') {
              $baseUrl = 'https://holdlogix.com';
              $link = $baseUrl . '/view-log.php?username=' . urlencode($username ?: '');
              $bankText = $bankName !== '' ? (' from ' . $bankName) : '';
              $messageHtml = "<p>Dear " . ($username ?: 'User') . " Your purchase of a price: $ " . $amountFmt . $bankText . "</p>"
                . "<p>Has been processed successfully. Your transaction is pending; you will be notified when complete.</p>"
                . "<p><a href='" . htmlspecialchars($link) . "' target='_blank'>Click here to view your log options (RATS/SOCKS)</a></p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            } elseif ($trigger === 'rats') {
              $messageHtml = "<p>Dear " . ($username ?: 'User') . " You selected RATS for your log options.</p>"
                . "<p>Price: $ " . $amountFmt . ". Your transaction is pending; you will be notified when complete.</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            } elseif ($trigger === 'socks') {
              $messageHtml = "<p>Dear " . ($username ?: 'User') . " You selected SOCKS for your log options.</p>"
                . "<p>Price: $ " . $amountFmt . ". Your transaction is pending; you will be notified when complete.</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            } elseif ($trigger === 'card') {
              $messageHtml = "<p>Dear " . ($username ?: 'User') . " You have just purchased a card of a price: $ " . $amountFmt . "</p>"
                . "<p>Has been processed successfully. Your transaction is pending; you will be notified when complete.</p>"
                . "<p>Thank you for using HoldLogix</p>"
                . $contactBlock;
            }
          ?>
          <?php if (!empty($messageHtml)) { ?>
            <div class="text-left mt-4">
              <h5 class="mb-2">Sent Email Preview</h5>
              <div class="card p-3" style="background: var(--bg-1); border: 1px dashed var(--border);">
                <?php echo $messageHtml; ?>
              </div>
            </div>
          <?php } ?>
          <div class="mt-4">
            <a class="btn btn-primary btn-lg" href="dash.php">Go to Dashboard</a>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  </body>
</html>