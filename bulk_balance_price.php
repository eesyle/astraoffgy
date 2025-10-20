<?php
// Shared bulk balance + price handler used across bank modules
// Implements autoscaled linear price curve anchored at (minBalance -> minPrice) and reaching exclusive cap
// Supports balance distribution modes: none, even_spread, step_increment

function handleBulkBalancePrice(mysqli $con, string $table, string $redirectPath = 'index.php') {
    if (!isset($_POST['bulk_edit_balance_price'])) {
        return; // nothing to do
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        $_SESSION['message'] = 'Invalid table name.';
        header('Location: ' . $redirectPath);
        exit;
    }

    $minBalance = isset($_POST['min_balance']) ? floatval($_POST['min_balance']) : 0.0;
    $minPrice   = isset($_POST['min_price']) ? floatval($_POST['min_price']) : 0.0;
    $maxPrice   = isset($_POST['max_price']) ? floatval($_POST['max_price']) : 0.0;
    $capPrice   = max(0.0, $maxPrice - 0.01); // strict exclusive cap below max

    $onlyRecalc = !empty($_POST['recalc_price_only']);
    $distribution = isset($_POST['balance_distribution']) ? strtolower(trim($_POST['balance_distribution'])) : 'none';
    $balanceStep  = isset($_POST['balance_step']) ? floatval($_POST['balance_step']) : 0.0;

    // Load all rows
    $rows = [];
    $q = $con->query("SELECT id, Balance FROM `{$table}` ORDER BY id ASC");
    if ($q) {
        while ($r = $q->fetch_assoc()) {
            $rows[] = $r;
        }
    }
    $rowCount = count($rows);
    if ($rowCount === 0) {
        $_SESSION['message'] = 'No rows found to update.';
        header('Location: ' . $redirectPath);
        exit;
    }

    // Observed extremes
    $obsMin = null; $obsMax = null;
    foreach ($rows as $r) {
        $b = floatval($r['Balance']);
        if ($obsMin === null || $b < $obsMin) $obsMin = $b;
        if ($obsMax === null || $b > $obsMax) $obsMax = $b;
    }

    // Determine new balance range and step based on distribution mode
    $evenStep = 0.0; $maxNewBal = $obsMax ?: $minBalance;
    if (!$onlyRecalc) {
        if ($distribution === 'even_spread') {
            if ($rowCount > 1) {
                // spread end just before cap-corresponding balance by ratio
                // use an intuitive spread width: if obsMax > minBalance, spread to obsMax; else spread to minBalance + rowCount
                $spreadEnd = ($obsMax && $obsMax > $minBalance) ? $obsMax : ($minBalance + ($rowCount - 1));
                $evenStep = ($spreadEnd - $minBalance) / ($rowCount - 1);
                $maxNewBal = $minBalance + $evenStep * ($rowCount - 1);
            } else {
                $evenStep = 0.0;
                $maxNewBal = $minBalance;
            }
        } elseif ($distribution === 'step_increment' && $balanceStep > 0) {
            $evenStep = $balanceStep;
            $maxNewBal = $minBalance + $evenStep * ($rowCount - 1);
        } else {
            // none: stick with observed values; allow min clamp
            $maxNewBal = max($obsMax, $minBalance);
        }
    } else {
        // onlyRecalc keeps balances as observed
        $maxNewBal = max($obsMax, $minBalance);
    }

    // Compute linear mapping from (minBalance->minPrice) to (maxNewBal->capPrice)
    $den = ($maxNewBal - $minBalance);
    if ($den <= 0.0) {
        $den = 1.0; // avoid divide-by-zero; flat slope will map everything to minPrice
    }
    $slope = ($capPrice - $minPrice) / $den;
    $intercept = $minPrice - $slope * $minBalance;

    // Apply updates
    $i = 0; $seenBalances = [];
    foreach ($rows as $r) {
        $id = intval($r['id']);
        $currentBalance = floatval($r['Balance']);
        $newBalance = $currentBalance;
        if (!$onlyRecalc) {
            if ($distribution === 'even_spread') {
                $newBalance = $minBalance + $evenStep * $i;
            } elseif ($distribution === 'step_increment' && $balanceStep > 0) {
                $newBalance = $minBalance + $balanceStep * $i;
            } else {
                // none: clamp minimum and keep existing
                if ($newBalance < $minBalance) {
                    $newBalance = $minBalance;
                }
            }
        }

        // enforce uniqueness by nudging duplicate balances slightly
        $key = number_format($newBalance, 4, '.', '');
        while (isset($seenBalances[$key])) {
            $newBalance += 0.01; // nudge by small step
            $key = number_format($newBalance, 4, '.', '');
        }
        $seenBalances[$key] = true;

        // Compute price by linear mapping and strict cap (< maxPrice)
        $price = $slope * $newBalance + $intercept;
        $price = round($price, 2);
        if ($price >= $maxPrice) {
            $price = $maxPrice - 0.01;
        }
        if ($price > $capPrice) {
            $price = $capPrice;
        }

        $nb = number_format($newBalance, 2, '.', '');
        $pr = number_format($price, 2, '.', '');

        $sql = "UPDATE `{$table}` SET Balance='{$nb}', price='{$pr}' WHERE id='{$id}' LIMIT 1";
        $con->query($sql);

        $i++;
    }

    $_SESSION['message'] = 'Bulk Balance & Price updated successfully.';
    header('Location: ' . $redirectPath);
    exit;
}

?>