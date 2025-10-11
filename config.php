<?php
// Central DB configuration with verbose debugging for hosting issues
// Do not print actual passwords; only indicate whether a password is set

// Prefer environment variables when available (configure in Hostinger hPanel):
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'astraoffgy';

// Hostinger commonly uses account‑prefixed DB names/users like uXXXXX_db, adjust here if needed.
// Example:
// $DB_HOST = 'localhost';
// $DB_USER = 'u468359497_hold';
// $DB_PASS = 'YOUR_DB_PASSWORD';
// $DB_NAME = 'u468359497_hold';

// Enable mysqli exceptions to surface root cause
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Optional debug banner (only when explicitly enabled)
if (defined('HLX_SHOW_DEBUG') && HLX_SHOW_DEBUG) {
    echo "<pre style=\"background:#102a43;color:#dceefb;padding:8px;margin:0;\">"
       . "DB CONNECT: host=$DB_HOST user=$DB_USER db=$DB_NAME password_set=" . ($DB_PASS !== '' ? 'yes' : 'no')
       . "</pre>";
}

try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset('utf8mb4');
} catch (Throwable $e) {
    echo "<pre style=\"background:#1b2938;color:#ff6b6b;padding:10px;\">DB CONNECT ERROR: "
        . htmlspecialchars($e->getMessage()) . "\n"
        . "Host: $DB_HOST\nUser: $DB_USER\nDB: $DB_NAME\nPassword set: " . ($DB_PASS !== '' ? 'yes' : 'no')
        . "</pre>";
    exit;
}