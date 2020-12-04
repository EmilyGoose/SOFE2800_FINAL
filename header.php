<?php
$iniConfig = parse_ini_file("php.ini");

include_once 'components/dbConnection.php';
$conn = getConnection();

// Output error message if connection unsuccessful.
if (mysqli_connect_errno() || $conn === false){
    die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
}

$viewerid= $_SESSION["sessionID"];
$query="SELECT username FROM user WHERE id= '$viewerid';";
$qresult = mysqli_query($conn,$query);

// Obtains the data contained for the matching table row using mysqli.
$row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
$username = $row['username'];
?>
<link rel="stylesheet" type="text/css" href="style/headerStyle.css">

<h1 class="headerUsername">Welcome: <?php echo $username?></h1>
<div class="header" id="navbar">
    <nav class="header">
        <?php if($_SESSION['sessionID'] != null){
            echo '<a href="index.php">Index/Logout</a>';
            echo '<a href="home.php">Home</a>';
            echo '<a href="userProfile.php?user='.$_SESSION['sessionID'].'">Your Profile</a>';
            echo'<a href="makeListing.php">Make a Listing</a>';
            echo'<a href="viewoffers.php">View Received Offers</a>';
            echo'<a href="viewSentOffers.php">View Sent Offers</a>';
        } else{
            echo '<a href="login.php">Index/Logout</a>';
            echo '<a href="home.php">Home</a>';
        } ?>

    </nav>
</div>

<!--needed for stopping the snapping motion-->
<div class="content">
</div>

<!--used to control sticky class on the header-->
<script type="text/javascript" src="headerScripts.js" ></script>

