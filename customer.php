<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 7:43 PM
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
    <a class="active" href="customer.php">Customer Transactions</a>
    <a href="employee.php">Employees</a>
</div>

<div class="wrapper">


    <div>
        <table class="table">

            <h1 class="h1">Customer Transactions</h1>
            <tr class="row header green">
                <th class="cell">First Name</th>
                <th class="cell">Last Name</th>
                <th class="cell">Transaction Dates</th>
                <th class="cell">Dvd Titles</th>
            </tr>
            <?php
            if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer
          INNER JOIN transaction on transaction.cid = customer.id
          INNER JOIN transaction_details on transaction_details.tid = transaction.id
          INNER JOIN rental_details on rental_details.id = transaction_details.rid
          INNER JOIN dvd on dvd.id = rental_details.did
          ORDER BY transaction.date ASC"))) {
                echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
            }

            if (!$stmt->execute()) {
                echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if (!$stmt->bind_result($fname, $lname, $date, $title)) {
                echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while ($stmt->fetch()) {
                echo "<tr class='row'>\n
                <td class='cell'>\n" . $fname . "\n</td>\n
                <td class='cell'>\n" . $lname . "\n</td>\n
                <td class='cell'>\n" . $date . "</td> 
                <td class='cell'>$title</td>
                 </tr>";
            }
            $stmt->close();
            ?>

        </table>

    </div>


    <div>
        <form method="POST" action="addTransaction.php" class="form">

            <fieldset class="fieldset">
                <legend class="legend">Add Movie Rental to Transaction</legend>
                <p>
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.id, customer.lname from customer"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }
                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($id, $lname)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    echo "<legend>Customer Last Name</legend>
                    <select name='cid' class='select'>";
                    while ($stmt->fetch()) {
                        echo "<option value='$id'>$lname</option>";
                    }
                    echo "</select>";
                    $stmt->close();
                    ?>
                </p>
                <p>
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT dvd.id, dvd.title from dvd"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }
                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($did, $title)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    echo "<legend>Movie Title</legend>
                     <select name='did' class='select'>";
                    while ($stmt->fetch()) {
                        echo "<option value='$did'>$title</option>";
                    }
                    echo "</select>";
                    $stmt->close();
                    ?>
                </p>

                <p>
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT rental.id, rental.length from rental"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }
                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($rid, $length)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    echo "<legend>Rental Length</legend>
                    <select name='rid' class='select'>";
                    while ($stmt->fetch()) {
                        echo "<option value='$rid'>$length</option>";
                    }
                    echo "</select>";
                    $stmt->close();
                    ?>
                </p>

                <p>
                    <legend>Tranaction Date</legend>
                    <input type="date" name="date" class="select"/>

                </p>
                <p>
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT store.id, store.city from store"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }
                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($sid, $city)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    echo "<legend>Store Location</legend>
                <select name='sid' class='select'>";
                    while ($stmt->fetch()) {
                        echo "<option value='$sid'>$city</option>";
                    }
                    echo "</select>";
                    $stmt->close();
                    ?>
                </p>

                <input type="submit" value="Click To Add"/>
            </fieldset>

        </form>
    </div>


    <div>
        <form method="POST" action="filterCustomer.php" class="form">
            <fieldset class="fieldset">
                <legend class="legend">Filter By</legend>
                <input type="checkbox" name="filterCustomer"/>Customer Last Name
                <select name="lname" class="select">
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT customer.id, customer.lname FROM customer GROUP BY customer.lname"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($id, $lname)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while ($stmt->fetch()) {
                        echo '<option value="' . $lname . '"> ' . $lname . '</option>\n';
                    }
                    $stmt->close();
                    ?>
                </select>
                <br>

                <input type="checkbox" name="filterDate"/>Transaction Date
                <select name="date" class="select">
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT transaction.id, transaction.date FROM transaction GROUP BY transaction.date"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($id, $date)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while ($stmt->fetch()) {
                        echo '<option value="' . $date . '"> ' . $date . '</option>\n';
                    }
                    $stmt->close();
                    ?>
                </select>
                <br>
                <input type="checkbox" name="filterTitle"/>Movie Title
                <select name="title" class="select">
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT dvd.id, dvd.title FROM dvd GROUP BY dvd.title"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($id, $title)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while ($stmt->fetch()) {
                        echo '<option value="' . $title . '"> ' . $title . '</option>\n';
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
</body>
</html>