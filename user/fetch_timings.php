<?php
// Retrieve the values from the request
if (isset($_GET['selector'])) {
    $selector = $_GET['selector'];
    $iddb = $_GET['iddb'];
    $datei = $_GET['date'];
    $mid = $_GET['selector'];
    $tablaname = "$iddb" . "_" . "$mid" . "_Timing";
    $temeName = $iddb . '_' . $mid . '_' . $datei . '_Timing';

    // Connect to the database
    $pdo = new PDO("mysql:host=localhost;dbname=mirai", "root", "");

    // Prepare the SQL query
    $query = "SELECT * FROM $temeName"; // Updated query to select "Timings" column
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch the timings and store in an array
    $timings = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $timings[] = $row['Timings'];
    }

    // Return the timings as JSON
    echo json_encode($timings);
}
?>
