<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$username = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : (isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '');
$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : 'sent';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sent</title>
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body { background: var(--bg-1); color: var(--text-1); }
      .success-hero { min-height: 70vh; display:flex; align-items:center; justify-content:center; }
      .card { background: var(--bg-2); border: 1px solid var(--border); }
      .btn-primary { background: var(--bg-3); border-color: var(--border); }
      .btn-primary:hover { background: var(--bg-2); }
    </style>
  </head>
  <body>
    <div class="container success-hero">
      <div class="col-lg-8">
        <div class="card shadow p-4 text-center">
          <div class="mb-3">
            <img src="assets/logo.png" alt="Logo" style="height:48px" />
          </div>
          <h2 class="mb-2">Email Successfully Sent</h2>
          <p class="lead">Thanks<?php echo $username ? ", " . $username : ""; ?>. Please check your email for more details.</p>
          <p>Status: <code><?php echo $status; ?></code></p>
          <div class="mt-4">
            <a class="btn btn-primary btn-lg" href="dash.php">Go to Dashboard</a>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  </body>
</html>