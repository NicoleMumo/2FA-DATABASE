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

        echo '<p>Your 2FA code is: <strong>' . $code . '</strong> (demo mode; it has also been written to 2fa.log)</p>';
        echo '<form method="POST" action="verify_2fa.php">
                  <label for="2fa_code">Enter the 2FA code sent to your email:</label>
                  <input type="text" name="2fa_code" required>
                  <button type="submit">Verify</button>
              </form>';
    } else {
        echo 'Invalid credentials';
    }
} else {
    echo '<form method="POST" action="user.php">
              <label for="username">Username:</label>
              <input type="text" name="username" required><br>
              <label for="password">Password:</label>
              <input type="password" name="password" required><br>
              <button type="submit">Login</button>
          </form>';
}
?>
