<?php
// Retrieve the values from the request
if (isset($_GET['selector'])) {
    $selector = $_GET['selector'];
    $iddb = $_GET['iddb'];
    $mid = $selector;
    $tablaname = "$iddb" . "_" . "$mid" . "_Timing";

    // Connect to the database
    $pdo = new PDO("mysql:host=localhost;dbname=mirai", "root", "");

    // Prepare the SQL query
    $query = "SELECT DATE FROM $tablaname";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch the dates and store in an array
    $dates = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dates[] = $row['DATE'];
    }

    // Return the dates as JSON
    echo json_encode($dates);
}
?>