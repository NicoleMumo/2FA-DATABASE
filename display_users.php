<?php
require_once 'Database.php';
require_once 'User.php';

$database = new Database();
$db = $database->getConnection();

if ($db === null) {
    exit('Database connection failed.');
}

$user = new User($db);
$stmt = $user->read();

if ($stmt === null) {
    exit('Unable to read users.');
}

echo '<h2>Registered Users</h2>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo 'Username: ' . htmlspecialchars($row['username']) . ', Email: ' . htmlspecialchars($row['email']) . ', Created At: ' . htmlspecialchars($row['created_at']) . '<br>';
}
?>
