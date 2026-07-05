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

    echo 'Registration successful!';
} else {
    echo '<form method="POST" action="register.php">
              <label for="username">Username:</label>
              <input type="text" name="username" required><br>
              <label for="email">Email:</label>
              <input type="email" name="email" required><br>
              <label for="password">Password:</label>
              <input type="password" name="password" required><br>
              <button type="submit">Register</button>
          </form>';
}
?>
