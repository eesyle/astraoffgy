<?php
require_once 'auth_guard.php';
require_once "config.php";
// Ensure session is active before accessing session variables
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Resolve username from common sources (session, GET, POST).
 * Returns a trimmed string or empty string if not available.
 */
function resolveUsernameForOther(): string {
    // Prioritize session keys used across the app
    foreach (['username', 'UserName', 'user', 'uname'] as $key) {
        if (isset($_SESSION[$key]) && is_string($_SESSION[$key]) && trim($_SESSION[$key]) !== '') {
            return trim($_SESSION[$key]);
        }
    }
    // Fallback to GET/POST if session is missing
    foreach (['username', 'UserName', 'user', 'uname'] as $key) {
        if (isset($_GET[$key]) && is_string($_GET[$key]) && trim($_GET[$key]) !== '') {
            $_SESSION['username'] = trim($_GET[$key]);
            return trim($_GET[$key]);
        }
        if (isset($_POST[$key]) && is_string($_POST[$key]) && trim($_POST[$key]) !== '') {
            $_SESSION['username'] = trim($_POST[$key]);
            return trim($_POST[$key]);
        }
    }
    return '';
}

// Safely resolve current username
$username = resolveUsernameForOther();

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Default values to avoid null offset notices
$email = '';
$balance = 0;
$price = 0;

// Only query if we have a username
if ($username !== '') {
    // Use a prepared statement to avoid SQL injection and handle quoting
    if ($stmt = $conn->prepare('SELECT email, balance, price FROM users WHERE username = ?')) {
        $stmt->bind_param('s', $username);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                // Guard each field to prevent null offset warnings
                $email = isset($row['email']) ? (string)$row['email'] : '';
                $balance = isset($row['balance']) ? (float)$row['balance'] : 0;
                $price = isset($row['price']) ? (float)$row['price'] : 0;
            }
            if ($res) { $res->free(); }
        }
        $stmt->close();
    }
} else {
    // No username available; keep defaults to prevent notices
}

// Expose top balance value for consumers of this include
$_topbalance = $balance;
 

 