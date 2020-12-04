<?php

session_start();

$error = "";

// Make sure the user is authenticated
include_once("checkSessionID.php");

// Get id of user making the listing
$userid = $_SESSION["sessionID"];

// Check if this is a post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Include and call function to connect to db
    include_once 'components/dbConnection.php';
    $conn = getConnection();

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //echo "session id is: ". $_SESSION['sessionID']."<br>";

    // Get post request variables
    $userid = $_POST["userid"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $image = $_POST["image"];

    // Make a sql query to see if listing by same user has the same title
    $sql = "SELECT id FROM listing WHERE userid = '$userid$' AND title = '$title';";
    if (mysqli_query($conn, $sql)->num_rows > 0) {
        $listingExists = true;
    } else {
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
        } else {
            $error = $result;
        }
    } else {
        $error = "You have already posted a similar listing";
    }
}


?>

<html>
<head>
    <title>Make a listing</title>
    <?php include_once("components/imports.php"); ?>
</head>
<body>
<?php include('components/header.php') ?>
<div class="pageContent">
    <h1>Make a listing</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="userid" value="<?php echo $userid ?>" style="display: none">

        <label for="title">Title your listing: </label>
        <input type="text" name="title" required>
        <br>
        <label for="description">Describe your item: </label>
        <textarea name="description" id="" cols="30" rows="10" placeholder="Enter a description of your listing here."
                  required></textarea>
        <br>

        <label for="image">paste a link to your image: </label>
        <input type="text" name="image" required>

        <input type="submit">

        <p class="error"><?php echo $error; ?></p>

    </form>
</div>
</body>
</html>
