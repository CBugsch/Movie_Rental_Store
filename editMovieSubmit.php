<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 1:33 PM
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

    if (!($stmt = $mysqli->prepare("UPDATE dvd SET title=?, genre=?, rating=?, year=?, length=? WHERE id=?"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("sssiii", $_POST['title'], $_POST['genre'], $_POST['rating'], $_POST['year'], $_POST['length'], $_POST['id']))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else {
        echo "<h1 class='a'>Edited " . $_POST['title'] . " successfully</h1>";
    }


    ?>
    <div>
        <a href="main.php" class="a">Back To Movies</a>
    </div>
</div>
</body>
</html>
