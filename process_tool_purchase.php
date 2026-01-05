<?php
session_start();
require_once "config.php";

// Debugging (Disable in production)
$debug = false; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_purchase'])) {

    $username = $_POST['username'] ?? 'Unknown User';
    $rdp_email = $_POST['rdp_email'] ?? '';
    $total_price = $_POST['total_price'] ?? 0;
    $items = $_POST['items'] ?? [];
    
    // Construct items list string
    $items_list_str = "";
    foreach ($items as $item) {
        $items_list_str .= "- " . $item['name'] . " ($" . $item['price'] . ")<br>";
    }

    // Email Logic
    require_once __DIR__ . '/mail/Exception.php';
    require_once __DIR__ . '/mail/PHPMailer.php';
    require_once __DIR__ . '/mail/SMTP.php';

    try {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'mail.holdlogix.live;smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@holdlogix.live';
        $mail->Password = 'Obedofla@00';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('info@holdlogix.live', 'HoldLogix');
        $mail->addAddress($rdp_email, $username); // User provided email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation - Tools Purchased';
        
        $bodyContent = "<h2>Hello " . htmlspecialchars($username) . ",</h2>";
        $bodyContent .= "<p>Thank you for your purchase. We have received your order for the following tools:</p>";
        $bodyContent .= "<blockquote>" . $items_list_str . "</blockquote>";
        $bodyContent .= "<p><strong>Total Amount: $" . number_format($total_price, 2) . "</strong></p>";
        $bodyContent .= "<hr>";
        $bodyContent .= "<p>We have noted your payment confirmation. Your RDP ID and Password will be sent to this email address (<strong>" . htmlspecialchars($rdp_email) . "</strong>) shortly after verification.</p>";
        $bodyContent .= "<p>If you have not made the payment yet, please ensure you complete it to avoid delays.</p>";
        $bodyContent .= "<br><p>Best Regards,<br>HoldLogix Team</p>";

        $mail->Body = $bodyContent;

        $mail->send();

        // Optional: Send Admin Notification
        $adminMail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $adminMail->isSMTP();
        $adminMail->Host = 'mail.holdlogix.live;smtp.hostinger.com';
        $adminMail->SMTPAuth = true;
        $adminMail->Username = 'info@holdlogix.live';
        $adminMail->Password = 'Obedofla@00';
        $adminMail->SMTPSecure = 'ssl';
        $adminMail->Port = 465;
        
        $adminMail->setFrom('info@holdlogix.live', 'HoldLogix System');
        $adminMail->addAddress('info@holdlogix.live'); // Send to admin
        
        $adminMail->isHTML(true);
        $adminMail->Subject = 'New Tool Order Received';
        $adminMail->Body = "User: $username<br>Email: $rdp_email<br>Total: $$total_price<br>Items:<br>$items_list_str";
        
        $adminMail->send();

        // Success Redirect
        echo "<script>
            alert('Order placed successfully! Please check your email ($rdp_email) for confirmation.');
            window.location.href = 'verified_products.php';
        </script>";

    } catch (\PHPMailer\PHPMailer\Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    // Invalid access
    header("Location: verified_products.php");
    exit();
}
?>
