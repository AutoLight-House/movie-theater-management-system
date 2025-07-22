<?php
  include('config.php')


?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Success</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h1>Booking Successful</h1>

    <h3>Booking Details:</h3>

    <table class="table table-bordered mt-4">
      <thead>
        <tr>
          <th scope="col">Ticket Type</th>
          <th scope="col">Quantity</th>
          <th scope="col">Price</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Retrieve booking details from the query parameters
        $banda = $_GET['banda'];
        $jagah = $_GET['jagah'];
        $midi = $_GET['midi'];
        $datei = $_GET['datei'];
        $timeii = $_GET['timeii'];
        $tiki = $_GET['tiki'];
        $kidoo = $_GET['kidoo'];
        $kelass = $_GET['kelass'];
        ?>

        <tr>
          <td>Regular Ticket</td>
          <td><?php echo $tiki; ?></td>
          <td>$<?php echo $kelass*$tiki; ?></td>
        </tr>
        <tr>
          <td>Kids Ticket</td>
          <td><?php echo $kidoo; ?></td>
          <td>$<?php echo $kidoo*$kelass * 0.7; ?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2" class="text-right">Total (USD)</td>
          <td>$<?php echo $tiki * $kelass + $kidoo * ($kelass * 0.7); ?></td>
        </tr>
      </tfoot>
    </table>

    <h3>Ticket Booking Information:</h3>
    <p><strong>Booking ID:</strong> Will be Generated in A few Minutes Please Check in My Bookings and when you visit the theatre please tell the Booking ID to get your tickets</p>
    <p><strong>Name:</strong> <?php echo $banda; ?></p>
    <p><strong>Location:</strong> <?php echo $jagah; ?></p>
    <?php
$query = "SELECT * FROM $jagah WHERE ID = :midi";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':midi', $midi, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>

    <p><strong>Movie Name:</strong> <?php echo $row['Name']; ?></p>
    
    <?php
}
?>
<p><strong>Movie Date:</strong> <?php echo $datei; ?></p>
<p><strong>Movie Time:</strong> <?php echo $timeii; ?></p>
  </div>
  <p><strong><a href="index.php">Return to Home Page</a></strong></p>
  <p><strong><a href="mybook.php?thtid=<?php echo$jagah  ?>">My Bookings</a></strong></p>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
