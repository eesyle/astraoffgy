<?php
// Admin handler to update an order's status via history.is_active
// POST: order_id (int), order_status ('pending'|'cancelled')

include 'codeForOther.php';

if (!isset($conn) || $conn->connect_error) {
    header('Location: more.php?updated=0');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $orderStatus = isset($_POST['order_status']) ? trim($_POST['order_status']) : '';
    $isActiveParam = isset($_POST['is_active']) ? $_POST['is_active'] : null;

    // Decide is_active: direct param takes precedence, otherwise map from order_status
    if ($isActiveParam !== null && ($isActiveParam === '0' || $isActiveParam === '1' || $isActiveParam === 0 || $isActiveParam === 1)) {
        $isActive = intval($isActiveParam);
    } else {
        $isActive = ($orderStatus === 'pending') ? 1 : 0; // default any non-pending to 0
    }

    if ($orderId > 0) {
        // Use prepared statement for safety
        if ($stmt = $conn->prepare('UPDATE history SET is_active = ? WHERE id = ?')) {
            $stmt->bind_param('ii', $isActive, $orderId);
            $ok = $stmt->execute();
            $stmt->close();
            header('Location: more.php?updated=' . ($ok ? '1' : '0'));
            exit;
        }
    }
}

header('Location: more.php?updated=0');
exit;