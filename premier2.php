<?php

if (!isset($_GET['username']))
{
      header('Location: logIn.php');
}
else{
    $username = $_GET['username'];
    $url = "balance.php?username=".$username;  
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>LEGITBANKLOGZ</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="premier2.css">
            
        
    </head>
    <body>
        <header id="header" class="page-header">
            <div class="title">
                <h1>LEGITBANKLOGZ</h1>
                <h4>Logged in as:<?=$username ?></h4>
              
            </div>
        </header>
        <nav class="menu" id="main-menu">
            <button class="menu-toggle" id="toggle-menu">toggle menu</button>
           <div class="menu-dropdown">
            <ul class="nav-menu">
                <li><a href="index.html">HOME</a></li>
                <li><a href="history2.php?username=<?=$username?>">History</a></li>
                <li><a href="#"> <div data-i18n="Basic">Balance:  <?php require_once 'premiumConekt.php';
                           

                             
                           $username= $_GET["username"];
                       if ($conn->connect_error) die("Fatal Error");
                           $query = "SELECT * FROM  user WHERE UserName='$username'";
                           $query_run = mysqli_query($conn, $query);
                           if(mysqli_num_rows($query_run) > 0)
                           {
                               $balance = mysqli_fetch_array($query_run);
                           }
                               ?>
                               $<?= $balance['Balance']; ?>.00
                               

                       </div></a></li>
                <li><a href="Addbalance.php?username=<?=$username?>">Top Up</a></li>
            </ul>
           </div>
        </nav>
        <div class="gallery">
            <div class="content">
                <img src="bank.jpg">
                <h3>Bank LOGS</h3>
                <p>US, UK and CAN bank logs available</p>
                <a href="logb.php?username=<?=$username?>">VIEW LOGS</a>
            </div>
        
                  
            <div class="content">
                <img src="leo.png ">
                <h3>CashApp Logs</h3>
                <p>Bitcoin Enabled cashapp logs available</p>
                <a href="leo.php?username=<?=$username?>">VIEW LOGS</a>
      
        </div>
        
            <div class="content">
                <img src="ly.png">
                <h3>PayPal Logs</h3>
                <p>International paypal logs available</p>
                <a href="ly.php?username=<?=$username?>">VIEW LOGS</a>
        
        </div>
       
            <div class="content">
                <img src="qye.jpg">
                <h3>Crypto Logs</h3>
                <p>Binance and Coin Base Logs available </p>
                <a href="qye.php?username=<?=$username?>">VIEW LOGS</a>
        </div>

        </div>
        <section class="column">
            <h2 class="subtitle">Need help learning how to cashout logs?</h2>
            <p>If you’re looking for a reliable channel on telegram with the latest methods, tips and tricks as well as private tutoring then join us on telegram</p>
            <a href="https://t.me/+yZevxLhRip5hOGM0" target="_blank" class="tele" role="button">
                <i aria-hidden="true" class="fab fa-telegram-plane"></i>			</span>
						<span class="element">Join our starters channel</span>
        </section>
        <footer>
            <div class="ast-footer-copyright">
                <p>Copyright © 2016 LEGITBANKLOGZ</p>
            </div>
            <div class="ast-builder-html-element">
                <p>Powered by LEGITBANKLOGZ</p>
            </div>
        </footer>
 
        <script type="text/javascript">
            (function () {
            var button = document.getElementById('toggle-menu');
            button.addEventListener('click', function(event) {
            event.preventDefault();
            var menu = document.getElementById('main-menu');
            menu.classList.toggle('is-open');
            });
            })();
            </script>
    </body>
</html>