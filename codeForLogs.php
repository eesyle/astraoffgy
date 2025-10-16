<?php
require_once 'auth_guard.php';
require_once "config.php";
// At this point, the user is guaranteed to be logged in
$username = $_SESSION['username'];
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
$query = "SELECT * FROM users WHERE username = '$username'";  
$result = mysqli_query($conn, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $balance = $row['balance'];
    $price = $row['price'];
    // Expose user is_active flag for centralized banklogs filtering
    $is_active = isset($row['is_active']) ? (int)$row['is_active'] : 0;
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($connection);
}

