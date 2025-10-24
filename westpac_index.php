<?php
    session_start();
    require 'dbcon.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="static\vendor\fonts\boxicons.css" />
    <link rel="stylesheet" href="static\vendor\css\core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="static\vendor\css\theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="static\css\dr.css" />

    <link rel="stylesheet" href="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.css" />
    <link rel="stylesheet" href="static\vendor\libs\apex-charts\apex-charts.css" />

    <script src="static\vendor\js\helpers.js"></script>
    <script src="static\js\config.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">
    <title>EDITING WESTPAC BANK</title>
</head>
<body>
    <div class="content-wrapper">
        <?php include('message.php'); ?>
        <div class="row card-header">
            <div class="col-md-12">
                <div class="card">
                    <div class="h4 display-5 card-header">
                        <h4>WESTPAC BANK Details</h4>
                    </div>

                    <!-- Bulk Edit Info -->
                    <div class="px-3 pt-3">
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <span class="fw-bold">Bulk Edit Info</span>
                                <span class="text-muted small">Apply to all or random half</span>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" id="bulkInfoForm">
                                    <input type="hidden" name="bulk_edit_info" value="1">
                                    <input type="hidden" name="table" value="westpac">
                                    <input type="hidden" name="redirect_path" value="westpac_index.php">

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

                    <!-- Bulk Balance & Price -->
                    <div class="px-3">
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <span class="fw-bold">Bulk Balance & Price</span>
                                <span class="text-muted small">Ensure prices correspond to balances</span>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" id="bulkBalancePriceForm">
                                    <input type="hidden" name="bulk_edit_balance_price" value="1">
                                    <input type="hidden" name="table" value="westpac">
                                    <input type="hidden" name="redirect_path" value="westpac_index.php">

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Minimum Balance</label>
                                            <input type="number" step="0.01" class="form-control" name="min_balance" placeholder="900" value="900">
                                            <small class="text-muted">Example: 900</small>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Minimum Price</label>
                                            <input type="number" step="0.01" class="form-control" name="min_price" placeholder="80" value="80">
                                            <small class="text-muted">Minimum Price anchors the curve; prices spread up to the cap (exclusive).</small>
                                            <small class="text-muted">Example: 80</small>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Options</label>
                                            <div class="mb-2">
                                                <label class="form-label small">Maximum Price</label>
                                                <input type="number" step="0.01" class="form-control" name="max_price" placeholder="1000" value="1000">
                                                <small class="text-muted">Cap prices strictly below this value (exclusive).</small>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Balance Distribution</label>
                                                <select class="form-select" name="balance_distribution">
                                                    <option value="none">None (preserve balances)</option>
                                                    <option value="even_spread">Even spread (min→cap)</option>
                                                    <option value="step_increment">Step increment from Minimum Balance</option>
                                                </select>
                                                <small class="text-muted">Systematically edit balances; prices follow the curve.</small>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Balance Step</label>
                                                <input type="number" step="0.01" class="form-control" name="balance_step" placeholder="100.00">
                                                <small class="text-muted">Used when Step increment is selected.</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="clampBalance" name="clamp_balance">
                                                <label class="form-check-label" for="clampBalance">Clamp balances below minimum</label>
                                            </div>
                                            <div class="form-check form-switch mt-1">
                                                <input class="form-check-input" type="checkbox" id="recalcPriceOnly" name="recalc_price_only">
                                                <label class="form-check-label" for="recalcPriceOnly">Only recalc prices (keep balances)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button class="btn btn-primary">Apply Balance+Price Logic</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive text-noswrap pt-1">
                        <table class="table table-bordered table-responsive table-striped" id="westpac">
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
                                <?php 
                                    $query = "SELECT * FROM westpac";
                                    $query_run = mysqli_query($con, $query);
                                    $hasEdit = file_exists('westpac_edit.php');
                                    $hasDel = file_exists('code_westpac.php');
                                    if($query_run && mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $student)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $student['id']; ?></td>
                                                <td><?= $student['Balance']; ?></td>
                                                <td><?= $student['Title']; ?></td>
                                                <td><?= $student['info']; ?></td>
                                                <td><?= $student['price']; ?></td>
                                                <td>
                                                    <?php if ($hasEdit) { ?>
                                                    <a href="westpac_edit.php?id=<?= $student['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <?php } else { echo '—'; } ?>
                                                    <?php if ($hasDel) { ?>
                                                    <form action="code_westpac.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_student" value="<?=$student['id'];?>" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                    <?php } ?>
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

    <script src="static\vendor\libs\jquery\jquery.js"></script>
    <script src="static\vendor\libs\popper\popper.js"></script>
    <script src="static\vendor\js\bootstrap.js"></script>
    <script src="static\vendor\libs\perfect-scrollbar\perfect-scrollbar.js"></script>
    <script src="static\vendor\js\menu.js"></script>
    <script src="static\vendor\libs\apex-charts\apexcharts.js"></script>
    <script src="static\js\main.js"></script>
    <script src="static\js\dashboards-analytics.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="static\js\toast.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>
</body>
</html>