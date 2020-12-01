<?php
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

$viewerid= $_SESSION["sessionID"];
$query="SELECT username FROM user WHERE id= '$viewerid';";
$qresult = mysqli_query($connection,$query);

// Obtains the data contained for the matching table row using mysqli.
$row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
$username = $row['username'];
?>
<link rel="stylesheet" type="text/css" href="style/headerStyle.css">
<h1 class="headerUsername">Welcome: <?php echo $username?></h1>
<div class="header" id="navbar">
    <nav class="header">
        <a href="index.php">Index/Logout</a>
        <a href="home.php">Home</a>
        <a href="userProfile.php?user=<?php echo $_SESSION['sessionID']?>">Your Profile</a>
        <a href="makeListing.php">Make a Listing</a>
    </nav>
</div>

<!--needed for stopping the snapping motion-->
<div class="content">
</div>
<script type="text/javascript" src="headerScripts.js" ></script>

