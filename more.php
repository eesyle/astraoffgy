<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<!-- Debug: Page Start -->";

// Include configuration and authentication logic FIRST
// This ensures sessions are started before headers are sent and $conn is available
echo "<!-- Debug: Including codeForOther.php -->";
require_once 'codeForOther.php';
echo "<!-- Debug: codeForOther.php included. Checking DB connection... -->";

if (isset($conn)) {
    if ($conn->connect_error) {
        echo "<!-- Debug: Connection Error: " . htmlspecialchars($conn->connect_error) . " -->";
    } else {
        echo "<!-- Debug: Connection Successful -->";
    }
} else {
    echo "<!-- Debug: \$conn variable is NOT set! -->";
}

if (isset($_SESSION)) {
    echo "<!-- Debug: Session is active. User: " . (isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'None') . " -->";
} else {
    echo "<!-- Debug: Session NOT active -->";
}
?>
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
                <a class="logout-btn" href="LogOut.php">Logout</a>
            </header>

            <!-- Management Menu -->
            <section class="content-section">
                <!-- codeForOther.php was moved to top -->
                <h2>Management Menu</h2>
                <ul class="bank-list" style="display:flex;gap:12px;list-style:none;padding:0;margin:0 0 16px 0">
                    <li><a href="#edit-orders" style="display:inline-block;padding:8px 12px;border-radius:6px;background:#162032;color:#e5e7eb;text-decoration:none">Edit Orders</a></li>
                    <li><a href="#send-complete" style="display:inline-block;padding:8px 12px;border-radius:6px;background:#162032;color:#e5e7eb;text-decoration:none">Send Status Complete Email</a></li>
                </ul>

                <!-- Edit Orders Section -->
                <div id="edit-orders" class="edit-order-card" style="margin-top:20px;padding:16px;border:1px solid #333;border-radius:10px;background:#1f2a38;color:#e5e7eb">
                    <h3 style="margin-top:0">Edit Order Status</h3>
                    <p style="margin-bottom:12px">Update an order's status by toggling <code>is_active</code> in the history table.</p>
                    <form method="post" action="update_order_status.php" class="edit-order-form" style="display:grid;grid-template-columns:1fr 1fr auto;gap:12px;align-items:end">
                        <div>
                            <label for="order_id" style="display:block;margin-bottom:6px">Order ID (#O-ID)</label>
                            <input type="number" id="order_id" name="order_id" class="form-control" placeholder="Enter order id" required />
                        </div>
                        <div>
                            <label for="order_status" style="display:block;margin-bottom:6px">Status</label>
                            <select id="order_status" name="order_status" class="form-control" required>
                                <option value="pending">Pending (is_active = 1)</option>
                                <option value="cancelled">Cancelled (is_active = 0)</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                    <?php if(isset($_GET['updated']) && $_GET['updated'] === '1'): ?>
                        <div class="alert" style="margin-top:12px;padding:10px;border-radius:8px;background:#103b19;color:#bbf7d0">Order status updated successfully.</div>
                    <?php elseif(isset($_GET['updated']) && $_GET['updated'] === '0'): ?>
                        <div class="alert" style="margin-top:12px;padding:10px;border-radius:8px;background:#3b0f0f;color:#fecaca">Failed to update order status.</div>
                    <?php endif; ?>
                </div>
                
                <!-- Orders and History: Inline is_active editor -->
                <div class="orders-card" style="margin-top:24px;padding:16px;border:1px solid #333;border-radius:10px;background:#101622;color:#e5e7eb">
                    <h3 style="margin-top:0;margin-bottom:12px">Orders and History (history table)</h3>
                    <div class="table-wrap" style="overflow:auto;border-radius:8px">
                        <table style="width:100%;border-collapse:collapse">
                            <thead>
                                <tr style="background:#162032;color:#9ca3af">
                                    <th style="text-align:left;padding:10px;border-bottom:1px solid #2b3b55">#O-ID</th>
                                    <th style="text-align:left;padding:10px;border-bottom:1px solid #2b3b55">Date</th>
                                    <th style="text-align:left;padding:10px;border-bottom:1px solid #2b3b55">Info</th>
                                    <th style="text-align:left;padding:10px;border-bottom:1px solid #2b3b55">is_active</th>
                                    <th style="text-align:left;padding:10px;border-bottom:1px solid #2b3b55">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($conn) && !$conn->connect_error) {
                                    $sql = "SELECT id, date, Info, is_active FROM history ORDER BY id DESC";
                                    $res = mysqli_query($conn, $sql);
                                    if ($res && mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $oid = (int)$row['id'];
                                            $dt = isset($row['date']) ? $row['date'] : '';
                                            $info = isset($row['Info']) ? $row['Info'] : '';
                                            $isActiveVal = isset($row['is_active']) ? (int)$row['is_active'] : 0;
                                            ?>
                                            <tr style="border-bottom:1px solid #2b3b55">
                                                <td style="padding:10px"><?= htmlspecialchars($oid) ?></td>
                                                <td style="padding:10px"><?= htmlspecialchars($dt) ?></td>
                                                <td style="padding:10px;max-width:420px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($info) ?></td>
                                                <td style="padding:10px">
                                                    <?php if ($isActiveVal === 1): ?>
                                                        <span style="display:inline-block;padding:4px 8px;border-radius:999px;background:#103b19;color:#bbf7d0">Active (1)</span>
                                                    <?php else: ?>
                                                        <span style="display:inline-block;padding:4px 8px;border-radius:999px;background:#3b0f0f;color:#fecaca">Inactive (0)</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="padding:10px">
                                                    <form method="post" action="update_order_status.php" style="display:flex;gap:8px;align-items:center">
                                                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($oid) ?>" />
                                                        <select name="is_active" style="padding:6px 10px;border-radius:6px;background:#0f172a;color:#e5e7eb;border:1px solid #334155">
                                                            <option value="1" <?= $isActiveVal === 1 ? 'selected' : '' ?>>Set Active (1)</option>
                                                            <option value="0" <?= $isActiveVal === 0 ? 'selected' : '' ?>>Set Inactive (0)</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary" style="padding:6px 12px;border-radius:6px;background:#2563eb;color:#fff;border:none">Update</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="5" style="padding:12px">No orders found in history.</td></tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5" style="padding:12px">Database connection not available.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Send Status Complete Email Section -->
                <div id="send-complete" class="notify-complete-card" style="margin-top:24px;padding:16px;border:1px solid #333;border-radius:10px;background:#0f172a;color:#e5e7eb">
                    <h3 style="margin-top:0;margin-bottom:12px">Send Status Complete Email</h3>
                    <p style="margin-bottom:12px">Notify a user that their transaction is complete. You can customize the message below.</p>
                    <form method="post" action="send.php" style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px">
                        <input type="hidden" name="submit" value="1" />
                        <input type="hidden" name="notify_complete" value="1" />
                        <div style="grid-column:span 1">
                            <label for="username" style="display:block;margin-bottom:6px">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required />
                        </div>
                        <div style="grid-column:span 1">
                            <label for="wfprice" style="display:block;margin-bottom:6px">Amount (optional)</label>
                            <input type="number" id="wfprice" name="wfprice" class="form-control" placeholder="e.g. 120" step="0.01" min="0" />
                        </div>
                        <div style="grid-column:span 2">
                            <label for="dw" style="display:block;margin-bottom:6px">Order / Bank Info (optional)</label>
                            <input type="text" id="dw" name="dw" class="form-control" placeholder="e.g. Woodforest Bank" />
                        </div>
                        <div style="grid-column:span 2">
                            <label for="to_email" style="display:block;margin-bottom:6px">Recipient Email (optional)</label>
                            <input type="email" id="to_email" name="to_email" class="form-control" placeholder="e.g. user@example.com" />
                        </div>
                        <div style="grid-column:span 2">
                            <label for="custom_message" style="display:block;margin-bottom:6px">Custom Message</label>
                            <textarea id="custom_message" name="custom_message" rows="5" class="form-control" placeholder="Add your note to the user (optional)">Hello,

We’re happy to let you know that your transaction has been completed successfully.

 .</textarea>
                        </div>
                        <div style="grid-column:span 2;text-align:right">
                            <button type="submit" class="btn btn-primary" style="padding:8px 14px;border-radius:6px;background:#2563eb;color:#fff;border:none">Send Email</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
