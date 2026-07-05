<?php
session_start();

$requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? (empty($_POST) ? 'GET' : 'POST'));

if ($requestMethod === 'POST') {
    $entered_code = trim($_POST['2fa_code'] ?? '');
    $saved_code = $_SESSION['2fa_code'] ?? null;

    if ($entered_code !== '' && $saved_code !== null && $entered_code == $saved_code) {
        unset($_SESSION['2fa_code']);
        echo 'Login successful!';
    } else {
        echo 'Invalid 2FA code. Please try again.';
    }
} else {
    echo 'Please submit a 2FA code.';
}
?>
