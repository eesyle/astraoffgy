<?php
require_once 'auth_guard.php';
require_once 'codeForOther.php';

// Handle Form Submission
$message = '';
$previewData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $tables = isset($_POST['tables']) ? $_POST['tables'] : [];
    $minBal = floatval($_POST['min_bal'] ?? 100);
    $maxBal = floatval($_POST['max_bal'] ?? 1000);
    $minPrice = floatval($_POST['min_price'] ?? 10);
    $maxPrice = floatval($_POST['max_price'] ?? 100);
    $strategy = $_POST['strategy'] ?? 'random'; // random, correlated, target
    $targetPrice = floatval($_POST['target_price'] ?? 0);

    if (empty($tables)) {
        $message = "Please select at least one card table.";
    } else {
        if ($action === 'preview') {
            // Generate preview data (in memory)
            for ($i = 0; $i < 10; $i++) {
                $simBal = rand($minBal, $maxBal);
                $simPrice = 0;
                
                if ($strategy === 'correlated') {
                    // Linear interpolation + noise
                    $ratio = ($simBal - $minBal) / ($maxBal - $minBal);
                    $basePrice = $minPrice + ($ratio * ($maxPrice - $minPrice));
                    $noise = rand(-5, 5); // +/- $5
                    $simPrice = max($minPrice, min($maxPrice, $basePrice + $noise));
                } elseif ($strategy === 'target') {
                     // Around target price, clamped
                     $noise = rand(-10, 10);
                     $simPrice = max($minPrice, min($maxPrice, $targetPrice + $noise));
                } else {
                    // Pure random
                    $simPrice = rand($minPrice, $maxPrice);
                }
                
                $previewData[] = [
                    'balance' => $simBal,
                    'price' => floor($simPrice)
                ];
            }
            $message = "Preview generated based on your settings.";
        } elseif ($action === 'update') {
            foreach ($tables as $table) {
                // We need to update every row.
                // Since SQL RAND() is executed per row, we can use it.
                
                if ($strategy === 'correlated') {
                    // Complex logic is hard in single SQL query without stored procedures or messy math.
                    // Easier: Fetch IDs, generate values in PHP, update in batches.
                    // Or use SQL math: 
                    // Price = MinP + ((Bal - MinB) / (MaxB - MinB)) * (MaxP - MinP)
                    
                    $sql = "UPDATE $table SET 
                            Balance = FLOOR($minBal + (RAND() * ($maxBal - $minBal))),
                            price = CASE 
                                WHEN ($maxBal - $minBal) = 0 THEN $minPrice
                                ELSE 
                                    FLOOR(
                                        $minPrice + 
                                        ((Balance - $minBal) / ($maxBal - $minBal)) * ($maxPrice - $minPrice) + 
                                        (RAND() * 10 - 5)
                                    )
                                END";
                     // Clamp price logic in SQL is verbose, let's trust the math or add LEAST/GREATEST
                     $sql = "UPDATE $table SET 
                            Balance = FLOOR($minBal + (RAND() * ($maxBal - $minBal))),
                            price = GREATEST($minPrice, LEAST($maxPrice, FLOOR(
                                $minPrice + 
                                ((($minBal + (RAND() * ($maxBal - $minBal))) - $minBal) / NULLIF($maxBal - $minBal, 0)) * ($maxPrice - $minPrice) + 
                                (RAND() * 10 - 5)
                            )))";
                     // Actually, we can refer to the new Balance value? No, MySQL uses the OLD value in the same UPDATE clause usually, 
                     // OR we can't guarantee order. 
                     // SAFEST: Update Balance first, then Price.
                     
                     $conn->query("UPDATE $table SET Balance = FLOOR($minBal + (RAND() * ($maxBal - $minBal)))");
                     $conn->query("UPDATE $table SET price = GREATEST($minPrice, LEAST($maxPrice, FLOOR(
                                        $minPrice + 
                                        ((Balance - $minBal) / NULLIF($maxBal - $minBal, 1)) * ($maxPrice - $minPrice) + 
                                        (RAND() * 10 - 5)
                                    )))");

                } elseif ($strategy === 'target') {
                    $conn->query("UPDATE $table SET 
                                  Balance = FLOOR($minBal + (RAND() * ($maxBal - $minBal))),
                                  price = GREATEST($minPrice, LEAST($maxPrice, FLOOR($targetPrice + (RAND() * 20 - 10))))");
                } else {
                    $conn->query("UPDATE $table SET 
                                  Balance = FLOOR($minBal + (RAND() * ($maxBal - $minBal))),
                                  price = FLOOR($minPrice + (RAND() * ($maxPrice - $minPrice)))");
                }
            }
            $message = "Successfully updated " . count($tables) . " tables.";
        }
    }
}

