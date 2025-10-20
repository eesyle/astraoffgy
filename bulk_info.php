<?php
// Shared bulk info update handler used across bank modules
// Mirrors AFCU's code_cufat.php bulk info logic: update all rows, random half, or compose info from parts

function handleBulkInfo(mysqli $con, string $table, string $redirectPath = 'index.php') {
    if (!isset($_POST['bulk_edit_info'])) {
        return; // nothing to do
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        $_SESSION['message'] = 'Invalid table name.';
        header('Location: ' . $redirectPath);
        exit;
    }

    $bulkMode = isset($_POST['bulk_mode']) ? $_POST['bulk_mode'] : 'all';
    $applyByParts = !empty($_POST['apply_by_parts']);

    $newInfo = '';
    if ($applyByParts && isset($_POST['info_parts']) && is_array($_POST['info_parts'])) {
        $parts = array_map(function($p){ return trim((string)$p); }, $_POST['info_parts']);
        $parts = array_filter($parts, function($p){ return $p !== ''; });
        $newInfo = implode('+', $parts);
    } else {
        $newInfo = isset($_POST['info_text']) ? trim((string)$_POST['info_text']) : '';
    }

    if ($newInfo === '') {
        $_SESSION['message'] = 'Info is empty — nothing to update';
        header('Location: ' . $redirectPath);
        exit;
    }

    $newInfoEsc = mysqli_real_escape_string($con, $newInfo);

    if ($bulkMode === 'all') {
        $query = "UPDATE `{$table}` SET info='{$newInfoEsc}'";
        $query_run = mysqli_query($con, $query);
        $_SESSION['message'] = $query_run ? 'Info updated for all rows' : 'Bulk update failed';
        header('Location: ' . $redirectPath);
        exit;
    }

    if ($bulkMode === 'half') {
        $countRes = mysqli_query($con, "SELECT COUNT(*) AS c FROM `{$table}`");
        $countRow = $countRes ? mysqli_fetch_assoc($countRes) : ['c' => 0];
        $count = (int)$countRow['c'];
        $limit = max(1, (int)ceil($count / 2));
        $idsRes = mysqli_query($con, "SELECT id FROM `{$table}` ORDER BY RAND() LIMIT {$limit}");
        $ids = [];
        if ($idsRes) {
            while ($r = mysqli_fetch_assoc($idsRes)) {
                $ids[] = (int)$r['id'];
            }
        }
        if (!empty($ids)) {
            $idList = implode(',', $ids);
            $query = "UPDATE `{$table}` SET info='{$newInfoEsc}' WHERE id IN ({$idList})";
            $query_run = mysqli_query($con, $query);
            $_SESSION['message'] = $query_run ? 'Info updated for random half of rows' : 'Bulk half update failed';
        } else {
            $_SESSION['message'] = 'No rows selected for half update';
        }
        header('Location: ' . $redirectPath);
        exit;
    }

    $_SESSION['message'] = 'No bulk mode selected';
    header('Location: ' . $redirectPath);
    exit;
}

?>