<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 8:45 PM
 */
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("", "", "", "");
if ($mysqli->connect_errno) {
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
$add = 0;
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
    <div>
        <table class="table">

            <h1 class="h1">Filtered Employees</h1>
            <tr class="row header green">
                <th class="cell">First Name</th>
                <th class="cell">Last Name</th>
                <th class="cell">Store Location</th>
            </tr>
            <?php
            if (!($stmt = $mysqli->prepare("SELECT employee.fname, employee.lname, store.city, employee.id from employee
          INNER JOIN store on store.id = employee.sid
          WHERE store.city = ?
          ORDER BY store.city ASC"))) {
                echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
            }
            if (!($stmt->bind_param("s", $_POST['city']))) {
                echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
            }
            if (!$stmt->execute()) {
                echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if (!$stmt->bind_result($fname, $lname, $city, $id)) {
                echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while ($stmt->fetch()) {
                echo "<tr class='row'>\n<td class='cell'>\n" . $fname . "\n</td>\n<td class='cell'>\n" . $lname . "\n</td>\n<td class='cell'>\n" . $city . "</td></tr>";
            }
            $stmt->close();
            ?>

        </table>

    </div>

    <a href="employee.php" class="a">Back to Employees</a>
</div>
</body>
</html>