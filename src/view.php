<?php
require_once 'config.php';
global $db;

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    die();
}
$username = $_SESSION['username'];

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Browse messages</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<p></p>
<div>
    <a href="new.php">Reply message</a>
    <a href="messages.php">&lt; Return to message list</a>
</div>
</body>
</html>
