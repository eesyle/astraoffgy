<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['username']))
{
 
}
else{
    $username = $_SESSION['username'];
     
}

$bbalance = $_SESSION['balance'];
$bbank = $_SESSION['bankname'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> infos</title>
    <style>
        body {
            background: #1b1b1b;
            font-family: 'Roboto', sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 20px; /* Allow some space on the sides */
        }

        p {
            background: linear-gradient(135deg, #00ffcc, #ff00cc);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            color: #fff;
            font-size: 1.2rem;
            width: 100%; /* Take full width of container */
            max-width: 700px; /* Limit width for readability */
            text-align: justify; /* Ensures neat text alignment */
            margin-top: 800px;
            word-wrap: break-word; /* Handle long words properly */
            overflow-wrap: break-word; /* Ensure long words wrap */
            line-height: 1.6; /* Adjust line height for readability */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        p:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
        }

        p::before {
            content: "";
            display: block;
            height: 4px;
            width: 50px;
            background: #fff;
            margin: 0 auto 10px;
        }

        p::after {
            content: ">>>";
            display: block;
            color: #00ffcc;
            font-weight: bold;
            margin-top: 10px;
            font-size: 1.5rem;
            text-align: right;
        }

        @media screen and (max-width: 768px) {
            p {
                font-size: 1rem;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <p>
    ------------- ❇🔷-- <?php echo $bbank ?> --❇🔷 ------------ <br>
        Balance: $<?php echo $bbalance ?> <br>
        UserName         : 2258s  <br>
        Password         : Lillipie1 <br>
        Account Number: 619773479 <br>
        Routing Number: 021202337 <br>
        |--------------- SECURITY Q & A ----------------| <br>
        Q1            : In what city was your high school? <br>
        Ans1          : Alva <br>
        Q2            : What was the name of your first pet? <br>
        Ans2          : Gretchen <br>
        Q3            : What is your paternal grandfather's name? <br>
        Ans3          : Perry <br>
        |------------------- EMAIL INFO ----------------|  <br>
        Email            : alva22556@yahoo.com <br>
        Email Password   : Lillipie22/ <br>
        |------------------- Fullz INFO ----------------| <br>
        Fullname         : Stacie Nan Jones      <br>
        DOB              : 02/25/1956     <br>
        SSN              : 443-66-3420 <br>
        MMN              : Hill <br>
        DL               : 22939358 <br>
        Street Address   : 119 Hawes Dr <br>
        City             : Greensburg        <br>   
        State            : Pa    <br>
        Zip/Postal Code  : 15601    <br>
        Phone Number     : (412) 610-0441  <br>
        |------------------ CARD DETAILS -----------------|  <br>
        Bank Info        : RBS CITIZENS, N.A. | United States of America   <br>
        Type             : VISA - DEBIT   <br>
        Level            : TRADITIONAL  <br>
        Name On Card     : Stacie Nan Jones  <br>
        Card Number      : 4427910040006907  <br>
        Expiry date      : 10/27  <br>
        CVV              : 882 <br>
        ATM PIN          : 2258
    </p>
 

</body>
</html>
