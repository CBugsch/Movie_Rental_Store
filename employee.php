<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 8:17 PM
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

            <h1 class="h1">Employees</h1>
            <tr class="row header green">
                <th class="cell">First Name</th>
                <th class="cell">Last Name</th>
                <th class="cell">Phone Number</th>
                <th class="cell">Store Location</th>
                <th class="cell">Alter</th>
            </tr>
            <?php
            if (!($stmt = $mysqli->prepare("SELECT employee.fname, employee.lname, employee.pnum, store.city, employee.id from employee
          INNER JOIN store on store.id = employee.sid
          ORDER BY store.city ASC"))) {
                echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
            }

            if (!$stmt->execute()) {
                echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if (!$stmt->bind_result($fname, $lname, $pnum, $city, $id)) {
                echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while ($stmt->fetch()) {
                echo "<tr class='row'>\n
                <td class='cell'>\n" . $fname . "\n</td>\n
                <td class='cell'>\n" . $lname . "\n</td>
                <td class='cell'>$pnum</td>\n
                <td class='cell'>\n" . $city . "</td>  
                <td class='cell'>
                    <form method=" . "POST " . "action=" . "editEmployee.php" . " >
                    <input type='number' name='id' value = $id style='display: none'/>
                    <input type= submit value=Edit style='width: 100%'/>
                    </form>
                    <form method=" . "POST " . "action=" . "employeeRemove.php" . ">
                    <input type='text' name='fname' value = $fname style='display: none'/>
                    <input type='text' name='lname' value = $lname style='display: none'/>
                    <input type='number' name='id' value = $id style='display: none'/>
                    <input type= submit value=Remove style='width: 100%'/>
                    </form>
                </td></tr>";
            }
            $stmt->close();
            ?>

        </table>

    </div>

    <div>
        <form method="POST" action="addEmployee.php" class="form">

            <fieldset class="fieldset">
                <legend class="legend">Add Employee</legend>
                <legend>First Name</legend>
                <input title="fname" type="text" name="fname" class="select"/>

                <p>
                    <legend>Last Name</legend>
                    <input title="lname" type="text" name="lname" class="select"/>
                </p>

                <p>
                    <legend>Phone Number</legend>
                    <input title="pnum" type="text" name="pnum" class="select"/>
                </p>

                <p>
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT store.city, store.id from store"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($city, $sid)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    echo "<select name=sid class='select'>";
                    while ($stmt->fetch()) {
                        echo "<option value='$sid'>$city</option>";
                    }
                    echo "</select>";
                    $stmt->close();
                    ?>
                </p>
                <input type="submit" value="Add New Employee"/>
            </fieldset>

        </form>
    </div>
    <div>
        <form method="POST" action="filterEmployee.php" class="form">
            <fieldset class="fieldset">
                <legend class="fieldset">Filter By</legend>
                Location:
                <select name="city" class="select">
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT store.city FROM store GROUP BY store.city"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($city)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while ($stmt->fetch()) {
                        echo '<option value="' . $city . '"> ' . $city . '</option>\n';
                    }
                    $stmt->close();
                    ?>
                </select>
                <br>
                <input type="submit" value="Run Filter"/>
            </fieldset>

        </form>
    </div>
</div>

<a href="customer.php">Customer Transactions</a>
</body>
</html>