<?php
/**
 * Admin Tools & Management
 * Replaces functionality of previous more.php
 */

// 1. Session & Configuration
session_start();
require_once "dbcon.php";

// Map $con to $conn for consistency
if (isset($con) && !isset($conn)) {
    $conn = $con;
}

// 2. Authentication Check
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Optional: Add Admin Check here if needed
// if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) { header("Location: dashboard.php"); exit(); }

// Handle Search
$search_query = "";
$sql_search_clause = "";
if (isset($_GET['search_user']) && !empty(trim($_GET['search_user']))) {
    $search_query = trim($_GET['search_user']);
    // Sanitize search input
    $safe_search = mysqli_real_escape_string($conn, $search_query);
    $sql_search_clause = " WHERE user LIKE '%$safe_search%' ";
}

// Handle View State
$view = isset($_GET['view']) ? $_GET['view'] : 'orders';
if (!in_array($view, ['orders', 'email', 'info'])) {
    $view = 'orders';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tools</title>
    <link rel="stylesheet" href="styleee.css">
    <style>
        /* Embedded critical styles to ensure visibility */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #0f172a; /* Dark background matches theme */
            color: #e2e8f0;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #1e293b;
        }
        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .btn-toggle {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 0.85em;
            text-decoration: none;
            display: inline-block;
        }
        .btn-toggle-active {
            background-color: #059669;
            color: #d1fae5;
        }
        .btn-toggle-inactive {
            background-color: #b91c1c;
            color: #fee2e2;
        }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            margin-top: 4px;
            border-radius: 6px;
            border: 1px solid #475569;
            background-color: #0f172a;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #334155;
        }
        th {
            background-color: #0f172a;
            color: #94a3b8;
        }
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        /* Menu Tabs */
        .admin-menu {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            border-bottom: 1px solid #334155;
            padding-bottom: 0;
        }
        .menu-item {
            padding: 12px 20px;
            color: #94a3b8;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            font-weight: 500;
            transition: all 0.2s;
        }
        .menu-item:hover {
            color: #e2e8f0;
            background: #1e293b;
        }
        .menu-item.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
            background: #1e293b;
        }
    </style>
