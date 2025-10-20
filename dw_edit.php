<?php
session_start();
require 'dbcon.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Editting an account</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit An Account 
                            <a href="dw_index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $student_id = mysqli_real_escape_string($con, $_GET['id']);
                            $query = "SELECT * FROM woodforest WHERE id='$student_id' ";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);
                                ?>
                                <form action="code_dw.php" method="POST">
                                    <input type="hidden" name="student_id" value="<?= $student['id']; ?>">

                                    <div class="mb-3">
                                        <label>ID</label>
                                        <input type="text" name="id" value="<?=$student['id'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Balance</label>
                                        <input type="text" name="Balance" value="<?=$student['Balance'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Title</label>
                                        <input type="text" name="Title" value="<?=$student['Title'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Info</label>
                                        <input type="text" name="info" value="<?=$student['info'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Price</label>
                                        <input type="text" name="price" value="<?=$student['price'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="update_student" class="btn btn-primary">
                                            Update An account
                                        </button>
                                    </div>

                                </form>
                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <!-- Bulk Balance & Price form wired to shared handler -->
                <div class="card mt-3">
                  <div class="card-header"><strong>Bulk Balance & Price (Woodforest)</strong></div>
                  <div class="card-body">
                    <form action="code.php" method="POST">
                      <input type="hidden" name="table" value="woodforest" />
                      <input type="hidden" name="redirect_path" value="dw_edit.php" />
                      <div class="row">
                        <div class="col-md-3 mb-2">
                          <label class="form-label">Minimum Balance</label>
                          <input type="number" step="0.01" name="min_balance" class="form-control" placeholder="e.g. 1000" required />
                        </div>
                        <div class="col-md-3 mb-2">
                          <label class="form-label">Minimum Price</label>
                          <input type="number" step="0.01" name="min_price" class="form-control" placeholder="e.g. 10.00" required />
                          <small class="text-muted">Anchors autoscaled curve at Minimum Balance.</small>
                        </div>
                        <div class="col-md-3 mb-2">
                          <label class="form-label">Maximum Price (exclusive)</label>
                          <input type="number" step="0.01" name="max_price" class="form-control" placeholder="e.g. 99.99" required />
                          <small class="text-muted">Prices strictly stay below this cap.</small>
                        </div>
                        <div class="col-md-3 mb-2">
                          <label class="form-label">Balance Distribution</label>
                          <select name="balance_distribution" class="form-select">
                            <option value="none">None (keep balances)</option>
                            <option value="even_spread">Even spread (min→max)</option>
                            <option value="step_increment">Step increment</option>
                          </select>
                        </div>
                        <div class="col-md-3 mb-2">
                          <label class="form-label">Balance Step</label>
                          <input type="number" step="0.01" name="balance_step" class="form-control" placeholder="e.g. 500" />
                        </div>
                        <div class="col-md-4 mb-2 form-check">
                          <input type="checkbox" name="recalc_price_only" class="form-check-input" id="dw_edit_recalc_only">
                          <label class="form-check-label" for="dw_edit_recalc_only">Only recalc prices (keep balances)</label>
                        </div>
                      </div>
                      <button type="submit" name="bulk_edit_balance_price" class="btn btn-primary">Apply Bulk Balance & Price</button>
                    </form>
                  </div>
                </div>
                <!-- Bulk Info form wired to shared handler -->
                <div class="card mt-3">
                  <div class="card-header"><strong>Bulk Info (Woodforest)</strong></div>
                  <div class="card-body">
                    <form action="code.php" method="POST">
                      <input type="hidden" name="table" value="woodforest" />
                      <input type="hidden" name="redirect_path" value="dw_edit.php" />
                      <div class="row">
                        <div class="col-md-3 mb-2">
                          <label class="form-label">Bulk Mode</label>
                          <select name="bulk_mode" class="form-select">
                            <option value="all">All rows</option>
                            <option value="half">Random half</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-2">
                          <label class="form-label">Info Text</label>
                          <input type="text" name="info_text" class="form-control" placeholder="Set same info for selected rows" />
                        </div>
                        <div class="col-md-3 mb-2 form-check">
                          <input type="checkbox" name="apply_by_parts" class="form-check-input" id="dw_edit_info_parts_chk">
                          <label class="form-check-label" for="dw_edit_info_parts_chk">Compose from parts</label>
                        </div>
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-4 mb-2">
                              <input type="text" name="info_parts[]" class="form-control" placeholder="Part 1" />
                            </div>
                            <div class="col-md-4 mb-2">
                              <input type="text" name="info_parts[]" class="form-control" placeholder="Part 2" />
                            </div>
                            <div class="col-md-4 mb-2">
                              <input type="text" name="info_parts[]" class="form-control" placeholder="Part 3" />
                            </div>
                          </div>
                          <small class="text-muted">When checked, parts join with '+' into the info field.</small>
                        </div>
                      </div>
                      <button type="submit" name="bulk_edit_info" class="btn btn-secondary">Apply Bulk Info</button>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>