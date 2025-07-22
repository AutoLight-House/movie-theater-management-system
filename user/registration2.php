<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is already logged in
if(isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Check if the registration form has been submitted
if(isset($_POST['submit'])) {

    // Include the database connection file
    include('../config.php');

    // Get the user's entered details
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username or email already exists in the database
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    $user = $stmt->fetch();

    // If the username or email already exists, display an error message
    if($user) {
        if($user['username'] == $username) {
            $error = "Username already exists.";
        } else {
            $error = "Email already exists.";
        }
    } else {
        // If the username and email are unique, insert the new user into the database and set the user_id session variable
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (fname, lname, email, username, password) VALUES (:first_name, :last_name, :email, :username, :password)");
        $stmt->execute(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'username' => $username, 'password' => $hashed_password]);
        $user_id = $pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        header('Location: ../index.php');
        exit();
    }
}

// Display the registration form
include('../index.php');
?>

<h2>Register</h2>

<?php if(isset($error)): ?>
    <div style="color: red;"><?php echo $error; ?></div>
<?php endif; ?>

<form method="post">
    <div>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required>
    </div>
    <div>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" name="submit">Register</button>
</form>
