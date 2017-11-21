<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 9:31 PM
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
    if (!($stmt = $mysqli->prepare("SELECT employee.fname, employee.lname, employee.pnum, store.city, employee.id from employee
          INNER JOIN store on store.id = employee.sid
          WHERE employee.id = ?"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("i", $_POST['id']))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->bind_result($fname, $lname, $pnum, $city, $id)) {
        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    } else {
        while ($stmt->fetch()) {
            echo "<form method='POST' action='editEmployeeSubmit.php' class='form'>
            <fieldset class='fieldset'>
			<legend class='legend'>Edit Employee</legend>
            <legend>First Name</legend>
            <input class='select' title='fname' type='Text' name='fname' value='$fname' >

			<p><legend>Last Name</legend>
			<input class='select' title='lname' type='Text' name='lname' value='$lname'>
			</p>
			
			<p><legend>Phone Number</legend>
			<input class='select' title='pnum' type='Text' name='pnum' value='$pnum'>
			</p>";

            echo "<p><select class='select' name='city'>";
            $cityOptions = array('Seattle', 'Tacoma');
            foreach ($cityOptions as &$value) {
                if ($value == $city) {
                    echo "<option selected value='$value'>$value</option>";
                } else {
                    echo "<option value='$value'>$value</option>";
                }
            }
            unset($key);
            echo "</select></p>
            <input title='id' type = number name = 'id' value = '$id' style='display: none'>
            <input type='submit' value='Submit Edit'>
            </fieldset></form>";
        }
        $stmt->close();
    }

    ?>
    <div>
        <a href="employee.php" class="a">Back To Employees</a>
    </div>
</div>
</body>
</html>