// Fetch current stats
$stats = [];
foreach (['card1', 'card2', 'card3', 'card4'] as $t) {
    $res = $conn->query("SELECT COUNT(*) as c, MIN(Balance) as min_b, MAX(Balance) as max_b, AVG(price) as avg_p FROM $t");
    if ($res) {
        $stats[$t] = $res->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cards - Admin</title>
    <link rel="stylesheet" href="styleee.css">
    <style>
        .form-group { margin-bottom: 15px; }
        .form-control { width: 100%; padding: 10px; border-radius: 8px; background: rgba(0,0,0,0.3); border: 1px solid #444; color: #fff; }
        .btn-action { padding: 10px 20px; border-radius: 8px; cursor: pointer; border: none; font-weight: bold; }
        .btn-preview { background: #3498db; color: white; }
        .btn-save { background: #27ae60; color: white; }
        .stat-box { background: rgba(255,255,255,0.05); padding: 10px; border-radius: 8px; margin-bottom: 10px; }
        .preview-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .preview-table th, .preview-table td { padding: 10px; border: 1px solid #444; text-align: left; }
        .checkbox-group { display: flex; gap: 15px; flex-wrap: wrap; }
        .strategy-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .strategy-card.active {
            border-color: #3498db;
            background: rgba(52, 152, 219, 0.1);
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include 'adminSideBar.php'; ?>
        
        <div class="main-content">
            <header class="admin-header">
                <h1>Manage Cards (Bulk Update)</h1>
                <a class="logout-btn" href="LogOut.php">Logout</a>
            </header>

            <?php if ($message): ?>
                <div style="background: rgba(52, 152, 219, 0.2); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #3498db;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="content-section">
                <h2>Current Card Statistics</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <?php foreach ($stats as $table => $data): ?>
                    <div class="stat-box">
                        <h3 style="margin-bottom: 5px; text-transform: uppercase;"><?php echo $table; ?></h3>
                        <small>Rows: <?php echo $data['c']; ?></small><br>
                        <small>Bal: $<?php echo number_format($data['min_b']); ?> - $<?php echo number_format($data['max_b']); ?></small><br>
                        <small>Avg Price: $<?php echo number_format($data['avg_p'], 2); ?></small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <form method="POST" action="">
                <div class="content-section">
                    <h2>1. Select Tables to Update</h2>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="tables[]" value="card1" checked> Card 1</label>
                        <label><input type="checkbox" name="tables[]" value="card2" checked> Card 2</label>
                        <label><input type="checkbox" name="tables[]" value="card3" checked> Card 3</label>
                        <label><input type="checkbox" name="tables[]" value="card4" checked> Card 4</label>
                    </div>
                </div>

                <div class="content-section">
                    <h2>2. Configure Values</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <h3>Balance Range</h3>
                            <div class="form-group">
                                <label>Minimum Balance ($)</label>
                                <input type="number" name="min_bal" class="form-control" value="<?php echo $_POST['min_bal'] ?? 500; ?>">
                            </div>
                            <div class="form-group">
                                <label>Maximum Balance ($)</label>
                                <input type="number" name="max_bal" class="form-control" value="<?php echo $_POST['max_bal'] ?? 5000; ?>">
                            </div>
                        </div>
                        <div>
                            <h3>Price Range</h3>
                            <div class="form-group">
                                <label>Minimum Price ($)</label>
                                <input type="number" name="min_price" class="form-control" value="<?php echo $_POST['min_price'] ?? 50; ?>">
                            </div>
                            <div class="form-group">
                                <label>Maximum Price ($)</label>
                                <input type="number" name="max_price" class="form-control" value="<?php echo $_POST['max_price'] ?? 500; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-section">
                    <h2>3. Pricing Strategy</h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                        <label class="strategy-card">
                            <input type="radio" name="strategy" value="random" <?php echo (!isset($_POST['strategy']) || $_POST['strategy'] == 'random') ? 'checked' : ''; ?>> 
                            <b>Random</b><br>
                            <small>Price is random within range, unrelated to balance.</small>
                        </label>
                        <label class="strategy-card">
                            <input type="radio" name="strategy" value="correlated" <?php echo (isset($_POST['strategy']) && $_POST['strategy'] == 'correlated') ? 'checked' : ''; ?>> 
                            <b>Reasonable (Correlated)</b><br>
                            <small>Higher balance = Higher price. Scales linearly.</small>
                        </label>
                        <label class="strategy-card">
                            <input type="radio" name="strategy" value="target" <?php echo (isset($_POST['strategy']) && $_POST['strategy'] == 'target') ? 'checked' : ''; ?>> 
                            <b>Target Price</b><br>
                            <small>Generate prices around a specific value.</small>
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>Target Price (Only for 'Target Price' strategy)</label>
                        <input type="number" name="target_price" class="form-control" value="<?php echo $_POST['target_price'] ?? 200; ?>">
                    </div>
                </div>

                <div class="content-section" style="text-align: right;">
                    <button type="submit" name="action" value="preview" class="btn-action btn-preview">Preview Outcome</button>
                    <button type="submit" name="action" value="update" class="btn-action btn-save" onclick="return confirm('Are you sure you want to update all selected tables? This cannot be undone.');">Apply Changes</button>
                </div>
            </form>

            <?php if (!empty($previewData)): ?>
            <div class="content-section">
                <h2>Preview (Sample 10 rows)</h2>
                <table class="preview-table">
                    <thead>
                        <tr>
                            <th>Balance</th>
                            <th>Price</th>
                            <th>Verdict</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($previewData as $row): ?>
                        <tr>
                            <td>$<?php echo number_format($row['balance']); ?></td>
                            <td>$<?php echo number_format($row['price']); ?></td>
                            <td>
                                <?php 
                                    $ratio = $row['price'] / $row['balance'] * 100;
                                    echo number_format($ratio, 1) . "% of balance";
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>