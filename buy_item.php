<?php
session_start();

// Accept zero price and alternative field names; don't require item to be present
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $price = null;
    if (array_key_exists('price', $_POST)) {
        $price = $_POST['price'];
    } elseif (array_key_exists('amount', $_POST)) {
        $price = $_POST['amount'];
    }

    if ($price !== null) {
        $_SESSION['price'] = is_numeric($price) ? (float)$price : $price;
        $_SESSION['trigger'] = 'purchase';
        if (isset($_POST['item'])) {
            $_SESSION['item'] = $_POST['item'];
        }
        if (isset($_POST['bank'])) {
            $_SESSION['bank'] = $_POST['bank'];
        }
        header('Location: CnfirmEmailToBuyW.php');
        exit();
    }
}

header('Location: dash.php');
exit();
?>