<?php
session_start();
require_once "config.php";

// Ensure user is logged in
if (!isset($_SESSION['username']) && !isset($_POST['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'] ?? $_POST['username'];
$rdp_email = $_POST['rdp_email'] ?? '';
$selected_tools = $_POST['tools'] ?? [];

// If no tools selected, redirect back
if (empty($selected_tools)) {
    echo "<script>alert('Please select at least one tool.'); window.history.back();</script>";
    exit();
}

// Process tools for display
$tools_display = [];
$total_price = 0;

// Map values back to names if needed, or rely on data passed.
// Since we only passed values in checkboxes, let's reconstruct the names or use the values to look them up.
// Actually, in the previous step I added `data-name` but that's JS only. 
// I'll define the map here for security and clarity.
$tools_map = [
    'rats' => ['name' => 'RATs - Remote Access Trojan', 'price' => 65],
    'socks_1m' => ['name' => 'Socks Proxy (1 Month)', 'price' => 20],
    'socks_3m' => ['name' => 'Socks Proxy (3 Months)', 'price' => 45],
    'socks_6m' => ['name' => 'Socks Proxy (6 Months)', 'price' => 100]
];

foreach ($selected_tools as $key => $price) {
    if (isset($tools_map[$key])) {
        $tools_display[] = $tools_map[$key];
        $total_price += $tools_map[$key]['price'];
    }
}

/**
 * Discover payment addresses from assets/addresses based on selected tools.
 * Filenames follow a convention like:
 *   ratBTC <address>.jpeg
 *   ratltc <address>.jpeg
 *   ratusdc <address>.jpeg
 *   ratusdt <address>.jpeg
 * Optionally socks variants:
 *   socksBTC <address>.png
 *
 * Returns an array of entries:
 * [ ['type' => 'rat', 'currency' => 'BTC', 'address' => '...', 'image' => 'assets/addresses/<file>'], ... ]
 */
function loadPaymentAddresses(array $tools_display): array {
    $needRat = false;
    $needSocks = false;
    foreach ($tools_display as $t) {
        $name = strtolower($t['name']);
        if (strpos($name, 'rat') !== false) $needRat = true;
        if (strpos($name, 'socks') !== false) $needSocks = true;
    }
    $dir = __DIR__ . '/assets/addresses';
    $entries = [];
    if (!is_dir($dir)) {
        return $entries;
    }
    $files = glob($dir . '/*.{jpg,jpeg,png}', GLOB_BRACE);
    foreach ($files as $path) {
        $base = basename($path);
        // Split at first space: "<token> <address>.<ext>"
        $parts = preg_split('/\s+/', $base, 2);
        if (count($parts) < 2) continue;
        $token = strtolower(pathinfo($parts[0], PATHINFO_FILENAME)); // e.g., ratbtc, ratusdt, socksbtc
        $addrWithExt = $parts[1];
        // Extract address by removing extension from remainder
        $address = preg_replace('/\.(jpg|jpeg|png)$/i', '', $addrWithExt);
        $type = null;
        $currency = null;
        if (strpos($token, 'rat') === 0) {
            $type = 'rat';
            $currency = strtoupper(substr($token, 3)); // after 'rat'
        } elseif (strpos($token, 'socks') === 0 || strpos($token, 'sock') === 0) {
            $type = 'socks';
            $currency = strtoupper(preg_replace('/^socks?/', '', $token)); // after 'socks' or 'sock'
        } else {
            continue; // Unknown token
        }
        // Filter by need
        if (($type === 'rat' && !$needRat) || ($type === 'socks' && !$needSocks)) {
            continue;
        }
        $entries[] = [
            'type' => $type,
            'currency' => $currency !== '' ? $currency : 'UNKNOWN',
            'address' => $address,
            'image' => 'assets/addresses/' . $base
        ];
    }
    return $entries;
}

$paymentEntries = loadPaymentAddresses($tools_display);
function groupByCurrency($entries) {
    $g = [];
    foreach ($entries as $e) {
        $cur = strtoupper($e['currency']);
        if (!isset($g[$cur])) $g[$cur] = [];
        $g[$cur][] = $e;
    }
    return $g;
}
$grouped = groupByCurrency($paymentEntries);
$wfpriceQuery = '?wfprice=' . $total_price;
$encodedItems = base64_encode(json_encode($tools_display));

?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="static/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Checkout | HoldLogix</title>
    
    <link rel="stylesheet" href="static/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="static/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="xui-main/css/style.css" rel="stylesheet">
    <style>
        .checkout-card {
            background: #232744;
            color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .crypto-address {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            word-break: break-all;
            border: 1px dashed #696cff;
        }
        .payment-card .coin-logo {
            width: 56px;
            height: 56px;
            object-fit: contain;
            border-radius: 8px;
        }
        @media (max-width: 576px) {
            .payment-card .coin-logo {
                width: 44px;
                height: 44px;
            }
        }
    </style>
</head>

<body>

    <?php include './navHeader.php'; ?>

    <div class="header" style="background: #2d2362; opacity: .9;">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">Checkout</div>
                    </div>
                    <?php
                    $headerFile = './header.php';
                    if (is_readable($headerFile)) {
                        include($headerFile);
                    }
                    ?>
                </div>
            </nav>
        </div>
    </div>

    <?php include './sidebar.php'; ?>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="content-wrapper">
                    
                    <div class="container-fluid pt-5 pb-5">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card checkout-card">
                                    <div class="card-header border-bottom border-secondary">
                                        <h3 class="text-white mb-0">Order Summary</h3>
                                    </div>
                                    <div class="card-body p-4">
                                        
                                        <h5 class="text-light mb-3">Selected Tools</h5>
                                        <div class="table-responsive mb-4">
                                            <table class="table table-dark table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th class="text-end">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($tools_display as $item): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                                        <td class="text-end">$<?= number_format($item['price'], 2) ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="border-top border-light">
                                                        <td><strong>Total Amount</strong></td>
                                                        <td class="text-end"><strong class="text-primary fs-4">$<?= number_format($total_price, 2) ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="alert alert-warning mb-4">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Please make the payment using one of the addresses below to complete your order.
                                        </div>

                                        <?php if (!empty($grouped)): ?>
                                            <div class="row">
                                                <?php if (isset($grouped['BTC'])): ?>
                                                    <div class="col-md-6 col-lg-4 mb-4">
                                                        <div class="card h-100 shadow-sm payment-card">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img class="coin-logo me-2 img-fluid" src="<?= htmlspecialchars($grouped['BTC'][0]['image']) ?>" alt="BTC logo">
                                                                    <div>
                                                                        <h5 class="mb-0">Bitcoin (BTC)</h5>
                                                                        <div class="network-label">Network: Bitcoin</div>
                                                                    </div>
                                                                </div>
                                                                <code class="d-block"><?= htmlspecialchars($grouped['BTC'][0]['address']) ?></code>
                                                                <div class="mt-2 d-flex gap-2">
                                                                    <button class="btn btn-sm btn-outline-primary" onclick="copyText('<?= htmlspecialchars($grouped['BTC'][0]['address']) ?>')">Copy</button>
                                                                    <a class="btn btn-sm btn-primary" href="topaddr.php<?= $wfpriceQuery ?>&currency=BTC&address=<?= urlencode($grouped['BTC'][0]['address']) ?>&image=<?= urlencode($grouped['BTC'][0]['image']) ?>&username=<?= urlencode($username) ?>&rdp_email=<?= urlencode($rdp_email) ?>&items=<?= urlencode($encodedItems) ?>">Continue</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (isset($grouped['USDT'])): ?>
                                                    <div class="col-md-6 col-lg-4 mb-4">
                                                        <div class="card h-100 shadow-sm payment-card">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img class="coin-logo me-2 img-fluid" src="<?= htmlspecialchars($grouped['USDT'][0]['image']) ?>" alt="USDT logo">
                                                                    <div>
                                                                        <h5 class="mb-0">Tether (USDT)</h5>
                                                                        <div class="network-label">Network: TRON (TRC20)</div>
                                                                    </div>
                                                                </div>
                                                                <code class="d-block"><?= htmlspecialchars($grouped['USDT'][0]['address']) ?></code>
                                                                <div class="mt-2 d-flex gap-2">
                                                                    <button class="btn btn-sm btn-outline-primary" onclick="copyText('<?= htmlspecialchars($grouped['USDT'][0]['address']) ?>')">Copy</button>
                                                                    <a class="btn btn-sm btn-primary" href="topaddr.php<?= $wfpriceQuery ?>&currency=USDT&address=<?= urlencode($grouped['USDT'][0]['address']) ?>&image=<?= urlencode($grouped['USDT'][0]['image']) ?>&username=<?= urlencode($username) ?>&rdp_email=<?= urlencode($rdp_email) ?>&items=<?= urlencode($encodedItems) ?>">Continue</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (isset($grouped['USDC']) || isset($grouped['ETH'])): ?>
                                                    <?php $ethEntry = $grouped['USDC'][0] ?? $grouped['ETH'][0]; ?>
                                                    <div class="col-md-6 col-lg-4 mb-4">
                                                        <div class="card h-100 shadow-sm payment-card">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img class="coin-logo me-2 img-fluid" src="<?= htmlspecialchars($ethEntry['image']) ?>" alt="ETH logo">
                                                                    <div>
                                                                        <h5 class="mb-0">Ethereum (ETH/USDC)</h5>
                                                                        <div class="network-label">Network: Ethereum</div>
                                                                    </div>
                                                                </div>
                                                                <code class="d-block"><?= htmlspecialchars($ethEntry['address']) ?></code>
                                                                <div class="mt-2 d-flex gap-2">
                                                                    <button class="btn btn-sm btn-outline-primary" onclick="copyText('<?= htmlspecialchars($ethEntry['address']) ?>')">Copy</button>
                                                                    <a class="btn btn-sm btn-primary" href="topaddr.php<?= $wfpriceQuery ?>&currency=ETH&address=<?= urlencode($ethEntry['address']) ?>&image=<?= urlencode($ethEntry['image']) ?>&username=<?= urlencode($username) ?>&rdp_email=<?= urlencode($rdp_email) ?>&items=<?= urlencode($encodedItems) ?>">Continue</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (isset($grouped['LTC'])): ?>
                                                    <div class="col-md-6 col-lg-4 mb-4">
                                                        <div class="card h-100 shadow-sm payment-card">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img class="coin-logo me-2 img-fluid" src="<?= htmlspecialchars($grouped['LTC'][0]['image']) ?>" alt="LTC logo">
                                                                    <div>
                                                                        <h5 class="mb-0">Litecoin (LTC)</h5>
                                                                        <div class="network-label">Network: Litecoin</div>
                                                                    </div>
                                                                </div>
                                                                <code class="d-block"><?= htmlspecialchars($grouped['LTC'][0]['address']) ?></code>
                                                                <div class="mt-2 d-flex gap-2">
                                                                    <button class="btn btn-sm btn-outline-primary" onclick="copyText('<?= htmlspecialchars($grouped['LTC'][0]['address']) ?>')">Copy</button>
                                                                    <a class="btn btn-sm btn-primary" href="topaddr.php<?= $wfpriceQuery ?>&currency=LTC&address=<?= urlencode($grouped['LTC'][0]['address']) ?>&image=<?= urlencode($grouped['LTC'][0]['image']) ?>&username=<?= urlencode($username) ?>&rdp_email=<?= urlencode($rdp_email) ?>&items=<?= urlencode($encodedItems) ?>">Continue</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (isset($grouped['TON'])): ?>
                                                    <div class="col-md-6 col-lg-4 mb-4">
                                                        <div class="card h-100 shadow-sm payment-card">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img class="coin-logo me-2 img-fluid" src="<?= htmlspecialchars($grouped['TON'][0]['image']) ?>" alt="TON logo">
                                                                    <div>
                                                                        <h5 class="mb-0">TON</h5>
                                                                        <div class="network-label">Network: TON</div>
                                                                    </div>
                                                                </div>
                                                                <code class="d-block"><?= htmlspecialchars($grouped['TON'][0]['address']) ?></code>
                                                                <div class="mt-2 d-flex gap-2">
                                                                    <button class="btn btn-sm btn-outline-primary" onclick="copyText('<?= htmlspecialchars($grouped['TON'][0]['address']) ?>')">Copy</button>
                                                                    <a class="btn btn-sm btn-primary" href="topaddr.php<?= $wfpriceQuery ?>&currency=TON&address=<?= urlencode($grouped['TON'][0]['address']) ?>&image=<?= urlencode($grouped['TON'][0]['image']) ?>&username=<?= urlencode($username) ?>&rdp_email=<?= urlencode($rdp_email) ?>&items=<?= urlencode($encodedItems) ?>">Continue</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-secondary">
                                                No payment addresses found in <code>assets/addresses</code> for the selected tools.
                                            </div>
                                        <?php endif; ?>

                                        <form action="process_tool_purchase.php" method="POST">
                                            <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                                            <input type="hidden" name="rdp_email" value="<?= htmlspecialchars($rdp_email) ?>">
                                            <input type="hidden" name="total_price" value="<?= $total_price ?>">
                                            <!-- Serialize tools array to pass it along -->
                                            <?php foreach ($tools_display as $index => $item): ?>
                                                <input type="hidden" name="items[<?= $index ?>][name]" value="<?= htmlspecialchars($item['name']) ?>">
                                                <input type="hidden" name="items[<?= $index ?>][price]" value="<?= $item['price'] ?>">
                                            <?php endforeach; ?>

                                            <div class="d-grid gap-2">
                                                <button type="submit" name="confirm_purchase" class="btn btn-success btn-lg">
                                                    <i class="fas fa-check-circle me-2"></i> I Have Made The Payment
                                                </button>
                                                <a href="verified_products.php" class="btn btn-outline-secondary">Back to Products</a>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="xui-main/vendor/global/global.min.js"></script>
    <script src="xui-main/js/custom.min.js"></script>
    <script>
        function copyDynamic(id) {
            var copyText = document.getElementById(id).innerText.trim();
            navigator.clipboard.writeText(copyText)
                .then(function() { alert("Address copied to clipboard!"); })
                .catch(function(err) { console.error('Could not copy text: ', err); });
        }
        function copyText(text) {
            navigator.clipboard.writeText(text)
                .then(function() { alert("Address copied to clipboard!"); })
                .catch(function(err) { console.error('Could not copy text: ', err); });
        }
    </script>
</body>
</html>
