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
                <h1>Manage Others</h1>
                <button class="logout-btn">Logout</button>
            </header>

            <!-- Manage Banks Content -->
            <section class="content-section">
                <h2>Miscellaneous Management Section</h2>
                <ul class="bank-list">
                <li>
         <a href="send" >Send status complete email</a> 
    </li>
    
    <li>
         <a href="vouches" >Vouches</a> 
    </li>

    <li>
        <span><a href="orders_index" >EDIT orders</a></span>
    </li>

    <li>
        <span><a href="manage-review" >Manage reviews</a></span>
    </li>
                </ul>
            </section>
        </div>
    </div>
</body>
</html>
