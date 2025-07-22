<?php
session_start();
require_once('../config.php');

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check if username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE niganame = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $email_exists = $stmt->fetch();

    if($user) {
        $error_message = 'Username already exists';
    } else if($email_exists) {
        $error_message = 'Email already exists';
    } else {
        // insert new user into database
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (fname, lname, niganame, email, password) VALUES (:first_name, :last_name, :username, :email, :password)");
        $stmt->execute(['first_name' => $first_name, 'last_name' => $last_name, 'username' => $username, 'email' => $email, 'password' => $password_hash]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        header('Location: ../index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h1>Registration</h1>
    <?php if(isset($error_message)) { ?>
        <div><?php echo $error_message; ?></div>
    <?php } ?>
    <form method="POST" action="">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required><br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br><br>
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        <label for="email">Email Address:</label>
        <input type="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>

    <a href="./login.php">Login</a>

</body>
</html>
