<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 2:50 PM
 */

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("", "", "", "");

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
                //user only selected customer
                if ((isset($_POST['filterCustomer'])) && (!isset($_POST['filterDate'])) && (!isset($_POST['filterTitle']))) {
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer
                  INNER JOIN transaction on transaction.cid = customer.id
                  INNER JOIN transaction_details on transaction_details.tid = transaction.id
                  INNER JOIN rental_details on rental_details.id = transaction_details.rid
                  INNER JOIN dvd on dvd.id = rental_details.did
                  WHERE customer.lname = ?
                  ORDER BY transaction.date ASC"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!($stmt->bind_param("s", $_POST['lname']))) {
                        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                    }
                } //user selected customer and date
                else if ((isset($_POST['filterCustomer'])) && (isset($_POST['filterDate'])) && (!isset($_POST['filterTitle']))) {
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer 
                  INNER JOIN transaction on transaction.cid = customer.id
                  INNER JOIN transaction_details on transaction_details.tid = transaction.id
                  INNER JOIN rental_details on rental_details.id = transaction_details.rid
                  INNER JOIN dvd on dvd.id = rental_details.did
                   WHERE customer.lname = ? AND transaction.date = ?
                  ORDER BY transaction.date ASC"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!($stmt->bind_param("ss", $_POST['lname'], $_POST['date']))) {
                        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                    }
                } //user selected customer and date and title (pointless really, but it is an option)
                else if ((isset($_POST['filterCustomer'])) && (isset($_POST['filterDate'])) && (isset($_POST['filterTitle']))) {
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer 
                  INNER JOIN transaction on transaction.cid = customer.id
                  INNER JOIN transaction_details on transaction_details.tid = transaction.id
                  INNER JOIN rental_details on rental_details.id = transaction_details.rid
                  INNER JOIN dvd on dvd.id = rental_details.did
                  WHERE customer.lname = ? AND transaction.date = ? AND dvd.title = ?
                  ORDER BY transaction.date ASC"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!($stmt->bind_param("sss", $_POST['lname'], $_POST['date'], $_POST['title']))) {
                        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                    }
                } //user selected customer and title
                else if ((isset($_POST['filterCustomer'])) && (!isset($_POST['filterDate'])) && (isset($_POST['filterTitle']))) {
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer 
                  INNER JOIN transaction on transaction.cid = customer.id
                  INNER JOIN transaction_details on transaction_details.tid = transaction.id
                  INNER JOIN rental_details on rental_details.id = transaction_details.rid
                  INNER JOIN dvd on dvd.id = rental_details.did
                  WHERE customer.lname = ? AND  dvd.title = ?
                  ORDER BY transaction.date ASC"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!($stmt->bind_param("ss", $_POST['lname'], $_POST['title']))) {
                        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                    }
                } //user selected date and title
                else if ((!isset($_POST['filterCustomer'])) && (isset($_POST['filterDate'])) && (isset($_POST['filterTitle']))) {
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer 
                  INNER JOIN transaction on transaction.cid = customer.id
                  INNER JOIN transaction_details on transaction_details.tid = transaction.id
                  INNER JOIN rental_details on rental_details.id = transaction_details.rid
                  INNER JOIN dvd on dvd.id = rental_details.did
                  WHERE transaction.date = ? AND dvd.title = ?
                  ORDER BY transaction.date ASC"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!($stmt->bind_param("ss", $_POST['date'], $_POST['title']))) {
                        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                    }
                } //user selected just date
                else if ((!isset($_POST['filterCustomer'])) && (isset($_POST['filterDate'])) && (!isset($_POST['filterTitle']))) {
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer 
                  INNER JOIN transaction on transaction.cid = customer.id
                  INNER JOIN transaction_details on transaction_details.tid = transaction.id
                  INNER JOIN rental_details on rental_details.id = transaction_details.rid
                  INNER JOIN dvd on dvd.id = rental_details.did
                  WHERE transaction.date = ? 
                  ORDER BY transaction.date ASC"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!($stmt->bind_param("s", $_POST['date']))) {
                        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                    }
                } //user selected just title
                else if ((!isset($_POST['filterCustomer'])) && (!isset($_POST['filterDate'])) && (isset($_POST['filterTitle']))) {
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer 
                  INNER JOIN transaction on transaction.cid = customer.id
                  INNER JOIN transaction_details on transaction_details.tid = transaction.id
                  INNER JOIN rental_details on rental_details.id = transaction_details.rid
                  INNER JOIN dvd on dvd.id = rental_details.did
                  WHERE dvd.title = ? 
                  ORDER BY transaction.date ASC"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!($stmt->bind_param("s", $_POST['title']))) {
                        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                    }
                } //user didn't select any filters
                else {
                    if (!($stmt = $mysqli->prepare("SELECT  DISTINCT customer.fname, customer.lname, transaction.date, dvd.title from customer 
                  INNER JOIN transaction on transaction.cid = customer.id
                  INNER JOIN transaction_details on transaction_details.tid = transaction.id
                  INNER JOIN rental_details on rental_details.id = transaction_details.rid
                  INNER JOIN dvd on dvd.id = rental_details.did
                  ORDER BY transaction.date ASC"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }
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
                <td class='cell'>$title</td></tr>";
                }
                $stmt->close();
                ?>

            </table>

        </div>
        <div>
            <a href="customer.php" class="a">Back To Customers</a>
        </div>
    </div>

</body>
</html>