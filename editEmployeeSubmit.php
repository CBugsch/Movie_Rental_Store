<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 9:49 PM
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
    <a href="main.php">Movies</a>
    <a href="store.php">Stores Inventories</a>
    <a href="customer.php">Customer Transactions</a>
    <a class="active" href="employee.php">Employees</a>
</div>

<div class="wrapper">
    <?php
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $pnum = $_POST['pnum'];
    $eid = $_POST['id'];

    if (!($stmt = $mysqli->prepare("SELECT store.id FROM store WHERE store.city = ?"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("s", $_POST['city']))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->bind_result($sid)) {
        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while ($stmt->fetch()) ;

    if (!($stmt = $mysqli->prepare("UPDATE employee SET fname=?, lname=?, pnum=?, sid=? WHERE id=?"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("sssii", $fname, $lname, $pnum, $sid, $eid))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else {
        echo "<h1 class='a'>Edited " . $fname . " " . $lname . " successfully</h1>";
    }


    ?>
    <div>
        <a href="employee.php" class="a">Back To Employees</a>
    </div>
</div>
</body>
</html>
