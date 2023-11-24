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
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    die();
}
if (isset($_POST['delete'])) {
    $query = $db->prepare('DELETE FROM message WHERE id=:id AND username=:user');
    $query->bindValue(':id', $_POST['delete'], PDO::PARAM_INT);
    $query->bindValue(':user', $username);
    $query->execute();
    header('Location: messages.php');
    die();
}
//var_dump($_POST);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Browse messages</title>
    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin-top: 1em;
            margin-bottom: 1em;
        }

        td, th {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Browse messages - <?= htmlentities($user['fullname']) ?></h1>
    <form method="post">
        <table>
            <thead>
            <tr>
                <th>Username</th>
                <th>Sender</th>
                <th>Message body</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $messages = $db->prepare('SELECT * FROM message WHERE recipient=:user');
            $messages->bindValue(':user', $username);
            $messages->setFetchMode(PDO::FETCH_ASSOC);
            $messages->execute();

            foreach ($messages as $message) {
                echo "<tr>";
                echo "<td>" . htmlentities($message['recipient']) . "</td>";
                echo "<td>" . htmlentities($message['username']) . "</td>";
                echo "<td>" . nl2br(htmlentities($message['body'])) . "</td>";
                echo "<td>";
                echo '<button type="submit" name="delete" value="' .
                    $message['id'] .
                    '">Delete</button>';
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <button type="submit" name="logout">Log out</button>
        <a href="new.php">New message</a>
    </form>
</body>
</html>
