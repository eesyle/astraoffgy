<?php
// Session needed to carry price/bank to confirmation page
session_start();

// Accept zero prices and alternate field names; normalize numeric input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $price = null;
    if (array_key_exists('price', $_POST)) {
        $price = $_POST['price'];
    } elseif (array_key_exists('amount', $_POST)) {
        $price = $_POST['amount'];
    }

    if ($price !== null) {
        // Coerce to float, stripping currency symbols if any
        $normalized = is_numeric($price)
            ? (float)$price
            : (float)preg_replace('/[^0-9.\-]/', '', (string)$price);

        $_SESSION['price'] = $normalized;
        $_SESSION['trigger'] = 'purchase';

        if (isset($_POST['bank'])) {
            $_SESSION['bank'] = $_POST['bank'];
        }

        // Ensure session data is flushed before redirect
        if (function_exists('session_write_close')) {
            session_write_close();
        }

        // Also pass price via query string to cover any session edge cases
        header('Location: CnfirmEmailToBuyW.php?wfprice=' . urlencode($normalized));
        exit();
    }
}

header('Location: dash.php');
exit();
?>
