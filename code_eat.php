<?php
require 'dbcon.php';

if (isset($_POST['delete_student'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['delete_student']);

    $query = "DELETE FROM m_t WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        header("Location: eat_index.php");
        exit(0);
    } else {
        echo "Error deleting student: " . mysqli_error($con);
        header("Location: eat_index.php");
        exit(0);
    }
}

if (isset($_POST['update_student'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $balance = mysqli_real_escape_string($con, $_POST['Balance']);
    $title = mysqli_real_escape_string($con, $_POST['Title']);
    $info = mysqli_real_escape_string($con, $_POST['info']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

    $query = "UPDATE m_t SET  id = '$id', Balance='$balance', Title='$title', info='$info', price='$price' WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        header("Location: eat_index.php");
        exit(0);
    } else {
        echo "Error updating student: " . mysqli_error($con);
        header("Location: eat_index.php");
        exit(0);
    }
}

if (isset($_POST['save_student'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $balance = mysqli_real_escape_string($con, $_POST['Balance']);
    $title = mysqli_real_escape_string($con, $_POST['Title']);
    $info = mysqli_real_escape_string($con, $_POST['info']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

    $query = "INSERT INTO  m_t VALUES ('$id','$balance','$title','$info','$price')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        header("Location: create_eat.php");
        exit(0);
    } else {
        echo "Error saving student: " . mysqli_error($con);
        header("Location: create_eat.php");
        exit(0);
    }
}
?>
