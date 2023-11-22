<?php
    require_once 'config.php';
    global $db;

    session_start();
    if (isset($_POST['login'])) {
        try {
            $username = $_POST['username'];

            $query = $db->prepare('SELECT * FROM person WHERE username=:user');
            $query->bindValue(':user', $username, PDO::PARAM_STR);
            $query->execute();
            
            $user = $query->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if ($user['password'] === $_POST['pass']) {
                    $_SESSION['username'] = $_POST['username'];
                    header('Location: messages.php');
                    die();
                } else {
                    $error = 'Invalid username/password';
                }
            } else {
                $error = 'Invalid username/password';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>OreMessenger 2</title>
</head>
<body>
    <h1>Login</h1>
    <?php
    if (!empty($error)) {
        echo "<h2>" . $error . "</h2>";
    }
    ?>
    <form method="post">
        <input type="text" name="username" placeholder="Enter your username" />
        <input type="password" name="pass" placeholder="Enter password" />
        <button type="submit" name="login">Log in</button>
    </form>
</body>
</html>
