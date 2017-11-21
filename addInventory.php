<?php
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
    <a class="active" href="store.php">Stores Inventories</a>
    <a href="customer.php">Customer Transactions</a>
    <a href="employee.php">Employees</a>
</div>

<div class="wrapper">
    <?php
    $count = $_POST['count'];
    $did = $_POST['did'];
    $sid = $_POST['sid'];

    if (!($stmt = $mysqli->prepare("INSERT INTO inventory(did, sid, quantity) VALUES (?,?,?)"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("iii", $_POST['did'], $_POST['sid'], $_POST['count']))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    //if movie is already in inventory, update the quantity on-hand
    if (!$stmt->execute()) {
        if (!($stmt = $mysqli->prepare("SELECT inventory.quantity FROM inventory WHERE inventory.did = $did AND inventory.sid = $sid"))) {
            echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Select Execute failed";
        }
        if (!$stmt->bind_result($oldCount)) {
            echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;

        } else {
            while ($stmt->fetch()) ;
            $count += $oldCount;
            if (!($stmt = $mysqli->prepare("UPDATE inventory SET quantity=? WHERE inventory.did = $did AND inventory.sid = $sid"))) {
                echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
            }
            if (!($stmt->bind_param("i", $count))) {
                echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
            }
            if (!$stmt->execute()) {
                echo "Select Execute failed";
            } else {
                echo "<h1 class='a'>Updated inventory quantity</h1>";
            }
        }
    } else {
        echo "<h1 class='a'>Added movie to store's inventory succesfully</h1>";
    }


    ?>
    <div>
        <a href="store.php" class="a">Back To Store</a>
    </div>
</div>
</body>
</html>

