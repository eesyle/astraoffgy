<?php
 require_once 'config.php';
if (isset($_POST['toggle_active'])) {
    $review_id = $_POST['review_id'];
    $isActive = $_POST['isActive'] ? 0 : 1; // Toggle the status

    // Update the isActive status
    $stmt = $conn->prepare('UPDATE customer_reviews SET isActive = ? WHERE id = ?');
    $stmt->bind_param('ii', $isActive, $review_id);
    $stmt->execute();

    // Redirect to avoid form resubmission
    header("Location: admin_reply.php");
    exit();
}


?>