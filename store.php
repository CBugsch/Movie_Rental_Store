<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/14/2017
 * Time: 7:32 PM
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
                <th class="cell">Remove Movie</th>
            </tr>
            <?php
            if (!($stmt = $mysqli->prepare("SELECT dvd.title, inventory.quantity, store.city, dvd.id, store.id  from store
          INNER JOIN inventory on inventory.sid = store.id
          INNER JOIN dvd on dvd.id = inventory.did
          ORDER BY store.city ASC"))) {
                echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
            }

            if (!$stmt->execute()) {
                echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if (!$stmt->bind_result($title, $count, $city, $did, $sid)) {
                echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while ($stmt->fetch()) {
                echo "<tr class='row'>\n
                <td class='cell'>\n" . $title . "\n</td>\n
                <td class='cell'>\n" . $count . "\n</td>
                <td class='cell'>$city</td>
                <td class='cell'><form method=" . "POST " . "action=" . "removeInventory.php" . " >
                <input type='text' name='title' value = '$title' style='display: none'/>
                <input type='text' name='city' value = '$city' style='display: none'/>
                <input type='number' name='did' value = $did style='display: none'/>
                <input type='number' name='sid' value = $sid style='display: none'/>
                <input type= submit value='Remove' style='width: 100%'/>
                </form></td> 
            </tr>";
            }
            $stmt->close();
            ?>

        </table>

    </div>

    <div>
        <form method="POST" action="addInventory.php" class="form">

            <fieldset class="fieldset">
                <legend class="legend">Add Movie To Store Inventory</legend>
                <p>
                <?php
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, dvd.id from dvd GROUP BY dvd.title"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }

                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($title, $did)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                echo "<legend>Movie Title:</legend> 
                <select name=did class='select'>";
                while ($stmt->fetch()) {
                    echo "<option value='$did'>$title</option>";
                }
                echo "</select><br>";
                $stmt->close();
                ?>
                </p>


                <p>
                <?php
                if (!($stmt = $mysqli->prepare("SELECT store.id, store.city from store GROUP BY store.city"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }

                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($sid, $city)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                echo "<legend>Store Location:</legend> 
                <select name=sid class='select'>";
                while ($stmt->fetch()) {
                    echo "<option value='$sid'>$city</option>";
                }
                echo "</select>";
                $stmt->close();
                ?>
                </p>
                <p>

                <legend>Quantity:</legend>
                <input type="number" value="1" name="count" class="select"/>
                </p>
                <input type="submit" value="Add Movie To Store"/>
            </fieldset>

        </form>
    </div>
    <div>
        <form method="POST" action="filterStore.php" class="form">
            <fieldset class="fieldset">
                <legend class="legend">Filter By</legend>
                <input type="checkbox" name="filterCity"/>
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
                <input type="checkbox" name="filterTitle"/>
                Movie Title:
                <select name="title" class="select">
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT dvd.title FROM dvd GROUP BY dvd.title"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($title)) {
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