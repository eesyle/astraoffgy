<?php
require_once 'config.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : (isset($_GET['username']) ? $_GET['username'] : '');
$bank = isset($_GET['bank']) ? $_GET['bank'] : '';
$safeBank = htmlspecialchars($bank ?: 'bank');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View <?= $safeBank ?> Banklogs</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="header" style="background: #2d2362; opacity: .9;">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">Banklogs</div>
                    </div>
                    <?php if (is_readable('./header.php')) include './header.php'; ?>
                </div>
            </nav>
        </div>
    </div>
    <?php if (is_readable('sidebar.php')) include 'sidebar.php'; ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">View <?= $safeBank ?> Banklogs</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Your <?= $safeBank ?> banklogs</h4>
                        </div>
                        <div class="card-body">
                            <p>Explore available banklogs. Also consider buying SOCKS or RATS at a reasonable price.</p>
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <form method="post" action="buy_item.php">
                                        <input type="hidden" name="item" value="SOCKS">
                                        <input type="hidden" name="bank" value="<?= htmlspecialchars($bank) ?>">
                                        <div class="mb-2">
                                            <label for="price_socks">SOCKS price</label>
                                            <input id="price_socks" type="number" step="0.01" min="0" name="price" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Buy SOCKS</button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form method="post" action="buy_item.php">
                                        <input type="hidden" name="item" value="RATS">
                                        <input type="hidden" name="bank" value="<?= htmlspecialchars($bank) ?>">
                                        <div class="mb-2">
                                            <label for="price_rats">RATS price</label>
                                            <input id="price_rats" type="number" step="0.01" min="0" name="price" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-secondary">Buy RATS</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>