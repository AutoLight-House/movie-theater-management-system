<?php
$host = 'localhost';
$dbName = 'mirai';
$username = 'root';
$password = '';

try {
    $con = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully!";

    $banda = $_GET['banda'];
    $bandaid = $_GET['bandaid'];
    $jagah = $_GET['jagah'];
    $midi = $_GET['midi'];
    $datei = $_GET['datei'];
    $timeii = $_GET['timeii'];
    $tiki = $_GET['tiki'];
    $kidoo = $_GET['kidoo'];
    $kelass = $_GET['kelass'];

    // Prepare the INSERT query
    $insertQuery = "INSERT INTO `bookings` (`uid`, `user`, `location`, `mid`, `DATE`, `TIME`, `Rticket`, `Kticket`, `kelass`) 
                   VALUES (:uid, :user, :location, :mid, :date, :time, :Rticket, :Kticket, :kelass)";
    $insertStmt = $con->prepare($insertQuery);

    // Bind the values to the prepared statement
    $insertStmt->bindParam(':user', $banda);
    $insertStmt->bindParam(':uid', $bandaid);
    $insertStmt->bindParam(':location', $jagah);
    $insertStmt->bindParam(':mid', $midi);
    $insertStmt->bindParam(':date', $datei);
    $insertStmt->bindParam(':time', $timeii);
    $insertStmt->bindParam(':Rticket', $tiki);
    $insertStmt->bindParam(':Kticket', $kidoo);
    $insertStmt->bindParam(':kelass', $kelass);

    // Execute the statement
    if ($insertStmt->execute()) {
        echo "<script> window.location.href='success.php?banda=$banda&jagah=$jagah&midi=$midi&datei=$datei&timeii=$timeii&tiki=$tiki&kidoo=$kidoo&kelass=$kelass';</script>";
    } else {
        echo "Failed";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
