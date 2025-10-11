<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['price'])) {
    $_SESSION['price'] = $_POST['price'];
    $_SESSION['trigger']= "purchase";
    header('Location: CnfirmEmailToBuyW.php');  
    exit();
} else {
    header('Location: dash.php');
    exit();
}
?>
