<?php
// Helper to shuffle banklog rows and show half per login cycle
// This file is intended to be included after $rows have been fetched

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Ensure we have rows to work with
if (!isset($rows) || !is_array($rows)) {
    return;
}

// Determine current user and page key for per-user/per-page behavior
$usernameKeyRaw = isset($username) && !empty($username)
    ? $username
    : (isset($_SESSION['username']) ? $_SESSION['username'] : 'guest');
// Sanitize for cookie-safe name component
$usernameKey = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $usernameKeyRaw);

$pageKeyRaw = basename($_SERVER['SCRIPT_NAME'], '.php');
$pageKey = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $pageKeyRaw);

$cookieName = "hl_last_half_{$pageKey}_{$usernameKey}";
$sessionKey = "hl_half_initialized_{$pageKey}_{$usernameKey}";

// Initialize half selection at first page view in this session, toggling across sessions
if (!isset($_SESSION[$sessionKey])) {
    $prevHalf = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : 'A';
    $currentHalf = ($prevHalf === 'A') ? 'B' : 'A';
    // Persist selection to cookie for next login cycle (30 days)
    // Must be sent before any output; ensure this file is included before HTML
    if (!headers_sent()) {
        setcookie($cookieName, $currentHalf, time() + 60 * 60 * 24 * 30, "/");
    }
    $_SESSION[$sessionKey] = $currentHalf;
} else {
    $currentHalf = $_SESSION[$sessionKey];
}

// Shuffle rows every page refresh and slice to the selected half
if (!empty($rows)) {
    shuffle($rows);
    $total = count($rows);
    $halfSize = (int) ceil($total / 2);
    if ($currentHalf === 'A') {
        $rows = array_slice($rows, 0, $halfSize);
    } else {
        $rows = array_slice($rows, $halfSize);
    }
}
