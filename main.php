<?php
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
<!-- Code to add and style navigation bar from "https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_topnav"
    accessed on 8/14/17
-->
<head>
    <link rel = "stylesheet"
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
        <h1 class="h1">Movies</h1>
            <table class="table">


                <tr class="row header green">
                    <th class="cell">Title</th>
                    <th class="cell">Genre</th>
                    <th class="cell">Rating</th>
                    <th class="cell">Year</th>
                    <th class="cell">Length (mins)</th>
                    <th class="cell">Alter</th>
                </tr>
                <?php
                if (!($stmt = $mysqli->prepare("SELECT dvd.title, dvd.genre, dvd.rating, dvd.year, dvd.length, dvd.id from dvd"))) {
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }

                if (!$stmt->execute()) {
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if (!$stmt->bind_result($title, $genre, $rating, $year, $length, $id)) {
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while ($stmt->fetch()) {
                    echo "<tr class='row'>\n
                            <td class='cell'>\n" . $title . "\n</td>\n
                            <td class='cell'>\n" . $genre . "\n</td>\n
                            <td class='cell'>\n" . $rating . "</td> 
                            <td class='cell'>$year</td>
                            <td class='cell'>" . $length . "</td>
                            <td class='cell'>
                                 <form method=" . "POST " . "action=" . "editMovie.php" . " >
                                    <input type='number' name='id' value = $id style='display: none'/>
                                    <input type= submit value=Edit style='width: 100%'/>
                                </form>
                                <form method=" . "POST " . "action=" . "removeMovie.php" . ">
                                    <input type='number' name='id' value = $id style='display: none'/>
                                    <input type= submit value=Remove style='width: 100%'/>
                                </form>
                            </td>
                        </tr>";
                }
                $stmt->close();
                ?>

            </table>

    </div>


        <form method="post" action="addMovie.php" class="form">

            <fieldset class="fieldset">
                <legend class="legend">Add Movie</legend>
                <legend>Title</legend>
                <input title="Title" type="text" name="title" class="select"/>

                <p>
                    <legend>Genre</legend>
                    <select name="genre" class="select">
                        <option value="Action">Action</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Drama">Drama</option>
                        <option value="Horror">Horror</option>
                        <option value="Romance">Romance</option>
                        <option value="Sci-Fi">Sci-Fi</option>
                        <option value="Thriller">Thriller</option>
                    </select></p>

                <p>
                    <legend>Rating</legend>
                    <select name="rating" class="select">
                        <option value="G">G</option>
                        <option value="PG">PG</option>
                        <option value="PG-13">PG-13</option>
                        <option value="R">R</option>
                        <option value="NC-17">NC-17</option>
                    </select></p>

                <p>
                    <legend>Year</legend>
                    <input type="number" name="year" class="select"/>
                </p>

                <p>
                    <legend>Length</legend>
                    <input type="number" name="length" class="select"/>
                </p>
                <input type="submit" value="Click To Add"/>
            </fieldset>

        </form>

    <div class="form">
        <form method="POST" action="filterMovie.php">
            <fieldset class="fieldset">
                <legend class="legend">Filter By</legend>
                <input type="checkbox" name="filterGenre"/>Genre
                <select name="genre" class="select">
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT dvd.id, dvd.genre FROM dvd GROUP BY dvd.genre"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($id, $genre)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while ($stmt->fetch()) {
                        echo '<option value="' . $genre . '"> ' . $genre . '</option>\n';
                    }
                    $stmt->close();
                    ?>
                </select>
                <br>

                <input type="checkbox" name="filterRating"/>Rating
                <select name="rating" class="select">
                    <?php
                    if (!($stmt = $mysqli->prepare("SELECT dvd.id, dvd.rating FROM dvd GROUP BY dvd.rating"))) {
                        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                    }

                    if (!$stmt->execute()) {
                        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if (!$stmt->bind_result($id, $rating)) {
                        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while ($stmt->fetch()) {
                        echo '<option value="' . $rating . '"> ' . $rating . '</option>\n';
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