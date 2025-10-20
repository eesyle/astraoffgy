<?php
session_start();
require 'dbcon.php';
require_once __DIR__ . '/bulk_balance_price.php';
require_once __DIR__ . '/bulk_info.php';

// Generic bulk handler for any bank table via POST
if (isset($_POST['bulk_edit_balance_price'])) {
    $table = isset($_POST['table']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']) : '';
    $redirect = isset($_POST['redirect_path']) ? $_POST['redirect_path'] : 'index.php';
    if (!$table) {
        $_SESSION['message'] = 'Missing table parameter.';
        header('Location: ' . $redirect);
        exit;
    }
    handleBulkBalancePrice($con, $table, $redirect);
}

// Generic bulk info update routing
if (isset($_POST['bulk_edit_info'])) {
    $table = isset($_POST['table']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']) : '';
    $redirect = isset($_POST['redirect_path']) ? $_POST['redirect_path'] : 'index.php';
    if (!$table) {
        $_SESSION['message'] = 'Missing table parameter.';
        header('Location: ' . $redirect);
        exit;
    }
    handleBulkInfo($con, $table, $redirect);
}

// ... existing code ... other actions can continue below
?>