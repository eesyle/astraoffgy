<?php
    session_start();
    require 'dbcon.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="static\\vendor\\fonts\\boxicons.css" />
    <link rel="stylesheet" href="static\\vendor\\css\\core.css" />
    <link rel="stylesheet" href="static\\vendor\\css\\theme-default.css" />
    <link rel="stylesheet" href="static\\css\\dr.css" />
    <link rel="stylesheet" href="static\\vendor\\libs\\perfect-scrollbar\\perfect-scrollbar.css" />
    <link rel="stylesheet" href="static\\vendor\\libs\\apex-charts\\apex-charts.css" />
    <script src="static\\vendor\\js\\helpers.js"></script>
    <script src="static\\js\\config.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">
    <title>EDITING BMO BANK</title>
</head>
<body>
    <div class="content-wrapper">
        <?php include('message.php'); ?>
        <div class="row card-header">
            <div class="col-md-12">
                <div class="card">
                    <div class="h4 display-5 card-header">
                        <h4>BMO BANK Details</h4>
                    </div>
                    <div class="table-responsive pt-1">
                        <table class="table table-bordered table-responsive table-striped" id="bmo">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Balance</th>
                                    <th>Info</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT id, balance, info, price FROM bmo";
                                    $query_run = mysqli_query($con, $query);
                                    if($query_run && mysqli_num_rows($query_run) > 0) {
                                        foreach($query_run as $student) { ?>
                                            <tr>
                                                <td><?= $student['id']; ?></td>
                                                <td><?= $student['balance']; ?></td>
                                                <td><?= $student['info']; ?></td>
                                                <td><?= $student['price']; ?></td>
                                                <td>
                                                    <a href="bmo_edit.php?id=<?= $student['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <form action="code_bmo.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_student" value="<?=$student['id'];?>" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else {
                                        echo "<tr><td colspan='5'>No Record Found</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="static\\vendor\\libs\\jquery\\jquery.js"></script>
    <script src="static\\vendor\\libs\\popper\\popper.js"></script>
    <script src="static\\vendor\\js\\bootstrap.js"></script>
    <script src="static\\vendor\\libs\\perfect-scrollbar\\perfect-scrollbar.js"></script>
    <script src="static\\vendor\\js\\menu.js"></script>
    <script src="static\\vendor\\libs\\apex-charts\\apexcharts.js"></script>
    <script src="static\\js\\main.js"></script>
    <script src="static\\js\\dashboards-analytics.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="static\\js\\toast.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>
</body>
</html>