<?php
if (!isset($_GET['username']))
{
     echo "Invalid username";
}
$username = $_GET['username'];
?>

<li class="menu-item py-1">
                <a href="#" class="menu-link">
                    <div data-i18n="Basic">Logged in as <?=$username ?></div>
                </a>
            </li>


<li class="menu-item py-1">
                        <a href="#" class="menu-link">
                            <div data-i18n="Basic">Balance:  <?php require_once 'conkt.php';
                           

                             
                            $username= $_GET["username"];
                        if ($conn->connect_error) die("Fatal Error");
                            $query = "SELECT * FROM  users WHERE UserName='$username'";
                            $query_run = mysqli_query($conn, $query);
                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $balance = mysqli_fetch_array($query_run);
                            }
                                ?>
                                $<?= $balance['Balance']; ?>.00
                                

                        </div>
                        </a>
                    </li>