<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 4:18 PM
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
    <a class="active" href="customer.php">Customer Transactions</a>
    <a href="employee.php">Employees</a>
</div>

<div class="wrapper">
    <?php

    //Save values from post for use in multiple inserts
    $rid = $_POST['rid'];
    $did = $_POST['did'];
    $sid = $_POST['sid'];
    $cid = $_POST['cid'];
    $date = $_POST['date'];

    if (!($stmt = $mysqli->prepare("INSERT INTO rental_details(did, rid) VALUES (?,?)"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("ii", $did, $rid))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else echo "<h1 class='a'>Row added to rental_details</h1>";

    //store id from rental_details
    $rdid = mysqli_insert_id($mysqli);
    //echo $rdid;
    if (!($stmt = $mysqli->prepare("INSERT INTO transaction(sid, cid, date) VALUES (?,?,?)"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("iis", $sid, $cid, $date))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else {
        echo "<h1 class='a'>Row added to transaction</h1>";
    }


    //Store id from last insert
    $tid = mysqli_insert_id($mysqli);
    //echo $tid;
    if (!($stmt = $mysqli->prepare("INSERT INTO transaction_details(tid, rid) VALUES (?,?)"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("ii", $tid, $rdid))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else echo "<h1 class='a'>Row added to transaction_details</h1>";

    ?>
    <div>
        <a href="customer.php" class="a">Back To Customers</a>
    </div>
</div>
</body>
</html>

