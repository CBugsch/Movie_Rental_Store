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
    <a class="active" href="main.php">Movies</a>
    <a href="store.php">Stores Inventories</a>
    <a href="customer.php">Customer Transactions</a>
    <a href="employee.php">Employees</a>
</div>

<div class="wrapper">
    <div>
        <table class="table">

            <h1 class="h1">Movies</h1>
            <tr class="row header green">
                <th class="cell">Title</th>
                <th class="cell">Genre</th>
                <th class="cell">Rating</th>
                <th class="cell">Length (mins)</th>
            </tr>
            <?php
            if ((isset($_POST['filterGenre'])) && (!isset($_POST['filterRating']))) {
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, dvd.genre, dvd.rating, dvd.length from dvd WHERE dvd.genre = ?"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }
                if (!($stmt->bind_param("s", $_POST['genre']))) {
                    echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                }
                //echo $_POST['genre'];
                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($title, $genre, $rating, $length)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;

                }
                while ($stmt->fetch()) {
                    echo "<tr class='row'>\n
                <td class='cell'>\n" . $title . "\n</td>\n
                <td class='cell'>\n" . $genre . "\n</td>\n
                <td class='cell'>\n" . $rating . "\n</td>\n
                <td class='cell'>\n" . $length . "\n</td>\n</tr>";
                }
                $stmt->close();
            }

            if ((!isset($_POST['filterGenre'])) && (isset($_POST['filterRating']))) {
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, dvd.genre, dvd.rating, dvd.length from dvd WHERE dvd.rating = ?"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }
                if (!($stmt->bind_param("s", $_POST['rating']))) {
                    echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                }
                //echo $_POST['genre'];
                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($title, $genre, $rating, $length)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;

                }
                while ($stmt->fetch()) {
                    echo "<tr class='row'>\n
                <td class='cell'>\n" . $title . "\n</td>\n
                <td class='cell'>\n" . $genre . "\n</td>\n
                <td class='cell'>\n" . $rating . "\n</td>\n
                <td class='cell'>\n" . $length . "\n</td>\n</tr>";
                }
                $stmt->close();
            }

            if ((isset($_POST['filterGenre'])) && (isset($_POST['filterRating']))) {
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, dvd.genre, dvd.rating, dvd.length from dvd WHERE dvd.genre = ? and dvd.rating = ?"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }
                if (!($stmt->bind_param("ss", $_POST['genre'], $_POST['rating']))) {
                    echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                }
                //echo $_POST['genre'];
                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($title, $genre, $rating, $length)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;

                }
                while ($stmt->fetch()) {
                    echo "<tr class='row'>\n
                <td class='cell'>\n" . $title . "\n</td>\n
                <td class='cell'>\n" . $genre . "\n</td>\n
                <td class='cell'>\n" . $rating . "\n</td>\n
                <td class='cell'>\n" . $length . "\n</td>\n</tr>";
                }
                $stmt->close();
            }
            ?>

        </table>
    </div>
    <div>
        <a href="main.php" class="a">Back To Movies</a>
    </div>
</div>

</body>
</html>