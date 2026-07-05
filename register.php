<?php
require_once 'Database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($pdo === null) {
    exit('Database connection failed.');
}

$requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? (empty($_POST) ? 'GET' : 'POST'));

if ($requestMethod === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password
    ]);

    echo '<div class="page-shell"><div class="card"><h1>Registration complete</h1><p class="subtitle">Your account has been created successfully.</p><p class="footer-link"><a href="user.php">Continue to sign in</a></p></div></div>';
} else {
    echo '<div class="page-shell"><div class="card"><h1>Create your account</h1><p class="subtitle">Join the demo and experience two-factor authentication.</p><form method="POST" action="register.php" class="auth-form"><label for="username">Username</label><input type="text" name="username" required><label for="email">Email</label><input type="email" name="email" required><label for="password">Password</label><input type="password" name="password" required><button type="submit">Register</button></form><p class="footer-link"><a href="user.php">Already have an account? Sign in</a></p></div></div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php echo $content ?? ''; ?>
</body>
</html>

