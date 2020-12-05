<?php
session_start();
include 'checkSessionID.php';
$viewerID = $_SESSION['sessionID'];

//Establishing connection
include_once 'components/dbConnection.php';
$connection = getConnection();

// Output error message if connection unsuccessful.
if (mysqli_connect_errno() || $connection === false) {
    die("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}




?>

<html>
<head>
    <title>Offer Deletion</title>
    <?php include_once("components/imports.php"); ?>
</head>
<body>
<?php include('components/header.php');?>
<div class="pageContent">
    <?php
    if (isset($_GET['offerid'])) {
        $offerid = $_GET['offerid'];

        // Makes sure the offer to be deleted is the same as the passed id and the toUser is the same as the viewing user.
        $query = "DELETE FROM offer WHERE id= '$offerid' AND toUserid = '$viewerID';";
        $qresult = mysqli_query($connection, $query);

        // Print out success message (I am not sure if my condition is correct?)
        if ($qresult) {
            echo '<h1> Offer deleted successfully. </h1>';
            echo '<a href="viewoffers.php">Click here to return to your received offers</a>';
        } // Print out could not complete message
        else {
            echo '<h1>Offer was not deleted successfully.</h1><';
            echo '<a href="viewoffers.php">Click here to return to your received offers</a>';
        }
    }
    ?>
</div>
</body>
</html>
