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

$html = '<div class="page-shell"><div class="card"><h1>Registered users</h1><p class="subtitle">A quick view of the accounts stored in the demo database.</p><ul class="user-list">';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $html .= '<li><strong>' . htmlspecialchars($row['username']) . '</strong><span>' . htmlspecialchars($row['email']) . '</span><small>' . htmlspecialchars($row['created_at']) . '</small></li>';
}
$html .= '</ul><p class="footer-link"><a href="index.html">Back to sign up</a></p></div></div>';

echo $html;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php echo $content ?? ''; ?>
</body>
</html>

