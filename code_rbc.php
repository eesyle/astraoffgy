<?php
session_start();
require 'dbcon.php';

if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['delete_student']);

    $query = "DELETE FROM rbc WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Account Deleted Successfully";
        header("Location: rbc_index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Deleted";
        header("Location:  rbc_index.php");
        exit(0);
    }
}

if(isset($_POST['update_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $balance = mysqli_real_escape_string($con, $_POST['Balance']);
    $info = mysqli_real_escape_string($con, $_POST['info']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

    $query = "UPDATE rbc SET id = '$id', balance='$balance', info='$info', price='$price' WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Account Updated Successfully";
        header("Location: rbc_index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Updated";
        header("Location:  rbc_index.php");
        exit(0);
    }

}


if(isset($_POST['save_student']))
{
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $balance = mysqli_real_escape_string($con, $_POST['Balance']);
    $info = mysqli_real_escape_string($con, $_POST['info']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

    $query = "INSERT INTO rbc (id, balance, info, price) VALUES".
"('$id','$balance','$info','$price')";
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = " Account Created Successfully";
        header("Location: create_rbc.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Created";
        header("Location:create_rbc.php");
        exit(0);
    }
}

?>