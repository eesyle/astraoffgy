<?php
    // Debugging: Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    session_start();
    require 'dbcon.php';

    // Debugging: Check database connection
    if (!isset($con)) {
        die("Error: Database connection variable \$con is not set. Check dbcon.php.");
    }
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
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
    <title>EDITING USERS DETAILS</title>
     
</head>
<body>
    <div class="content-wrapper">
        <?php include('message.php'); ?>
        <div class="row card-header">
            <div class="col-md-12  ">
                <div class="card">
                    <div class="h4 display-5 card-header">
                        <h4>USERS Details
                            
                        </h4>
                    </div>
                    <div class="table-responsive text-noswrap pt-1 " >
                        <table class="table table-bordered table-responsive table-striped" id="boa">
                            <thead>
                                <tr >
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>UserName</th>
                                    <th>PassWord</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Balance</th>
                                    <th>STC</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT * FROM users";
                                    $query_run = mysqli_query($con, $query);

                                    if (!$query_run) {
                                        echo "<tr><td colspan='10' class='text-danger'>Query Failed: " . mysqli_error($con) . "</td></tr>";
                                    }
                                    elseif(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $student)
                                        {
                                            ?>
                                            <tr  >
                                                <td><?= $student['id']; ?></td>
                                                <td><?= $student['email']; ?></td>
                                                <td><?= $student['username']; ?></td>
                                                <td><?= $student['password']; ?></td>
                                                <td><?= $student['date']; ?></td>
                                                <td><?= $student['price']; ?></td>
                                                <td><?= $student['balance']; ?></td>
                                                <td><?= $student['statuscomplete']; ?></td>
                                                <td>
                                                    <?php $active = isset($student['is_active']) ? (int)$student['is_active'] : 0; ?>
                                                    <span class="badge <?= $active ? 'badge-success' : 'badge-secondary' ?>">
                                                        <?= $active ? 'Active' : 'Inactive' ?>
                                                    </span>
                                                    <form action="Code_users.php" method="POST" class="d-inline">
                                                        <input type="hidden" name="user_id" value="<?= $student['id']; ?>">
                                                        <input type="hidden" name="is_active" value="<?= $active ? 0 : 1; ?>">
                                                        <button type="submit" name="update_active" class="btn btn-sm <?= $active ? 'btn-warning' : 'btn-success' ?>">
                                                            <?= $active ? 'Deactivate' : 'Activate' ?>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="user_edit.php?id=<?= $student['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <form action="Code_users.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_student" value="<?= $student['id']; ?>" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "<tr><td colspan='6'>No Record Found</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="static\vendor\libs\jquery\jquery.js"></script>
    <script src="static\vendor\libs\popper\popper.js"></script>
    <script src="static\vendor\js\bootstrap.js"></script>
    <script src="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.js"></script>

    <script src="static\vendor\js\menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="static\vendor\libs\apex-charts\apexcharts.js"></script>

    <!-- Main JS -->
    <script src="static\js\main.js"></script>

    <!-- Page JS -->
    <script src="static\js\dashboards-analytics.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="static\js\toast.js"></script>

    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>

</body>
</html>
