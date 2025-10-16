<?php

$con = mysqli_connect("localhost","root","","astraoffgy");

if(!$con){
    die('Connection Failed'. mysqli_connect_error());
}