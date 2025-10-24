<?php
include 'message.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BMO BANK Details</title>
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
  <link rel="stylesheet" href="static/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="static/vendor/open-iconic/font/css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="static/css/pagination.css">
  <link rel="stylesheet" href="static/css/select2.min.css">
  <link rel="stylesheet" href="static/vendor/alertify/alertify.min.css">
  <link rel="stylesheet" href="static/vendor/alertify/alertify-bootstrap.min.css">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container mt-4">
  <h3 class="mb-4">BMO BANK Details</h3>

  <!-- Bulk Info Editor -->
  <div class="card mb-4">
    <div class="card-header">Bulk Edit Info</div>
    <div class="card-body">
      <ul class="nav nav-tabs" id="infoTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="info-text-tab" data-bs-toggle="tab" data-bs-target="#info-text" type="button" role="tab">Text Mode</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="info-parts-tab" data-bs-toggle="tab" data-bs-target="#info-parts" type="button" role="tab">Parts Mode</button>
        </li>
      </ul>
      <div class="tab-content border-start border-end border-bottom p-3" id="infoTabContent">
        <div class="tab-pane fade show active" id="info-text" role="tabpanel">
          <form method="POST" action="code.php">
            <input type="hidden" name="bulk_edit_info" value="1">
            <input type="hidden" name="table" value="bmo">
            <input type="hidden" name="redirect_path" value="bmo_index.php">
            <div class="mb-3">
              <label class="form-label">Info Text</label>
              <textarea class="form-control" name="info_text" rows="4" placeholder="Enter info text..."></textarea>
            </div>
            <div class="mb-3 form-check">
              <input class="form-check-input" type="checkbox" id="appendInfoText" name="append_info">
              <label class="form-check-label" for="appendInfoText">Append instead of replace</label>
            </div>
            <button class="btn btn-primary" type="submit">Apply to all</button>
          </form>
        </div>
        <div class="tab-pane fade" id="info-parts" role="tabpanel">
          <form method="POST" action="code.php" id="infoPartsForm">
            <input type="hidden" name="bulk_edit_info" value="1">
            <input type="hidden" name="table" value="bmo">
            <input type="hidden" name="redirect_path" value="bmo_index.php">
            <div id="infoPartsContainer"></div>
            <button type="button" class="btn btn-secondary me-2" id="addInfoPartBtn">+ Add Part</button>
            <button class="btn btn-primary" type="submit">Apply to all</button>
          </form>
          <hr>
          <div>
            <label class="form-label">Preview</label>
            <div class="border p-3" id="infoPreview"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bulk Balance & Price Editor -->
  <div class="card mb-4">
    <div class="card-header">Bulk Edit Balance & Price</div>
    <div class="card-body">
      <form method="POST" action="code.php" id="balancePriceForm">
        <input type="hidden" name="bulk_edit_balance_price" value="1">
        <input type="hidden" name="table" value="bmo">
        <input type="hidden" name="redirect_path" value="bmo_index.php">

        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Min Balance</label>
            <input type="number" step="0.01" class="form-control" name="min_balance" placeholder="0">
          </div>
          <div class="col-md-3">
            <label class="form-label">Max Balance</label>
            <input type="number" step="0.01" class="form-control" name="max_balance" placeholder="0">
          </div>
          <div class="col-md-3">
            <label class="form-label">Distribution</label>
            <select class="form-select" name="distribution">
              <option value="uniform">Uniform</option>
              <option value="normal">Normal</option>
              <option value="skew_high">Skew High</option>
              <option value="skew_low">Skew Low</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Step</label>
            <input type="number" step="0.01" class="form-control" name="step" placeholder="0">
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-md-3">
            <label class="form-label">Clamp Min</label>
            <input type="number" step="0.01" class="form-control" name="clamp_min" placeholder="0">
          </div>
          <div class="col-md-3">
            <label class="form-label">Clamp Max</label>
            <input type="number" step="0.01" class="form-control" name="clamp_max" placeholder="0">
          </div>
          <div class="col-md-3">
            <label class="form-label">Price Factor</label>
            <input type="number" step="0.01" class="form-control" name="price_factor" placeholder="1.0">
          </div>
          <div class="col-md-3 d-flex align-items-center">
            <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" id="recalcOnly" name="recalc_only">
              <label class="form-check-label" for="recalcOnly">Recalculate price only</label>
            </div>
          </div>
        </div>

        <div class="mt-3">
          <button class="btn btn-primary" type="submit">Apply</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Data Table -->
  <div class="card">
    <div class="card-header">BMO Records</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Balance</th>
              <th>Title</th>
              <th>Info</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              include 'dbcon.php';
              $query = "SELECT * FROM bmo ORDER BY id DESC";
              $query_run = mysqli_query($con, $query);
              if ($query_run && mysqli_num_rows($query_run) > 0):
                while ($user = mysqli_fetch_assoc($query_run)):
                  $balance = isset($user['Balance']) ? $user['Balance'] : (isset($user['balance']) ? $user['balance'] : '');
                  $title = isset($user['Title']) ? $user['Title'] : (isset($user['title']) ? $user['title'] : '');
            ?>
              <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($balance) ?></td>
                <td><?= htmlspecialchars($title) ?></td>
                <td><?= htmlspecialchars($user['info']) ?></td>
                <td><?= htmlspecialchars($user['price']) ?></td>
                <td>
                  <?php if (file_exists('bmo_edit.php')): ?>
                    <a href="bmo_edit.php?id=<?= urlencode($user['id']) ?>" class="btn btn-sm btn-info">Edit</a>
                  <?php endif; ?>
                  <?php if (file_exists('code_bmo.php')): ?>
                    <form action="code_bmo.php" method="POST" style="display:inline-block">
                      <button type="submit" name="delete_user" value="<?= htmlspecialchars($user['id']) ?>" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php
                endwhile;
              else:
            ?>
              <tr>
                <td colspan="6" class="text-center">No record found</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="static/vendor/jquery/jquery.min.js"></script>
