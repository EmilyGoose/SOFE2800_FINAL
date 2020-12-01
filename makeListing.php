<?php

/*no need to access the database on this page
// Get the php.ini file with the db config
$iniConfig = parse_ini_file("php.ini");

$servername = $iniConfig["ip"];
$username = $iniConfig["user"];
$password = $iniConfig["password"];
$database = $iniConfig["database"];;
// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
*/
//link to get back to index page
echo "<a href=\"index.php\">Click here to go to index.php</a>" ."<br>";

session_start();

// Get id of user making the listing
$userid = $_SESSION["sessionID"];

?>

<html>
<head>
    <title>Make a listing</title>
</head>
<body>
    <h1>Make a listing</h1>
    <form action="checkListing.php" method="post">
        <input type="text" name="userid" value="<?php echo $userid ?>" hidden>

        <label for="title">Title your listing: </label>
        <input type="text" name="title" required>
        <br>
        <label for="description">Describe your item: </label>
        <textarea name="description" id="" cols="30" rows="10" required>Enter a description of your listing here.</textarea>
        <br>

        <label for="image">paste a link to your image: </label>
        <input type="text" name="image" required>

        <input type="submit">



    </form>
</body>
</html>
