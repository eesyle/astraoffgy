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
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.85em;
        }
        .status-active { background: #064e3b; color: #6ee7b7; }
        .status-inactive { background: #7f1d1d; color: #fca5a5; }
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

            <!-- 1. Edit Order Status Section -->
            <div class="card" id="edit-orders">
                <h2>Update Order Status</h2>
                <p style="color:#94a3b8;margin-bottom:15px;">Manually update an order's active status.</p>
                
                <form method="post" action="update_order_status.php" style="display:flex;gap:15px;align-items:flex-end;flex-wrap:wrap;">
                    <div style="flex:1;min-width:200px;">
                        <label>Order ID (#O-ID)</label>
                        <input type="number" name="order_id" class="form-control" placeholder="e.g. 15" required>
                    </div>
                    <div style="flex:1;min-width:200px;">
                        <label>New Status</label>
                        <select name="order_status" class="form-control">
                            <option value="pending">Active (1)</option>
                            <option value="cancelled">Inactive (0)</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn-primary">Update Status</button>
                    </div>
                </form>

                <!-- Feedback Messages -->
                <?php if(isset($_GET['updated'])): ?>
                    <div style="margin-top:15px;padding:10px;border-radius:6px;<?= $_GET['updated']=='1' ? 'background:#064e3b;color:#6ee7b7' : 'background:#7f1d1d;color:#fca5a5' ?>">
                        <?= $_GET['updated']=='1' ? 'Order updated successfully!' : 'Failed to update order.' ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 2. Recent Orders Table -->
            <div class="card">
                <h2>Recent History</h2>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Date</th>
                                <th>Info</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT id, date, Info, is_active FROM history ORDER BY id DESC LIMIT 50";
                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $isActive = (int)$row['is_active'];
                                    ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['date']) ?></td>
                                        <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            <?= htmlspecialchars($row['Info']) ?>
                                        </td>
                                        <td>
                                            <?php if($isActive === 1): ?>
                                                <span class="status-badge status-active">Active</span>
                                            <?php else: ?>
                                                <span class="status-badge status-inactive">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form method="post" action="update_order_status.php" style="display:inline;">
                                                <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="order_status" value="<?= $isActive === 1 ? 'cancelled' : 'pending' ?>">
                                                <button type="submit" style="background:none;border:none;color:#60a5fa;cursor:pointer;text-decoration:underline;">
                                                    Toggle
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='5'>No history found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Send Completion Email Section -->
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

        </div>
    </div>

</body>
</html>