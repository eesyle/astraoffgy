<?php
session_start();
require 'dbcon.php';

if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['delete_student']);

    $query = "DELETE FROM afcu WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Account Deleted Successfully";
        header("Location: cufat_index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Deleted";
        header("Location: cufat_index.php");
        exit(0);
    }
}

// Bulk Info update handler: apply to all rows, random half, or by parts
if (isset($_POST['bulk_edit_info'])) {
    $bulkMode = isset($_POST['bulk_mode']) ? $_POST['bulk_mode'] : 'all';
    $applyByParts = isset($_POST['apply_by_parts']) ? 1 : 0;

    $newInfo = '';
    if ($applyByParts && isset($_POST['info_parts']) && is_array($_POST['info_parts'])) {
        $parts = array_map('trim', $_POST['info_parts']);
        $parts = array_filter($parts, function($p){ return $p !== ''; });
        $newInfo = implode('+', $parts);
    } else {
        $newInfo = isset($_POST['info_text']) ? trim($_POST['info_text']) : '';
    }

    if ($newInfo === '') {
        $_SESSION['message'] = 'Info is empty — nothing to update';
        header('Location: cufat_index.php');
        exit(0);
    }

    $newInfoEsc = mysqli_real_escape_string($con, $newInfo);

    if ($bulkMode === 'all') {
        $query = "UPDATE afcu SET info='$newInfoEsc'";
        $query_run = mysqli_query($con, $query);
        $_SESSION['message'] = $query_run ? 'Info updated for all rows' : 'Bulk update failed';
        header('Location: cufat_index.php');
        exit(0);
    }

    if ($bulkMode === 'half') {
        $countRes = mysqli_query($con, "SELECT COUNT(*) AS c FROM afcu");
        $countRow = $countRes ? mysqli_fetch_assoc($countRes) : ['c' => 0];
        $count = (int)$countRow['c'];
        $limit = max(1, (int)ceil($count / 2));
        $idsRes = mysqli_query($con, "SELECT id FROM afcu ORDER BY RAND() LIMIT $limit");
        $ids = [];
        if ($idsRes) {
            while ($r = mysqli_fetch_assoc($idsRes)) {
                $ids[] = (int)$r['id'];
            }
        }
        if (!empty($ids)) {
            $idList = implode(',', $ids);
            $query = "UPDATE afcu SET info='$newInfoEsc' WHERE id IN ($idList)";
            $query_run = mysqli_query($con, $query);
            $_SESSION['message'] = $query_run ? 'Info updated for random half of rows' : 'Bulk half update failed';
        } else {
            $_SESSION['message'] = 'No rows selected for half update';
        }
        header('Location: cufat_index.php');
        exit(0);
    }

    $_SESSION['message'] = 'No bulk mode selected';
    header('Location: cufat_index.php');
    exit(0);
}

