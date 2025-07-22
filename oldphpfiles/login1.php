<?php
session_start();
require_once('../config.php');

if(isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE niganame = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../index.php');
        exit();
    } else {
        $error_message = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <?php if(isset($error_message)) { ?>
        <div><?php echo $error_message; ?></div>
    <?php } ?>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username">
        <br>
        <label>Password:</label>
        <input type="password" name="password">
        <br>
        <button type="submit">Login</button>
    </form>
    <a href="./registration.php">Register</a>
</body>
</html>
