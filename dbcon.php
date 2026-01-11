<?php
// Central DB configuration with verbose debugging for hosting issues
// Do not print actual passwords; only indicate whether a password is set

// Enable mysqli exceptions to surface root cause
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$DB_HOST = getenv('DB_HOST') ?: 'localhost';

// Detect environment to choose correct credentials
// If on localhost and no env vars set, assume local XAMPP defaults
$is_local = (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1'));

if ($is_local && !getenv('DB_USER')) {
    // Local XAMPP Defaults
    $DB_USER = 'root';
    $DB_PASS = '';
    $DB_NAME = 'astraoffgy';
} else {
    // Production Defaults (Hostinger/Live Server)
    $DB_USER = getenv('DB_USER') ?: 'ahmlmzza_logix';
    $DB_PASS = getenv('DB_PASS') ?: 'Obedofla@00';
    $DB_NAME = getenv('DB_NAME') ?: 'ahmlmzza_logix';
}

// Optional debug banner (only when explicitly enabled)
if (defined('HLX_SHOW_DEBUG') && HLX_SHOW_DEBUG) {
    echo "<pre style=\"background:#102a43;color:#dceefb;padding:8px;margin:0;\">" 
       . "DB CONNECT: host=$DB_HOST user=$DB_USER db=$DB_NAME password_set=" . ($DB_PASS !== '' ? 'yes' : 'no') 
       . "</pre>";
}

try {
    // Use $con instead of $conn to match application variable naming
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $con->set_charset('utf8mb4');
} catch (Throwable $e) {
    echo "<pre style=\"background:#1b2938;color:#ff6b6b;padding:10px;\">DB CONNECT ERROR: " 
        . htmlspecialchars($e->getMessage()) . "\n" 
        . "Host: $DB_HOST\nUser: $DB_USER\nDB: $DB_NAME\nPassword set: " . ($DB_PASS !== '' ? 'yes' : 'no') 
        . "</pre>";
    exit;
}
?>