<?php
session_start();
if (isset($_GET['price'])) {
    $_SESSION['price'] = $_GET['price'];
    $_SESSION['triger'] = "card";
    header('location: paymentMethod.php');
    exit();
}
?>