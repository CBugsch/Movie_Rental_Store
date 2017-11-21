<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 10:06 AM
 */

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("", "", "", "");
if (!$mysqli || $mysqli->connect_errno) {
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <link rel="stylesheet"
          type="text/css"
          href="style.css"/>

</head>
<body>

<div class="topnav">
    <a class="active" href="main.php">Movies</a>
    <a href="store.php">Stores Inventories</a>
    <a href="customer.php">Customer Transactions</a>
    <a href="employee.php">Employees</a>
</div>

<div class="wrapper">
    <?php
    if (!($stmt = $mysqli->prepare("SELECT dvd.title, dvd.id FROM dvd WHERE dvd.id = ?"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("i", $_POST['id']))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->bind_result($title, $did)) {
        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while ($stmt->fetch()) ;
    if (!($stmt = $mysqli->prepare("DELETE FROM dvd WHERE dvd.id = $did"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else {
        echo "<h1 class='a'>Removed " . $title . " from movies</h1>";
    }

    ?>
    <div>
        <a href="main.php" class="a">Back To Movies</a>
    </div>
</div>
</body>
</html>

