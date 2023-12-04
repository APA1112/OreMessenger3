<?php
require_once 'config.php';
global $db;
global $id;

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    die();
}
if (isset($_GET['id'])){
    $id = $_GET['id'];
}
$username = $_SESSION['username'];

$messages = $db->prepare('SELECT * FROM message WHERE id=:id');
$messages->bindValue(':id', $id);
$messages->setFetchMode(PDO::FETCH_ASSOC);
$messages->execute();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Browse messages</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
foreach ($messages as $message){
    echo "<p>". $message['body']."</p>";
}
echo "<div>";
echo "<a href='new.php?id=".$id."'>Reply message</a>";
echo "<a href='messages.php'>&lt; Return to message list</a>";
echo "</div>";
?>
</body>
</html>
