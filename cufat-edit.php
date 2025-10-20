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
                            <a href="cufat_index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $student_id = mysqli_real_escape_string($con, $_GET['id']);
                            $query = "SELECT * FROM afcu WHERE id='$student_id' ";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);
                                ?>
                                <form action="code_cufat.php" method="POST">
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

                                <!-- Bulk apply of Info from this row -->
                                <div class="card mt-4 border-0 shadow-sm">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <span class="fw-bold">Bulk Apply Info</span>
                                        <span class="text-muted small">Use this row’s Info for all or random half</span>
                                    </div>
                                    <div class="card-body">
                                        <form action="code_cufat.php" method="POST" id="bulkInfoFromRow">
                                            <input type="hidden" name="bulk_edit_info" value="1">

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Mode</label>
                                                    <div class="d-flex gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="bulk_mode" id="bulkAllRow" value="all" checked>
                                                            <label class="form-check-label" for="bulkAllRow">All rows</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="bulk_mode" id="bulkHalfRow" value="half">
                                                            <label class="form-check-label" for="bulkHalfRow">Random half</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Editor</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="applyByPartsRow" name="apply_by_parts">
                                                        <label class="form-check-label" for="applyByPartsRow">Edit by parts (+ separated)</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 mt-3" id="bulkTextRowRow">
                                                <label class="form-label">Info (text)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="bulkInfoTextRow" name="info_text" value="<?= $student['info']; ?>">
                                                    <button class="btn btn-outline-secondary" id="splitFromTextRow">Split into parts</button>
                                                </div>
                                            </div>

                                            <div class="mt-3" id="partsEditorRow" style="display:none;">
                                                <label class="form-label">Info Parts</label>
                                                <div id="partsContainerRow"></div>
                                                <div class="d-flex gap-2 mt-2">
                                                    <button class="btn btn-sm btn-primary" id="addPartBtnRow">Add Part</button>
                                                </div>
                                                <div class="mt-2 text-muted small">Composed preview: <span id="composePreviewRow" class="fw-semibold"></span></div>
                                            </div>

                                            <div class="d-flex justify-content-end mt-4">
                                                <button class="btn btn-success">Apply Bulk Update</button>
                                            </div>
                                        </form>

                                        <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const applyParts = document.getElementById('applyByPartsRow');
                                            const bulkTextRow = document.getElementById('bulkTextRowRow');
                                            const infoText = document.getElementById('bulkInfoTextRow');
                                            const partsEditor = document.getElementById('partsEditorRow');
                                            const partsContainer = document.getElementById('partsContainerRow');
                                            const addPartBtn = document.getElementById('addPartBtnRow');
                                            const composePreview = document.getElementById('composePreviewRow');
                                            const splitFromTextBtn = document.getElementById('splitFromTextRow');

                                            function renderPreview() {
                                                const parts = Array.from(document.querySelectorAll('#partsContainerRow .part-input'))
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

                                <!-- Bulk Balance & Price: correlated updates -->
                                <div class="card mt-4 border-0 shadow-sm">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <span class="fw-bold">Bulk Balance & Price</span>
                                        <span class="text-muted small">Ensure prices correspond to balances</span>
                                    </div>
                                    <div class="card-body">
                                        <form action="code_cufat.php" method="POST">
                                            <input type="hidden" name="bulk_edit_balance_price" value="1">

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
                                                        <input class="form-check-input" type="checkbox" id="clampBalanceEdit" name="clamp_balance">
                                                        <label class="form-check-label" for="clampBalanceEdit">Clamp balances below minimum</label>
                                                    </div>
                                                    <div class="form-check form-switch mt-1">
                                                        <input class="form-check-input" type="checkbox" id="recalcPriceOnlyEdit" name="recalc_price_only">
                                                        <label class="form-check-label" for="recalcPriceOnlyEdit">Only recalc prices (keep balances)</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end mt-4">
                                                <button class="btn btn-primary">Apply Balance+Price Logic</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>