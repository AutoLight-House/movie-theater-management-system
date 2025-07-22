<?php
// Include the config file
require_once('../config.php');

// Function to connect to the database
function connect() {
    global $host, $dbname, $username, $password;
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

// Function to get all rows from the table
function getAllRows() {
    $pdo = connect();
    $stmt = $pdo->query("SELECT * FROM movie_theatres");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

// Function to create a new row
function createRow($name, $email) {
    $pdo = connect();
    $stmt = $pdo->prepare("INSERT INTOmovie_theatres (theatres) VALUES (:name)");
    $stmt->execute(['name' => $name]);
}

// Function to read a row by ID
function readRow($id) {
    $pdo = connect();
    $stmt = $pdo->prepare("SELECT * FROM movie_theatres WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

// Function to update a row by ID
function updateRow($id, $name, $email) {
    $pdo = connect();
    $stmt = $pdo->prepare("UPDATE movie_theatres SET theatres = :name WHERE id = :id");
    $stmt->execute(['id' => $id, 'name' => $name]);
}

// Function to delete a row by ID
function deleteRow($id) {
    $pdo = connect();
    $stmt = $pdo->prepare("DELETE FROM theatres WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
?>
