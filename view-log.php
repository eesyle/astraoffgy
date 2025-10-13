<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$username = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : (isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '');
$ref = isset($_GET['ref']) ? htmlspecialchars($_GET['ref']) : '';
$amount = 35; // Each option costs $35
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Log Options</title>
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body { background: var(--bg-1); color: var(--text-1); }
      .card { background: var(--bg-2); border: 1px solid var(--border); }
      .option { border: 1px dashed var(--border); border-radius: .5rem; padding: 1rem; }
      .btn-dark { background: var(--bg-3); border-color: var(--border); }
      .btn-dark:hover { background: var(--bg-2); }
    </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow">
          <div class="card-body">
            <div class="text-center mb-3">
              <img src="assets/logo.png" alt="Logo" style="height:48px" />
            </div>
            <h3 class="card-title">View Your Log</h3>
            <p class="mb-4">Each product costs <strong>$35 USD</strong>. Choose and proceed to payment method.</p>

            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Info</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>RATS</td>
                    <td>Request access to transaction session (RATS).</td>
                    <td>$<?php echo number_format($amount, 2); ?></td>
                    <td>
                      <form method="post" action="buy_item.php" class="d-inline">
                        <input type="hidden" name="item" value="RATS">
                        <input type="hidden" name="price" value="<?php echo $amount; ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Buy</button>
                      </form>
                    </td>
                  </tr>
                  <tr>
                    <td>SOCKS</td>
                    <td>Secure SOCKS access for your log session.</td>
                    <td>$<?php echo number_format($amount, 2); ?></td>
                    <td>
                      <form method="post" action="buy_item.php" class="d-inline">
                        <input type="hidden" name="item" value="SOCKS">
                        <input type="hidden" name="price" value="<?php echo $amount; ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Buy</button>
                      </form>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>