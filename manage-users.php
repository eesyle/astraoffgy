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
                <h1>Manage Users</h1>
                <button class="logout-btn">Logout</button>
            </header>

            <!-- Manage Banks Content -->
            <section class="content-section">
                <h2>Users Management Section</h2>
                <ul class="bank-list">
                <li>
        <span><a href="AddBalanceToAuser">Edit users</a></span>
    </li>
                    
                </ul>
            </section>
        </div>
    </div>
</body>
</html>
