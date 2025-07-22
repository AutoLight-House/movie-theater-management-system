<?php
// Include the database connection file
include('../config.php');

// Check if the form has been submitted
if(isset($_POST['submit'])) {

    // Get the user's entered details
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Insert the new record into the database
    $stmt = $pdo->prepare("INSERT INTO movie_theatres (theatres) VALUES (:name)");
    $stmt->execute(['name' => $name]);
    
    // Redirect to the list page
    header('Location: ./Management_theatre.php');
    exit();
}

// Display the add record form
?>
<h2>Add New Contact</h2>

<form method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" required>
    </div>

    <button type="submit" name="submit">Add Contact</button>
</form>
