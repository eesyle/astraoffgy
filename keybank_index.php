<?php session_start();
require 'dbcon.php'; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="static\vendor\fonts\boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="static\vendor\css\core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="static\vendor\css\theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="static\css\demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.css" />

    <link rel="stylesheet" href="static\vendor\libs\apex-charts\apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="static\vendor\js\helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="static\js\config.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">
    <title>EDIT KEYBANK</title>
    <link rel="stylesheet" href="styleee.css">
</head>

<body>
    <div class="content-wrapper"><?php include('message.php'); ?>
        <div class="card">
            <div class="card-header">
                <h4>KEYBANK</h4>
            </div>
            <div class="card-body">
                <form action="code.php" method="POST" style="margin-bottom:16px">
                    <input type="hidden" name="bulk_edit_info" value="1"><input type="hidden" name="table" value="keybank"><input type="hidden" name="redirect_path" value="keybank_index.php">
                    <label>Mode:</label> <label><input type="radio" name="bulk_mode" value="all" checked> All</label> <label><input type="radio" name="bulk_mode" value="half"> Half</label>
                    <div style="margin-top:8px"><label>Info text</label><input type="text" class="form-control" name="info_text" placeholder="PartA+PartB+PartC"></div>
                    <div style="margin-top:8px"><button class="btn btn-success">Apply Bulk Info</button></div>
                </form>

                <form action="code.php" method="POST">
                    <input type="hidden" name="bulk_edit_balance_price" value="1"><input type="hidden" name="table" value="keybank"><input type="hidden" name="redirect_path" value="keybank_index.php">
                    <div><label>Min Balance</label><input type="number" step="0.01" class="form-control" name="min_balance" value="900"></div>
                    <div><label>Min Price</label><input type="number" step="0.01" class="form-control" name="min_price" value="80"></div>
                    <div><label>Max Price</label><input type="number" step="0.01" class="form-control" name="max_price" value="1000"></div>
                    <div><label>Distribution</label><select class="form-select" name="balance_distribution">
                            <option value="none">None</option>
                            <option value="even_spread">Even spread</option>
                            <option value="step_increment">Step increment</option>
                        </select></div>
                    <div><label>Balance step</label><input type="number" step="0.01" class="form-control" name="balance_step" placeholder="100.00"></div>
                    <div><label><input type="checkbox" name="clamp_balance"> Clamp below minimum</label></div>
                    <div><label><input type="checkbox" name="recalc_price_only"> Only recalc prices</label></div>
                    <div style="margin-top:8px"><button class="btn btn-primary">Apply Balance+Price</button></div>
                </form>
            </div>
        </div>

        <div class="table-responsive" style="margin-top:16px">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Balance</th>
                        <th>Title</th>
                        <th>Info</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $query = "SELECT * FROM keybank";
                    $query_run = mysqli_query($con, $query);
                    $hasEdit = file_exists('keybank_edit.php');
                    $hasDel = file_exists('code_keybank.php');
                    if ($query_run && mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) { ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['Balance']; ?></td>
                                <td><?= $row['Title']; ?></td>
                                <td><?= $row['info']; ?></td>
                                <td><?= $row['price']; ?></td>
                                <td><?php if ($hasEdit) { ?><a href="keybank_edit.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Edit</a><?php } else {
                                                                                                                                                    echo '—';
                                                                                                                                                } ?>
                                    <?php if ($hasDel) { ?><form action="code_keybank.php" method="POST" class="d-inline"><button type="submit" name="delete_student" value="<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</button></form><?php } ?></td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='6'>No Record Found</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>