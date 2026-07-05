<?php
require_once 'Database.php';

session_start();

$database = new Database();
$pdo = $database->getConnection();

if ($pdo === null) {
    exit('Database connection failed.');
}

function send2FACode($email, $code) {
    $logFile = __DIR__ . '/2fa.log';
    $entry = date('Y-m-d H:i:s') . ' | ' . $email . ' | ' . $code . PHP_EOL;
    file_put_contents($logFile, $entry, FILE_APPEND);
}

$requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? (empty($_POST) ? 'GET' : 'POST'));

if ($requestMethod === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $code = rand(100000, 999999);

        $_SESSION['2fa_code'] = $code;
        $_SESSION['username'] = $username;

        send2FACode($user['email'], $code);

        echo '<div class="page-shell"><div class="card"><h1>Verify your identity</h1><p class="subtitle">A 6-digit code has been generated for demo purposes and saved to 2fa.log.</p><p class="code-box">Your code: <strong>' . $code . '</strong></p><form method="POST" action="verify_2fa.php" class="auth-form"><label for="2fa_code">Enter the code</label><input type="text" name="2fa_code" required><button type="submit">Verify</button></form></div></div>';
    } else {
        echo '<div class="page-shell"><div class="card"><h1>Sign in</h1><p class="subtitle">Use your demo account credentials.</p><form method="POST" action="user.php" class="auth-form"><label for="username">Username</label><input type="text" name="username" required><label for="password">Password</label><input type="password" name="password" required><button type="submit">Login</button></form><p class="message error">Invalid credentials</p><p class="footer-link"><a href="index.html">Create an account</a></p></div></div>';
    }
} else {
    echo '<div class="page-shell"><div class="card"><h1>Sign in</h1><p class="subtitle">Use your demo account credentials.</p><form method="POST" action="user.php" class="auth-form"><label for="username">Username</label><input type="text" name="username" required><label for="password">Password</label><input type="password" name="password" required><button type="submit">Login</button></form><p class="footer-link"><a href="index.html">Create an account</a></p></div></div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Sign In</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php echo $content ?? ''; ?>
</body>
</html>

