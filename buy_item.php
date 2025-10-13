<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['price']) && isset($_POST['item'])) {
    $_SESSION['price'] = $_POST['price'];
    $_SESSION['trigger'] = 'purchase';
    $_SESSION['item'] = $_POST['item'];
    if (isset($_POST['bank'])) {
        $_SESSION['bank'] = $_POST['bank'];
    }
    header('Location: CnfirmEmailToBuyW.php');
    exit();
} else {
    header('Location: dash.php');
    exit();
}
?>