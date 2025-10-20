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
    <link rel="stylesheet" href="static\css\dr.css" />

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
    <title>EDITING TD Canada </title>
     
</head>
<body>
    <div class="content-wrapper">
        <?php include('message.php'); ?>
        <div class="row card-header">
            <div class="col-md-12  ">
                <div class="card">
                    <div class="h4 display-5 card-header">
                        <h4>TD Canada Details
                        
                        </h4>
                    </div>
                    <div class="table-responsive text-noswrap pt-1 " >
                        <table class="table table-bordered table-responsive table-striped" id="boa">
                            <thead class="table-light">
                                <tr>
                                    <th style="white-space:nowrap;">ID</th>
                                    <th style="white-space:nowrap;">Balance</th>
                                    <th style="white-space:nowrap;">Title</th>
                                    <th style="white-space:nowrap;">Info</th>
                                    <th style="white-space:nowrap;">Price</th>
                                    <th style="white-space:nowrap;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="boaBody">
                                <?php
                                $query_table = "t_d";
                                $is_active = 1;
                                include 'banklogs_query.php';
                                ?>
                            </tbody>
                        </table>

                        <!-- Bulk Edit Info -->
                        <div class="px-3 mt-4">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <span class="fw-bold">Bulk Edit Info</span>
                                    <span class="text-muted small">Add/remove info parts across selected logs</span>
                                </div>
                                <div class="card-body">
                                    <form action="code.php" method="POST" id="bulkEditInfoForm">
                                        <input type="hidden" name="bulk_edit_info" value="1">
                                        <input type="hidden" name="table" value="t_d">
                                        <input type="hidden" name="redirect_path" value="atew_index.php">

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">New Info Part</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="newInfoPart" placeholder="e.g., Verified Phone" />
                                                    <button type="button" class="btn btn-outline-primary" id="addInfoPart">Add Part</button>
                                                </div>
                                                <small class="text-muted">Add an info part to all selected logs</small>

                                                <div class="mt-2">
                                                    <label class="form-label small">Current Parts</label>
                                                    <div id="infoPartsList" class="d-flex flex-wrap gap-2"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Remove Info Part</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="removeInfoPart" placeholder="e.g., Email Verified" />
                                                    <button type="button" class="btn btn-outline-danger" id="removeInfoPartBtn">Remove Part</button>
                                                </div>
                                                <small class="text-muted">Remove an info part from all selected logs</small>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button class="btn btn-primary">Apply Info Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Bulk Balance & Price: correlated updates -->
                        <div class="px-3">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <span class="fw-bold">Bulk Balance & Price</span>
                                    <span class="text-muted small">Ensure prices correspond to balances</span>
                                </div>
                                <div class="card-body">
                                    <form action="code.php" method="POST" id="bulkBalancePriceForm">
                                        <input type="hidden" name="bulk_edit_balance_price" value="1">
                                        <input type="hidden" name="table" value="t_d">
                                        <input type="hidden" name="redirect_path" value="atew_index.php">

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

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const infoParts = ['Email Verified', 'OTP Enabled', 'SSN Present'];
                                const infoPartsList = document.getElementById('infoPartsList');
                                const newInfoPartInput = document.getElementById('newInfoPart');
                                const addInfoPartBtn = document.getElementById('addInfoPart');
                                const removeInfoPartInput = document.getElementById('removeInfoPart');
                                const removeInfoPartBtn = document.getElementById('removeInfoPartBtn');

                                function renderInfoParts() {
                                    infoPartsList.innerHTML = '';
                                    infoParts.forEach(part => {
                                        const badge = document.createElement('span');
                                        badge.className = 'badge bg-secondary';
                                        badge.textContent = part;
                                        infoPartsList.appendChild(badge);
                                    });
                                }

                                addInfoPartBtn.addEventListener('click', function() {
                                    const part = newInfoPartInput.value.trim();
                                    if (part) {
                                        infoParts.push(part);
                                        renderInfoParts();
                                        newInfoPartInput.value = '';
                                    }
                                });

                                removeInfoPartBtn.addEventListener('click', function() {
                                    const part = removeInfoPartInput.value.trim();
                                    if (part) {
                                        const index = infoParts.indexOf(part);
                                        if (index !== -1) {
                                            infoParts.splice(index, 1);
                                            renderInfoParts();
                                            removeInfoPartInput.value = '';
                                        }
                                    }
                                });

                                renderInfoParts();
                            });
                        </script>                    </div>
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
