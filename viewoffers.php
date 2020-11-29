<?php
session_start();
include 'checkSessionID.php';
$viewerID = $_SESSION['sessionID'];//controls which user's profile is displayed, rn displays the viewing users profile, this

$iniConfig = parse_ini_file("php.ini");

//Establishing server connection
$servername = $iniConfig["ip"];
$dbusername = $iniConfig["user"];
$password = $iniConfig["password"];
$dbname = $iniConfig["database"];
$connection = mysqli_connect ($servername, $dbusername, $password, $dbname);

// Output error message if connection unsuccessful.
if (mysqli_connect_errno() || $connection === false){
    die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
}

?>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <h1>Your Offers:</h1>
        <?php
            // Fetches all offers from table to 
            $query="SELECT * FROM offers WHERE toUserid = '$viewerID';";
            $qresult = mysqli_query($connection, $query);
            while($row = mysql_fetch_assoc($qresult, MYSQLI_ASSOC)){
                $listingid = $row['id'];
                $title = $row['title'];
            }
        ?>
    </body>
</html>