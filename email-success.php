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
    <title>Transaction Processed</title>
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body { background: var(--bg-1); color: var(--text-1); }
      .success-hero { min-height: 70vh; display:flex; align-items:center; justify-content:center; }
      .card { background: var(--bg-2); border: 1px solid var(--border); }
      .btn-primary { background: var(--bg-3); border-color: var(--border); }
      .btn-primary:hover { background: var(--bg-2); }
      
      /* Modern Futuristic Message Styles */
      .neo-message-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        border: 2px solid #00d4ff;
        border-radius: 20px;
        padding: 30px;
        margin: 20px 0;
        box-shadow: 0 15px 35px rgba(0, 212, 255, 0.1), 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
      }
      
      .neo-message-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.1), transparent);
        animation: shimmer 3s infinite;
      }
      
      @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
      }
      
      .neo-title {
        color: #00d4ff;
        font-size: 1.8rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
        text-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
        letter-spacing: 1px;
      }
      
      .neo-text {
        color: #e0e6ed;
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 20px;
        text-align: center;
        position: relative;
        z-index: 1;
      }
      
      .neo-highlight {
        color: #00ff88;
        font-weight: 600;
        text-shadow: 0 0 10px rgba(0, 255, 136, 0.3);
      }
      
      .contact-section {
        background: rgba(0, 212, 255, 0.05);
        border: 1px solid rgba(0, 212, 255, 0.2);
        border-radius: 15px;
        padding: 25px;
        margin-top: 30px;
      }
      
      .contact-title {
        color: #00d4ff;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 15px;
        text-align: center;
      }
      
      .contact-info {
        color: #b8c6db;
        font-size: 1rem;
        line-height: 1.6;
        text-align: center;
      }
      
      .contact-info a {
        color: #00ff88;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
      }
      
      .contact-info a:hover {
        color: #00d4ff;
        text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
      }
      
      .dashboard-btn {
        background: linear-gradient(45deg, #00d4ff, #00ff88);
        border: none;
        border-radius: 50px;
        padding: 15px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a2e;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(0, 212, 255, 0.3);
      }
      
      .dashboard-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0, 212, 255, 0.4);
        color: #1a1a2e;
      }
    </style>
  </head>
  <body>
    <div class="container success-hero">
      <div class="col-lg-8">
        <div class="card shadow p-4 text-center">
          <div class="mb-3">
            <img src="assets/logo.png" alt="Logo" style="height:48px" />
          </div>
          <h2 class="mb-2">Transaction Processed Successfully</h2>
          <p class="lead">Thanks<?php echo $username ? ", " . $username : ""; ?>!</p>
          <p>Status: <code><?php echo $status; ?></code></p>
          
          <?php
            // Display conditional messages based on type parameter
            $messageTitle = '';
            $messageContent = '';
            
            if ($type === 'top') {
              $messageTitle = 'Top-Up Confirmation';
              $messageContent = 'Thank you for topping up your account.<br><br>
                Your payment is currently being processed — please allow up to <span class="neo-highlight">20 minutes</span> for confirmation.<br><br>
                Once your payment is verified, you\'ll receive a confirmation email automatically.<br><br>
                If you don\'t receive the confirmation within 20 minutes, please contact our support team with your transaction ID for quick assistance.<br><br>
                For any issue with your top-up, feel free to get in touch with our support team anytime.';
            } elseif ($type === 'refund') {
              $messageTitle = 'Refund Processed';
              $messageContent = 'Your refund has been successfully processed.<br><br>
                The refunded amount will be credited back to your original payment method within <span class="neo-highlight">3–5 business days</span>, depending on your bank or payment provider.<br><br>
                You\'ll receive a confirmation email once the refund is complete.<br><br>
                If you don\'t see the funds after 5 business days, please contact our support team with your refund reference number for assistance.';
            } elseif ($type === 'purchase') {
              $messageTitle = 'Purchase Confirmation';
              $messageContent = 'Thank you for your purchase!<br><br>
                Your order is being processed — please allow a few minutes for confirmation.<br><br>
                Once your payment is verified, you\'ll receive a confirmation email with your order details.<br><br>
                If you don\'t receive a confirmation email within <span class="neo-highlight">20 minutes</span>, please contact our support team with your transaction ID for prompt assistance.<br><br>
                For any issue with your purchase, feel free to reach out to our support team anytime.';
            } else {
              // Default message for unknown types
              $messageTitle = 'Transaction Processed';
              $messageContent = 'Your transaction has been processed successfully.<br><br>
                You will receive a confirmation email shortly with the details.<br><br>
                If you have any questions or concerns, please don\'t hesitate to contact our support team.';
            }
          ?>
          
          <!-- Modern Futuristic Message Display -->
          <div class="neo-message-card">
            <h3 class="neo-title"><?php echo $messageTitle; ?></h3>
            <div class="neo-text">
              <?php echo $messageContent; ?>
            </div>
            
            <!-- Contact Information Section -->
            <div class="contact-section">
              <div class="contact-title">Need Help? Contact Us:</div>
              <div class="contact-info">
                <p><strong>WhatsApp:</strong> <a href="https://wa.me/14093402245">+1 409 340 2245</a></p>
                <p><strong>Telegram:</strong> <a href="https://t.me/BalrogAdmin">@BalrogAdmin</a></p>
                <p><strong>Email:</strong> <a href="mailto:support@holdlogix.com">support@holdlogix.com</a></p>
              </div>
            </div>
          </div>
          
          <div class="mt-4">
            <a class="btn dashboard-btn" href="dash.php">Go to Dashboard</a>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  </body>
</html>