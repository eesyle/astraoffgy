<?php
session_start();
require 'dbcon.php';

if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['delete_student']);

    $query = "DELETE FROM  users WHERE ID='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Account Deleted Successfully";
        header("Location: AddBalanceToAuser.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Deleted";
        header("Location: AddBalanceToAuser.php");
        exit(0);
    }
}

if(isset($_POST['update_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $Email = mysqli_real_escape_string($con, $_POST['email']);
    $UserName = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $Date = mysqli_real_escape_string($con, $_POST['Date']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $balance = mysqli_real_escape_string($con, $_POST['balance']);
    $stcomplete = mysqli_real_escape_string($con, $_POST['stcomplete']);

    $query = "UPDATE  users SET Email='$Email', UserName='$UserName', PassWord='$password', price='$price',Balance='$balance',statusComplete = '$stcomplete' WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Account Updated Successfully";
        header("Location:  AddBalanceToAuser.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Updated";
        header("Location:  AddBalanceToAuser.php");
        exit(0);
    }

}


?>