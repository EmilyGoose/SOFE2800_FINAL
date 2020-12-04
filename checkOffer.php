<?php

// Include and call function to connect to db
include_once 'components/dbConnection.php';
$conn = getConnection();

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//link to get back to login page
echo "<a href=\"index.php\">Click here to go to index.php</a>" ."<br>";

session_start();
//echo "session id is: ". $_SESSION['sessionID']."<br>";

// Get post request variables
$fromUserid = $_POST["fromUserid"];
$toUserid = $_POST["toUserid"];
$listingid = $_POST["listingid"];
$contact = $_POST["contact"];
$offerdesc = $_POST["offerdesc"];

// Make a sql query to see if the offer was already made
$sql = "SELECT id FROM offer WHERE fromUserid = '$fromUserid' AND listingid = '$listingid';";
if (mysqli_query($conn, $sql) -> num_rows >0){
    $offerExists = true;
}else {
    $offerExists = false;
}
//if the offer was already made don't make another one
if ($offerExists == true){
    // Redirect back to form with error
    header("Location: makeOffer.php");
    die();
} else{
    $sql = "INSERT INTO offer (fromUserid, toUserid, listingid,contact,offerdesc) VALUES ('$fromUserid','$toUserid','$listingid','$contact','$offerdesc');";
    mysqli_query($conn, $sql);
    // Redirect to sent offers
    header("Location: viewSentOffers.php");
    die();

}


