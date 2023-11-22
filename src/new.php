<?php
require_once 'config.php';
global $db;

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    die();
}
$username = $_SESSION['username'];

$query = $db->prepare('SELECT * FROM person WHERE username=:user');
$query->bindValue(':user', $username);
$query->execute();

$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: index.php');
    die();
}

// Process form
if (isset($_POST['new'])) {
    $insert = $db->prepare('INSERT INTO message (body, username) VALUES (:body, :user)');
    $insert->bindValue(':body', $_POST['body']);
    $insert->bindValue(':user', $username);
    $insert->execute();
    header('Location: messages.php');
    die();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>New message</title>
</head>
<body>
    <h1>New message - <?= htmlentities($user['fullname']) ?></h1>
    <form method="post">
        <label for="text">Message body:</label><br/>
        <textarea id="text" name="body" rows="10" cols="50"></textarea>
        <br />
        <button type="submit" name="new">Create message</button>
        <a href="messages.php">&lt; Return to message list</a>
    </form>
</body>
</html>
