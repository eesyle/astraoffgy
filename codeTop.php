<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['price'])) {
    $_SESSION['price'] = $_POST['price'];
    $_SESSION['trigger']= "top";
    header('Location: paymentMethod.php');  
    exit();
} else {
    header('Location: dash.php');
    exit();
}
?>