<script src="static/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="static/js/select2.min.js"></script>
<script src="static/vendor/alertify/alertify.min.js"></script>
<script>
  // Info parts dynamic UI
  const infoPartsContainer = document.getElementById('infoPartsContainer');
  const addInfoPartBtn = document.getElementById('addInfoPartBtn');
  const infoPreview = document.getElementById('infoPreview');

  function renderPreview() {
    const parts = infoPartsContainer.querySelectorAll('.info-part');
    const lines = [];
    parts.forEach(part => {
      const label = part.querySelector('input[name="part_label[]"]').value.trim();
      const value = part.querySelector('input[name="part_value[]"]').value.trim();
      if (label || value) {
        lines.push(`${label}: ${value}`);
      }
    });
    infoPreview.textContent = lines.join('\n');
  }

  function addPart(label = '', value = '') {
    const wrapper = document.createElement('div');
    wrapper.className = 'info-part row g-2 mb-2';
    wrapper.innerHTML = `
      <div class=\"col-md-4\">
        <input type=\"text\" class=\"form-control\" name=\"part_label[]\" placeholder=\"Label\" value=\"${label}\">
      </div>
      <div class=\"col-md-6\">
        <input type=\"text\" class=\"form-control\" name=\"part_value[]\" placeholder=\"Value\" value=\"${value}\">
      </div>
      <div class=\"col-md-2\">
        <button type=\"button\" class=\"btn btn-outline-danger w-100 remove-part\">Remove</button>
      </div>`;
    infoPartsContainer.appendChild(wrapper);
    infoPartsContainer.dispatchEvent(new Event('change'));
  }

  addInfoPartBtn?.addEventListener('click', () => addPart());
  infoPartsContainer?.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-part')) {
      e.target.closest('.info-part').remove();
      renderPreview();
    }
  });
  infoPartsContainer?.addEventListener('change', renderPreview);
  // Seed one empty part
  addPart();
</script>
</body>
</html>