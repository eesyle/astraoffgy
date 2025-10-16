<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management</title>
    <link rel="stylesheet" href="styleee.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
       
            <?php include 'adminSideBar.php'; ?>
        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Manage Cards</h1>
                <a class="logout-btn" href="LogOut.php">Logout</a>
            </header>

            <!-- Manage Banks Content -->
            <section class="content-section">
                <h2>Card Management Section</h2>
                <ul class="bank-list">
                <li>
         <a href="card1_index" >EDIT CARD1 Bank</a> 
    
     <li>
    <a href="card2_index" >EDIT CARD2 Bank</a> 
    
     <li>
        <a href="card3_index" >EDIT CARD3 Bank</a> 
    </li>
    
     <li>
       <a href="card4_index" >EDIT CARD4 Bank</a> 
                </ul>
            </section>
        </div>
    </div>
</body>
</html>
