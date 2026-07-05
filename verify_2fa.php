<?php
session_start();

$requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? (empty($_POST) ? 'GET' : 'POST'));

if ($requestMethod === 'POST') {
    $entered_code = trim($_POST['2fa_code'] ?? '');
    $saved_code = $_SESSION['2fa_code'] ?? null;

    if ($entered_code !== '' && $saved_code !== null && $entered_code == $saved_code) {
        unset($_SESSION['2fa_code']);
        echo '<div class="page-shell"><div class="card"><h1>Authentication complete</h1><p class="subtitle">You have successfully verified your identity.</p><p class="footer-link"><a href="display_users.php">View registered users</a></p></div></div>';
    } else {
        echo '<div class="page-shell"><div class="card"><h1>Verification failed</h1><p class="subtitle">The code you entered was incorrect.</p><p class="footer-link"><a href="user.php">Try again</a></p></div></div>';
    }
} else {
    echo '<div class="page-shell"><div class="card"><h1>Verification required</h1><p class="subtitle">Please submit a 2FA code.</p><p class="footer-link"><a href="user.php">Back to sign in</a></p></div></div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php echo $content ?? ''; ?>
</body>
</html>

