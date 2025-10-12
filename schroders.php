<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoldLogix</title>
    <link rel="shortcut icon" type="image/png" href="assets/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="xui-main/css/style.css" rel="stylesheet">
    <link href="static/css/grayscale.css" rel="stylesheet">
</head>
<body>
<div id="main-wrapper">
    <?php include './navHeader.php'; ?>
    <div class="header" style="background:#2d2362;opacity:.9;">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">UK Banks</div>
                    </div>
                    <?php include './header.php'; ?>
                </div>
            </nav>
        </div>
    </div>
    <?php include 'sidebar.php'; ?>
    <div class="content-body"><div class="container-fluid">
        <div class="row page-titles"><ol class="breadcrumb"><li class="breadcrumb-item active"><a href="javascript:void(0)">UK Banks > Schroders</a></li></ol></div>
        <div class="row"><div class="col-xl-12">
            <div class="card"><div class="card-body">
                <p>No data available for Schroders yet.</p>
            </div></div>
        </div></div>
        <?php include 'topModel.php'; ?>
    </div></div>
</div>
</body>
</html>