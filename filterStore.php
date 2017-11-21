<?php
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
    <a class="active" href="store.php">Stores Inventories</a>
    <a href="customer.php">Customer Transactions</a>
    <a href="employee.php">Employees</a>
</div>

<div class="wrapper">
    <div>
        <table class="table">

            <h1 class="h1">Store</h1>
            <tr class="row header green">
                <th class="cell">Movie Title</th>
                <th class="cell">On Hand</th>
                <th class="cell">Store Location</th>
            </tr>
            <?php
            if ((isset($_POST['filterCity'])) && (!isset($_POST['filterTitle']))) {
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, inventory.quantity, store.city from store
          INNER JOIN inventory on inventory.sid = store.id
          INNER JOIN dvd on dvd.id = inventory.did
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
                if (!$stmt->bind_result($title, $count, $city)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while ($stmt->fetch()) {
                    echo "<tr class='row'>\n<td class='cell'>\n" . $title . "\n</td>\n<td class='cell'>\n" . $count . "\n</td><td class='cell'>$city</td></tr>";
                }
                $stmt->close();
            }
            //Filter by title only
            if ((!isset($_POST['filterCity'])) && (isset($_POST['filterTitle']))) {
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, inventory.quantity, store.city from store
          INNER JOIN inventory on inventory.sid = store.id
          INNER JOIN dvd on dvd.id = inventory.did
          WHERE dvd.title = ?
          ORDER BY store.city ASC"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }
                if (!($stmt->bind_param("s", $_POST['title']))) {
                    echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                }
                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($title, $count, $city)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while ($stmt->fetch()) {
                    echo "<tr class='row'>\n<td class='cell'>\n" . $title . "\n</td>\n<td class='cell'>\n" . $count . "\n</td><td class='cell'>$city</td></tr>";
                }
                $stmt->close();
            }
            //Filter by title and location
            if ((isset($_POST['filterCity'])) && (isset($_POST['filterTitle']))) {
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, inventory.quantity, store.city from store
          INNER JOIN inventory on inventory.sid = store.id
          INNER JOIN dvd on dvd.id = inventory.did
          WHERE store.city = ? AND dvd.title = ?
          ORDER BY store.city ASC"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }
                if (!($stmt->bind_param("ss", $_POST['city'], $_POST['title']))) {
                    echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                }
                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($title, $count, $city)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while ($stmt->fetch()) {
                    echo "<tr class='row'>\n<td class='cell'>\n" . $title . "\n</td>\n<td class='cell'>\n" . $count . "\n</td><td class='cell'>$city</td></tr>";
                }
                $stmt->close();
            }
            //No filters were set
            if ((!isset($_POST['filterCity'])) && (!isset($_POST['filterTitle']))) {
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, inventory.quantity, store.city from store
          INNER JOIN inventory on inventory.sid = store.id
          INNER JOIN dvd on dvd.id = inventory.did
          ORDER BY store.city ASC"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }
                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($title, $count, $city)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while ($stmt->fetch()) {
                    echo "<tr class='row'>\n<td class='cell'>\n" . $title . "\n</td>\n<td class='cell'>\n" . $count . "\n</td><td class='cell'>$city</td></tr>";
                }
                $stmt->close();
            }
            ?>

        </table>
    </div>
    <div>
        <a href="store.php" class="a">Back To Store</a>
    </div>
</div>
</body>
</html>