</head>
<body>

    <div class="admin-container">
        <!-- Sidebar Inclusion -->
        <?php include 'adminSideBar.php'; ?>
        
        <!-- Main Content Area -->
        <div class="main-content">
            
            <header class="admin-header">
                <h1>Admin Tools</h1>
                <a class="logout-btn" href="LogOut.php" style="color:#f87171;text-decoration:none;">Logout</a>
            </header>

            <!-- Menu Navigation -->
            <div class="admin-menu">
                <a href="?view=orders" class="menu-item <?= $view === 'orders' ? 'active' : '' ?>">Manage Orders</a>
                <a href="?view=email" class="menu-item <?= $view === 'email' ? 'active' : '' ?>">Send Completion Email</a>
                <a href="?view=info" class="menu-item <?= $view === 'info' ? 'active' : '' ?>">Send Log Info</a>
            </div>

            <!-- Feedback Messages -->
            <?php if(isset($_GET['updated'])): ?>
                <div style="margin-bottom:20px;padding:15px;border-radius:6px;<?= $_GET['updated']=='1' ? 'background:#064e3b;color:#6ee7b7' : 'background:#7f1d1d;color:#fca5a5' ?>">
                    <?= $_GET['updated']=='1' ? 'Order status updated successfully!' : 'Failed to update order status.' ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['mail_sent']) && $_GET['mail_sent'] == '1'): ?>
                <div style="margin-bottom:20px;padding:15px;border-radius:6px;background:#064e3b;color:#6ee7b7">
                    Email sent successfully!
                </div>
            <?php endif; ?>

            <!-- Recent Orders Table with Search -->
            <?php if ($view === 'orders'): ?>
            <div class="card">
                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:15px;margin-bottom:15px;">
                    <h2 style="margin:0;">Manage Orders</h2>
                    
                    <!-- Search Form -->
                    <form method="get" action="admin_tools.php" class="search-box">
                        <input type="hidden" name="view" value="orders">
                        <input type="text" name="search_user" class="form-control" placeholder="Search by username..." value="<?= htmlspecialchars($search_query) ?>" style="width:250px;margin-top:0;">
                        <button type="submit" class="btn-primary">Search</button>
                        <?php if(!empty($search_query)): ?>
                            <a href="admin_tools.php?view=orders" style="color:#94a3b8;align-self:center;text-decoration:underline;margin-left:5px;">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Info</th>
                                <th>Status (Click to Toggle)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Limit to 50 if not searching, otherwise show all matches
                            $limit_clause = empty($sql_search_clause) ? " LIMIT 50" : "";
                            $query = "SELECT id, date, Info, is_active, user FROM history $sql_search_clause ORDER BY id DESC $limit_clause";
                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $isActive = (int)$row['is_active'];
                                    ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars($row['id']) ?></td>
                                        <td style="font-weight:bold;color:#fff;"><?= htmlspecialchars($row['user']) ?></td>
                                        <td><?= htmlspecialchars($row['date']) ?></td>
                                        <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            <?= htmlspecialchars($row['Info']) ?>
                                        </td>
                                        <td>
                                            <!-- Inline Toggle Form -->
                                            <form method="post" action="update_order_status.php" style="margin:0;">
                                                <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="order_status" value="<?= $isActive === 1 ? 'cancelled' : 'pending' ?>">
                                                
                                                <button type="submit" class="btn-toggle <?= $isActive === 1 ? 'btn-toggle-active' : 'btn-toggle-inactive' ?>" title="Click to toggle status">
                                                    <?= $isActive === 1 ? 'Active (ON)' : 'Inactive (OFF)' ?>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='5' style='text-align:center;padding:20px;color:#94a3b8;'>No orders found matching your criteria.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Send Completion Email Section -->
            <?php if ($view === 'email'): ?>
            <div class="card" id="send-email">
                <h2>Send Completion Email</h2>
                <form method="post" action="send.php">
                    <input type="hidden" name="notify_complete" value="1">
                    <input type="hidden" name="submit" value="1">
                    
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:15px;">
                        <div>
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div>
                            <label>Amount (Optional)</label>
                            <input type="number" step="0.01" name="wfprice" class="form-control">
                        </div>
                    </div>

                    <div style="margin-bottom:15px;">
                        <label>Bank / Order Info</label>
                        <input type="text" name="dw" class="form-control">
                    </div>

                    <div style="margin-bottom:15px;">
                        <label>Recipient Email</label>
                        <input type="email" name="to_email" class="form-control">
                    </div>

                    <div style="margin-bottom:15px;">
                        <label>Custom Message</label>
                        <textarea name="custom_message" rows="4" class="form-control">Hello,

We’re happy to let you know that your transaction has been completed successfully.</textarea>
                    </div>

                    <div style="text-align:right;">
                        <button type="submit" class="btn-primary">Send Notification</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <!-- Send Log Info Section -->
            <?php if ($view === 'info'): ?>
            <div class="card" id="send-info">
                <h2>Send Log Information</h2>
                <p style="color:#94a3b8;margin-bottom:20px;">Send a specific bank log information template to a user.</p>
                
                <form method="post" action="send_log.php">
                    <input type="hidden" name="send_info" value="1">
                    
                    <div style="margin-bottom:15px;">
                        <label>Recipient Email (Admin's Choice)</label>
                        <input type="email" name="recipient_email" class="form-control" required placeholder="e.g. user@example.com">
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:15px;">
                        <div>
                            <label>Bank Name (Header)</label>
                            <input type="text" name="bank_name" class="form-control" value="CHASE BANKLOG" required>
                        </div>
                        <div>
                            <label>Balance</label>
                            <input type="text" name="balance" class="form-control" value="$10,219.11" required>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:15px;">
                        <div>
                            <label>Bank Info (Name in Details)</label>
                            <input type="text" name="bank_info" class="form-control" value="RBS CITIZENS, N.A." required>
                        </div>
                        <div>
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" value="United States of America" required>
                        </div>
                    </div>

                    <div style="background:#0f172a;padding:15px;border-radius:6px;margin-bottom:20px;border:1px solid #334155;">
                        <h4 style="margin-top:0;color:#94a3b8;">Template Preview (Static Data):</h4>
                        <pre style="font-size:12px;color:#cbd5e1;overflow-x:auto;">
UserName : stacieNan03
Password : Lillipie1
-- EMAIL INFO --
Email: stacie22556@yahoo.com
...
(Date of Session will be automatically set to: <?= date('d-m-Y H:i:s') ?>)
                        </pre>
                    </div>

                    <div style="text-align:right;">
                        <button type="submit" class="btn-primary">Send Log Info</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>