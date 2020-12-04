<?php
$iniConfig = parse_ini_file("php.ini");

// Include and call function to connect to db
include_once 'components/dbConnection.php';
$conn = getConnection();

// Output error message if connection unsuccessful.
if (mysqli_connect_errno() || $conn === false) {
    die("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}
if (isset($_SESSION["sessionID"])) {
    $loggedIn = true;
    $viewerid = $_SESSION["sessionID"];
} else {
    $loggedIn = false;
}

//get the username of the logged in user if there is a logged in user
if ($loggedIn == true) {

    $query = "SELECT username FROM user WHERE id= '$viewerid';";
    $qresult = mysqli_query($conn, $query);

    // Obtains the data contained for the matching table row using mysqli.
    $row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
    $username = $row['username'];
} else {
    $username = "please log in";
}
?>


<?php
// Print the header
echo '<div class="header" id="navbar">';
echo '<nav class="header">';
echo '<span class="headerUsername">Welcome, ' . $username . '</span>';
if ($loggedIn) {
    echo '<a href="../logout.php">Logout</a>';
    echo '<a href="../viewSentOffers.php">View Sent Offers</a>';
    echo '<a href="../viewoffers.php">View Received Offers</a>';
    echo '<a href="../makeListing.php">Make a Listing</a>';
    echo '<a href="userProfile.php?user=' . $_SESSION['sessionID'] . '">Your Profile</a>';
} else {
    echo '<a href="login.php">Login/Signup</a>';
}
echo '<a href="index.php">Home</a>';

?>

</nav>
</div>


<!--needed for stopping the snapping motion-->
<div class="content">
</div>

<link rel="stylesheet" type="text/css" href="style/headerStyle.css">
<!--used to control sticky class on the header-->
<script type="text/javascript" src="headerScripts.js"></script>

