<?php
/**
 * Created by PhpStorm.
 * User: Christopher
 * Date: 8/13/2017
 * Time: 10:06 AM
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
    <a class="active" href="main.php">Movies</a>
    <a href="store.php">Stores Inventories</a>
    <a href="customer.php">Customer Transactions</a>
    <a href="employee.php">Employees</a>
</div>

<div class="wrapper">
    <?php
    if (!($stmt = $mysqli->prepare("SELECT  dvd.title, dvd.genre, dvd.rating, dvd.year, dvd.length, dvd.id FROM dvd WHERE dvd.id = ?"))) {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!($stmt->bind_param("i", $_POST['id']))) {
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    }
    if (!$stmt->bind_result($title, $genre, $rating, $year, $length, $id)) {
        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    } else {
        while ($stmt->fetch()) {

            echo "
        <div>
	    <form class='form' method='POST' action='editMovieSubmit.php'>
                 
		<fieldset class='fieldset'>
			<legend class='legend'>Edit Movie</legend>
            <legend>Title</legend>
            <input class='select' title='Title' type='Text' name='title' value='$title'>

			<p><legend>Genre</legend>
            <select class='select' name='genre'>";


            $genreOptions = array('Action', 'Comedy', 'Drama', 'Horror', 'Romance', 'Sci-Fi', 'Thriller');

            foreach ($genreOptions as &$value) {
                if ($value == $genre) {
                    echo "echo<option selected value='$value'>$value</option>";
                } else {
                    echo "echo<option value='$value'>$value</option>";
                }
            }
            unset($value);

            echo "
               </select></p>
			<p><legend>Rating</legend>
			<select class='select' name='rating'>";

            $ratingOptions = array('G', 'PG', 'PG-13', 'R', 'NC-17');

            foreach ($ratingOptions as &$value) {
                if ($value == $rating) {
                    echo "echo<option selected value='$value'>$value</option>";
                } else {
                    echo "echo<option value='$value'>$value</option>";
                }
            }
            unset($value);


            echo "</select></p>

            <p><legend>Year</legend>
                <input class='select' type='number' name='year' value= '$year'/>
            </p>

            <p><legend>Length</legend>
            <input class='select' type='number' name='length' value= '$length'/>
            </p>
            
            <input class='select' type='number' name='id' value='$id' style='display: none'/>
            <input type='submit' value='Submit Edit'/>
        </fieldset>
            
    </form>
</div>
    ";
        }
    }

    ?>
    <div>
        <a href="main.php" class="a">Back To Movies</a>
    </div>
</div>
</body>
</html>