// Bulk Balance & Price update handler: apply correlated logic across rows
if (isset($_POST['bulk_edit_balance_price'])) {
    $minBalance = isset($_POST['min_balance']) ? floatval(preg_replace('/[^0-9.]/','', $_POST['min_balance'])) : 0;
    $minPrice   = isset($_POST['min_price']) ? floatval(preg_replace('/[^0-9.]/','', $_POST['min_price'])) : 0;
    $maxPrice   = isset($_POST['max_price']) ? floatval(preg_replace('/[^0-9.]/','', $_POST['max_price'])) : 1000; // cap
    $clampBalance = isset($_POST['clamp_balance']) ? 1 : 0; // if true, raise balances below minBalance up to minBalance
    $recalcPriceOnly = isset($_POST['recalc_price_only']) ? 1 : 0; // if true, only update price

    if ($minBalance <= 0 || $minPrice <= 0) {
        $_SESSION['message'] = 'Minimum balance/price must be positive values';
        header('Location: cufat_index.php');
        exit(0);
    }
    if ($maxPrice <= 0) { $maxPrice = 1000; }

    // Strict cap: price must be < maxPrice (exclusive) and > minPrice
    $capPrice = $maxPrice - 0.01; // 2-decimal resolution
    if ($capPrice <= $minPrice) {
        $_SESSION['message'] = 'Maximum price must be greater than minimum price (exclusive)';
        header('Location: cufat_index.php');
        exit(0);
    }

    $ratio = $minPrice / $minBalance; // keep price proportional to balance anchored at minima

    // Autoscale mapping: spread prices linearly from (minBalance->minPrice) to (maxBalance->capPrice)
    $maxBalRow = mysqli_query($con, "SELECT MAX(Balance) AS maxBal FROM afcu");
    $maxBalStr = '0';
    if ($maxBalRow && mysqli_num_rows($maxBalRow) > 0) {
        $maxBalAssoc = mysqli_fetch_assoc($maxBalRow);
        $maxBalStr = isset($maxBalAssoc['maxBal']) ? $maxBalAssoc['maxBal'] : '0';
    }
    $maxBalNum = floatval(preg_replace('/[^0-9.]/','', $maxBalStr));
    $maxNewBal = $clampBalance ? max($maxBalNum, $minBalance) : $maxBalNum;

    if ($maxNewBal > $minBalance) {
        $slope = ($capPrice - $minPrice) / ($maxNewBal - $minBalance);
        $intercept = $minPrice - $slope * $minBalance;
    } else {
        // Fallback to ratio mapping when range collapses
        $slope = $ratio;
        $intercept = 0;
    }

    $maxAllowedBal = floor((($capPrice - $intercept) / max($slope, 1e-9)) * 100) / 100; // ensure price < maxPrice under linear mapping

    // Balance distribution options and precomputed steps
    $distribution = isset($_POST['balance_distribution']) ? $_POST['balance_distribution'] : 'none';
    $balanceStep = isset($_POST['balance_step']) ? floatval(preg_replace('/[^0-9.]/','', $_POST['balance_step'])) : 0;
    if ($balanceStep < 0) { $balanceStep = 0; }
    $countRes = mysqli_query($con, "SELECT COUNT(*) AS c FROM afcu");
    $countRow = $countRes ? mysqli_fetch_assoc($countRes) : ['c' => 0];
    $n = max(1, (int)$countRow['c']);
    $evenStep = ($maxAllowedBal - $minBalance) / max(1, $n - 1);

    $res = mysqli_query($con, "SELECT id, Balance FROM afcu");
    $updated = 0;
    if ($res) {
        $seen = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $idRaw = $row['id'];
            $id = mysqli_real_escape_string($con, $idRaw);
            $balStr = isset($row['Balance']) ? $row['Balance'] : '0';
            $balNum = floatval(preg_replace('/[^0-9.]/','', $balStr));

            // Systematic balance generation in correspondence with prices
            static $i = 0;
            if (!$recalcPriceOnly) {
                if ($distribution === 'even_spread') {
                    $candidate = $minBalance + $i * $evenStep;
                    $newBal = round(min(max($candidate, $minBalance), $maxAllowedBal), 2);
                } elseif ($distribution === 'step_increment' && $balanceStep > 0) {
                    $candidate = $minBalance + $i * $balanceStep;
                    $newBal = round(min(max($candidate, $minBalance), $maxAllowedBal), 2);
                } else {
                    // Default behavior: clamp and enforce uniqueness with epsilon nudging
                    $newBal = $clampBalance ? max($balNum, $minBalance) : $balNum;
                    $newBal = min($newBal, $maxAllowedBal);
                    $key = sprintf("%.2f", $newBal);
                    if (isset($seen[$key])) {
                        $epsilon = 0.01;
                        $attempts = 0;
                        $adj = $newBal;
                        while (isset($seen[sprintf("%.2f", $adj)]) && $attempts < 5000) {
                            $adj += $epsilon;
                            if ($adj > $maxAllowedBal) { break; }
                            $attempts++;
                        }
                        if (isset($seen[sprintf("%.2f", $adj)]) || $adj > $maxAllowedBal) {
                            $adj = min(max($adj - $epsilon, $minBalance), $maxAllowedBal);
                        }
                        $newBal = round($adj, 2);
                    }
                    $seen[sprintf("%.2f", $newBal)] = true;
                }
                $i++;
            } else {
                $newBal = $clampBalance ? max($balNum, $minBalance) : $balNum;
            }

            // Autoscaled linear mapping to avoid clustering at cap; still strictly below maxPrice
            $computedLin = $slope * $newBal + $intercept;
            $newPrice = min($capPrice, round($computedLin, 2));

            $newBalEsc = mysqli_real_escape_string($con, (string)$newBal);
            $newPriceEsc = mysqli_real_escape_string($con, (string)$newPrice);

            if ($recalcPriceOnly) {
                $u = mysqli_query($con, "UPDATE afcu SET price='$newPriceEsc' WHERE id='$id'");
            } else {
                $u = mysqli_query($con, "UPDATE afcu SET Balance='$newBalEsc', price='$newPriceEsc' WHERE id='$id'");
            }
            if ($u) { $updated++; }
        }
        $_SESSION['message'] = $recalcPriceOnly
            ? ("Recalculated prices for $updated rows (cap < $maxPrice)")
            : ("Updated balance & price for $updated rows (unique balances, cap < $maxPrice)");
    } else {
        $_SESSION['message'] = 'Failed to load rows for bulk update';
    }

    header('Location: cufat_index.php');
    exit(0);
}

if(isset($_POST['update_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $balance = mysqli_real_escape_string($con, $_POST['Balance']);
    $title = mysqli_real_escape_string($con, $_POST['Title']);
    $info = mysqli_real_escape_string($con, $_POST['info']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

    $query = "UPDATE afcu SET  id = '$id', Balance='$balance', Title='$title', info='$info', price='$price' WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Account Updated Successfully";
        header("Location: cufat_index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Updated";
        header("Location: cufat_index.php");
        exit(0);
    }
    if(isset($_POST['save_student']))
{   
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $balance = mysqli_real_escape_string($con, $_POST['Balance']);
    $title = mysqli_real_escape_string($con, $_POST['Title']);
    $info = mysqli_real_escape_string($con, $_POST['info']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

    $query = "INSERT INTO afcu VALUES".
"('$id','$balance','$title','$info','$price')";
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Account Created Successfully";
        header("Location: create_cufat.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Created";
        header("Location: create_cufat.php");
        exit(0);
    }

}

}
