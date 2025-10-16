<?php
// Centralized banklogs query helper
// Expects: $conn (mysqli), $is_active (int), $balance (float|numeric), $banklogs_table (string)
// Optional: $banklogs_select (string of columns)

// Validate connection
if (!isset($conn)) {
    // No connection available; ensure $rows is defined to avoid notices
    $rows = [];
    return;
}

// Validate table name (allow letters, numbers, underscores)
if (!isset($banklogs_table) || !preg_match('/^[a-zA-Z0-9_]+$/', $banklogs_table)) {
    $rows = [];
    return;
}

// Decide default select columns; allow override via $banklogs_select
$isActiveVal = isset($is_active) ? (int)$is_active : 0;
$defaultSelectActive = 'id, balance, info, price';
$defaultSelectInactive = 'id, price, info, balance';
$select = (isset($banklogs_select) && is_string($banklogs_select) && strlen($banklogs_select) > 0)
    ? $banklogs_select
    : ($isActiveVal > 0 ? $defaultSelectActive : $defaultSelectInactive);

// Build query based on user's is_active status
$userBalance = isset($balance) ? (float)$balance : 0.0;

if ($isActiveVal > 0) {
    // Active user: access everything with no restrictions
    $sql = "SELECT {$select} FROM `{$banklogs_table}`";
} else {
    // Inactive user: restrict to items where price > user's balance
    $sql = "SELECT {$select} FROM `{$banklogs_table}` WHERE price > {$userBalance}";
}

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
} else {
    $rows = [];
}

?>