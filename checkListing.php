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
$userid = $_POST["userid"];
$title = $_POST["title"];
$description = $_POST["description"];
$image = $_POST["image"];

// Make a sql query to see if listing by same user has the same title
$sql = "SELECT id FROM listing WHERE userid = '$userid$' AND title = '$title';";
if (mysqli_query($conn, $sql) -> num_rows >0){
    $listingExists = true;
}else {
    $listingExists = false;
}
if (!$listingExists) {
    $title = $conn->real_escape_string($title);
    $description = $conn->real_escape_string($description);
    $image = $conn->real_escape_string($image);
    $sql = "INSERT INTO listing (title, description, image,userid) VALUES ('$title','$description','$image','$userid');";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Listing successfully posted, redirect to the listing page
        header("Location: viewListing.php?whichListing=" . $conn->insert_id);
        die();
    }else{
        echo $result;
    }
}else{
    echo 'You have already posted a similar listing';
}



