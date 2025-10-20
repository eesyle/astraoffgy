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
    <title>EDITING SURNCORP BANK</title>
     
</head>
<body>
    <div class="content-wrapper">
        <?php include('message.php'); ?>
        <div class="row card-header">
            <div class="col-md-12  ">
                <div class="card">
                    <div class="h4 display-5 card-header">
                        <h4>  SURNCORP BANK Details
                           
                        </h4>
                    </div>
                    <!-- Bulk Balance & Price form wired to shared handler -->
                    <div class="p-3">
                      <form action="code.php" method="POST" class="card card-body mb-3">
                        <input type="hidden" name="table" value="amp" />
                        <input type="hidden" name="redirect_path" value="amp_index.php" />
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
                            <input type="checkbox" name="recalc_price_only" class="form-check-input" id="amp_recalc_only">
                            <label class="form-check-label" for="amp_recalc_only">Only recalc prices (keep balances)</label>
                          </div>
                        </div>
                        <div>
                          <button type="submit" name="bulk_edit_balance_price" class="btn btn-primary">Apply Bulk Balance & Price</button>
                        </div>
                      </form>
                    </div>
                    <!-- Bulk Edit Info: modern controls -->
                    <div class="px-3 pt-3">
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <span class="fw-bold">Bulk Edit Info</span>
                                <span class="text-muted small">Apply to all or random half</span>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" id="bulkInfoForm">
                                    <input type="hidden" name="bulk_edit_info" value="1">
                                    <input type="hidden" name="table" value="amp">
                                    <input type="hidden" name="redirect_path" value="amp_index.php">

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Mode</label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="bulk_mode" id="bulkAll" value="all" checked>
                                                    <label class="form-check-label" for="bulkAll">All rows</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="bulk_mode" id="bulkHalf" value="half">
                                                    <label class="form-check-label" for="bulkHalf">Random half</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Editor</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="applyByParts" name="apply_by_parts">
                                                <label class="form-check-label" for="applyByParts">Edit by parts (+ separated)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 mt-3" id="bulkTextRow">
                                        <label class="form-label">Info (text)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="bulkInfoText" name="info_text" placeholder="e.g. PartA+PartB+PartC">
                                            <button class="btn btn-outline-secondary" id="splitFromText">Split into parts</button>
                                        </div>
                                        <small class="text-muted">Use "+" between parts to structure the Info text.</small>
                                    </div>

                                    <div class="mt-3" id="partsEditor" style="display:none;">
                                        <label class="form-label">Info Parts</label>
                                        <div id="partsContainer"></div>
                                        <div class="d-flex gap-2 mt-2">
                                            <button class="btn btn-sm btn-primary" id="addPartBtn">Add Part</button>
                                        </div>
                                        <div class="mt-2 text-muted small">Composed preview: <span id="composePreview" class="fw-semibold"></span></div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button class="btn btn-success">Apply Bulk Update</button>
                                    </div>
                                </form>

                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const applyParts = document.getElementById('applyByParts');
                                    const bulkTextRow = document.getElementById('bulkTextRow');
                                    const infoText = document.getElementById('bulkInfoText');
                                    const partsEditor = document.getElementById('partsEditor');
                                    const partsContainer = document.getElementById('partsContainer');
                                    const addPartBtn = document.getElementById('addPartBtn');
                                    const composePreview = document.getElementById('composePreview');
                                    const splitFromTextBtn = document.getElementById('splitFromText');

                                    function renderPreview() {
                                        const parts = Array.from(document.querySelectorAll('.part-input'))
                                            .map(i => i.value.trim())
                                            .filter(Boolean);
                                        composePreview.textContent = parts.join(' + ');
                                    }
                                    function createPartInput(value = '') {
                                        const div = document.createElement('div');
                                        div.className = 'input-group mb-2';
                                        div.innerHTML = `
                                            <input type="text" name="info_parts[]" class="form-control part-input" placeholder="Part" value="${value}">
                                            <button class="btn btn-outline-secondary removePart">Remove</button>
                                        `;
                                        div.querySelector('.part-input').addEventListener('input', renderPreview);
                                        div.querySelector('.removePart').addEventListener('click', function(e){
                                            e.preventDefault();
                                            div.remove();
                                            renderPreview();
                                        });
                                        return div;
                                    }

                                    applyParts.addEventListener('change', function() {
                                        const enabled = applyParts.checked;
                                        partsEditor.style.display = enabled ? 'block' : 'none';
                                        bulkTextRow.style.display = enabled ? 'none' : '';
                                    });

                                    addPartBtn.addEventListener('click', function(e){
                                        e.preventDefault();
                                        partsContainer.appendChild(createPartInput());
                                        renderPreview();
                                    });

                                    splitFromTextBtn.addEventListener('click', function(e){
                                        e.preventDefault();
                                        partsContainer.innerHTML = '';
                                        const text = infoText.value || '';
                                        if (text.length) {
                                            text.split('+').map(s => s.trim()).filter(Boolean).forEach(p => {
                                                partsContainer.appendChild(createPartInput(p));
                                            });
                                        } else {
                                            partsContainer.appendChild(createPartInput());
                                            partsContainer.appendChild(createPartInput());
                                            partsContainer.appendChild(createPartInput());
                                        }
                                        renderPreview();
                                        applyParts.checked = true;
                                        applyParts.dispatchEvent(new Event('change'));
                                    });
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                    <!-- Bulk Balance & Price form wired to shared handler -->
                    <div class="p-3">
                      <form action="code.php" method="POST" class="card card-body mb-3">
                        <input type="hidden" name="table" value="amp" />
                        <input type="hidden" name="redirect_path" value="amp_index.php" />
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
                            <input type="checkbox" name="recalc_price_only" class="form-check-input" id="amp_recalc_only">
                            <label class="form-check-label" for="amp_recalc_only">Only recalc prices (keep balances)</label>
                          </div>
                        </div>
                        <div>
                          <button type="submit" name="bulk_edit_balance_price" class="btn btn-primary">Apply Bulk Balance & Price</button>
                        </div>
                      </form>
                    </div>
                    <!-- Bulk Info form wired to shared handler -->
                    <div class="p-3">
                      <form action="code.php" method="POST" class="card card-body mb-3">
                        <input type="hidden" name="table" value="amp" />
                        <input type="hidden" name="redirect_path" value="amp_index.php" />
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
                            <input type="checkbox" name="apply_by_parts" class="form-check-input" id="amp_info_parts_chk">
                            <label class="form-check-label" for="amp_info_parts_chk">Compose from parts</label>
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
                        <div>
                          <button type="submit" name="bulk_edit_info" class="btn btn-secondary">Apply Bulk Info</button>
                        </div>
                      </form>
                    </div>
                    <div class="table-responsive text-noswrap pt-1 " >
                        <table class="table table-bordered table-responsive table-striped" id="boa">
                            <thead>
                                <tr >
                                    <th>ID</th>
                                    <th>Balance</th>
                                    <th>Title</th>
                                    <th>Info</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT * FROM amp";
                                    $query_run = mysqli_query($con, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $student)
                                        {
                                            ?>
                                            <tr  >
                                                <td><?= $student['id']; ?></td>
                                                <td><?= $student['Balance']; ?></td>
                                                <td><?= $student['Title']; ?></td>
                                                <td><?= $student['info']; ?></td>
                                                <td><?= $student['price']; ?></td>
                                                <td>
                                                    <a href="amp-edit.php?id=<?= $student['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <form action="code_amp.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_student" value="<?=$student['id'];?>" class="btn btn-danger btn-sm">Delete</button>
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
