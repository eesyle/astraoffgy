<?php
session_start();
include 'config.php';
if (isset($_SESSION['trigger'])&& isset($_POST['submit1'])) {
    $trigger = $_SESSION['trigger'];
    echo $trigger;
    header('location: topb.php');
    exit();

}else if  (isset($_SESSION['trigger'])&& isset($_POST['submit2'])) {


    header('location: tops.php');
    exit();
}


 
?>